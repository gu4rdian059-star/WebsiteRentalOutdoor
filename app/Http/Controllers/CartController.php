<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $cart = session()->get('cart', []); // ← WAJIB ADA
        $total = 0;

        foreach ($cart as &$item) {
            if (!isset($item['qty'])) {
                $item['qty'] = 1;
                $item['subtotal'] =
                    $item['harga_sewa'] * $item['jumlah_hari'] * $item['qty'];
            }

            $total += $item['subtotal'];
        }

        session()->put('cart', $cart);

        return view('cart.index', compact('cart', 'total'));
    }


    /**
     * Add item to cart (WAJIB LOGIN)
     */
    public function add(Request $request)
    {
        // 🔒 CEK LOGIN (FIX ERROR)
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu untuk menyewa alat'
                ], 401);
            }
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk menyewa alat');
        }

        $validated = $request->validate([
            'id_alat'     => 'required|exists:alats,id_alat',
            'tgl_sewa'    => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_sewa',
            'quantity'    => 'nullable|integer|min:1',
            'jumlah_hari' => 'nullable|integer|min:1',
        ]);

        $quantity = $validated['quantity'] ?? 1;

        $alat = Alat::findOrFail($validated['id_alat']);

        // 🔒 CEK STOK ALAT
        if ($alat->stok <= 0) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, stok ' . $alat->nama_alat . ' sedang kosong. Silakan pilih alat lain.'
                ], 422);
            }
            return back()->with('error', 'Maaf, stok ' . $alat->nama_alat . ' sedang kosong.');
        }

        // Hitung jumlah hari
        $tglSewa    = new \DateTime($validated['tgl_sewa']);
        $tglKembali = new \DateTime($validated['tgl_kembali']);

        // Gunakan jumlah_hari dari frontend jika ada, kalau tidak hitung dari tanggal
        if (!empty($validated['jumlah_hari'])) {
            $jumlahHari = $validated['jumlah_hari'];
        } else {
            $jumlahHari = $tglSewa->diff($tglKembali)->days + 1;
        }

        if ($jumlahHari < 1) {
            $jumlahHari = 1;
        }

        // Hitung subtotal: (Harga per hari × Jumlah hari) × Quantity
        $subtotal = $alat->harga_sewa * $jumlahHari * $quantity;

        $cart = session()->get('cart', []);

        $cartKey = $validated['id_alat'].'_'.$validated['tgl_sewa'].'_'.$validated['tgl_kembali'];

        $cart[$cartKey] = [
            'id_alat'     => $alat->id_alat,
            'nama_alat'   => $alat->nama_alat,
            'kategori'    => $alat->kategori,
            'gambar'      => $alat->gambar,
            'harga_sewa'  => $alat->harga_sewa,
            'tgl_sewa'    => $validated['tgl_sewa'],
            'tgl_kembali' => $validated['tgl_kembali'],
            'jumlah_hari' => $jumlahHari,
            'qty'         => $quantity,
            'subtotal'    => $subtotal,
        ];


        session()->put('cart', $cart);

        // AJAX RESPONSE (TIDAK PINDAH HALAMAN)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $alat->nama_alat . ' berhasil dimasukkan ke keranjang',
                'cart_count' => count(session()->get('cart', []))
            ]);
        }

        return back()->with(
            'success',
            $alat->nama_alat . ' berhasil dimasukkan ke keranjang'
        );
    }

    /**
 * 🔥 SEWA SEKARANG
 * auto 1 hari (hari ini - besok)
 * langsung ke checkout (tanpa halaman cart)
 */
public function sewaSekarang(Request $request)
{
    if (!auth()->check()) {
        return redirect()
            ->route('login')
            ->with('error', 'Silakan login terlebih dahulu');
    }

    $validated = $request->validate([
        'id_alat' => 'required|exists:alats,id_alat',
    ]);

    $alat = Alat::findOrFail($validated['id_alat']);

    // 🔒 CEK STOK ALAT
    if ($alat->stok <= 0) {
        return back()->with('error', 'Maaf, stok ' . $alat->nama_alat . ' sedang kosong.');
    }

    // AUTO TANGGAL
    $tglSewa    = now()->toDateString();
    $tglKembali = now()->addDay()->toDateString();
    $jumlahHari = 1;

    // 🔥 KOSONGKAN CART
    session()->forget('cart');

    $cartKey = $alat->id_alat.'_'.$tglSewa.'_'.$tglKembali;

    $cart[$cartKey] = [
        'id_alat'     => $alat->id_alat,
        'nama_alat'   => $alat->nama_alat,
        'kategori'    => $alat->kategori,
        'gambar'      => $alat->gambar,
        'harga_sewa'  => $alat->harga_sewa,
        'tgl_sewa'    => $tglSewa,
        'tgl_kembali' => $tglKembali,
        'jumlah_hari' => $jumlahHari,
        'qty'         => 1,
        'subtotal'    => $alat->harga_sewa * $jumlahHari,
    ];

    session()->put('cart', $cart);

    // 🚀 LANGSUNG KE CHECKOUT
    return redirect()->route('cart.checkout');
}

    public function increaseQty($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            // 🔥 JIKA qty BELUM ADA
            if (!isset($cart[$cartKey]['qty'])) {
                $cart[$cartKey]['qty'] = 1;
            }

            $cart[$cartKey]['qty'] += 1;

            $cart[$cartKey]['subtotal'] =
                $cart[$cartKey]['harga_sewa']
                * $cart[$cartKey]['jumlah_hari']
                * $cart[$cartKey]['qty'];

            session()->put('cart', $cart);
        }

        return back();
    }

    public function decreaseQty($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey]) && $cart[$cartKey]['qty'] > 1) {
            $cart[$cartKey]['qty'] -= 1;

            $cart[$cartKey]['subtotal'] =
                $cart[$cartKey]['harga_sewa']
                * $cart[$cartKey]['jumlah_hari']
                * $cart[$cartKey]['qty'];

            session()->put('cart', $cart);
        }

        return back();
    }

    /**
     * Remove item
     */
    public function remove($cartKey)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item dihapus dari keranjang');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        session()->forget('cart');

        return back()->with('success', 'Keranjang dikosongkan');
    }

    /**
     * Checkout
     */
    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah ada parameter dari sewa langsung (tanpa cart)
        if ($request->has('id_alat') && $request->has('tgl_sewa') && $request->has('tgl_kembali')) {
            $idAlat = $request->get('id_alat');
            $tglSewa = $request->get('tgl_sewa');
            $tglKembali = $request->get('tgl_kembali');
            $jumlahHariParam = $request->get('jumlah_hari');

            // Ambil data alat dari database
            $alat = Alat::find($idAlat);
            
            if (!$alat) {
                return back()->with('error', 'Alat tidak ditemukan');
            }

            // 🔒 CEK STOK ALAT
            if ($alat->stok <= 0) {
                return back()->with('error', 'Maaf, stok ' . $alat->nama_alat . ' sedang kosong.');
            }

            // Hitung jumlah hari - gunakan parameter dari frontend jika ada
            if (!empty($jumlahHariParam)) {
                $jumlahHari = intval($jumlahHariParam);
            } else {
                $start = Carbon::parse($tglSewa);
                $end = Carbon::parse($tglKembali);
                $jumlahHari = $end->diffInDays($start) + 1;
            }
            
            if ($jumlahHari <= 0) {
                $jumlahHari = 1;
            }

            // Buat item cart sementara
            $cart = [
                [
                    'id_alat' => $alat->id_alat,
                    'nama_alat' => $alat->nama_alat,
                    'gambar' => $alat->gambar,
                    'harga_sewa' => $alat->harga_sewa,
                    'tgl_sewa' => $tglSewa,
                    'tgl_kembali' => $tglKembali,
                    'jumlah_hari' => $jumlahHari,
                    'qty' => 1,
                    'subtotal' => $alat->harga_sewa * $jumlahHari
                ]
            ];

            $total = $alat->harga_sewa * $jumlahHari;
        } else {
            // Ambil dari session (cart biasa)
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return back()->with('error', 'Keranjang masih kosong');
            }

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['subtotal'];
            }
        }

        return view('cart.checkout', compact('cart', 'total'));
    }
}
