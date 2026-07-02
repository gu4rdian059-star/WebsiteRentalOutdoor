<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Alat;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiSewaController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // admin lihat semua, penyewa lihat miliknya
        $query = TransaksiSewa::with(['pelanggan','alat']);

        if (auth()->check() && auth()->user()->role === 'penyewa') {
            $query->where('user_id', auth()->id());
        }

        $transaksis = $query->orderBy('created_at', 'DESC')->get();

        // Tampilkan status dari database apa adanya - admin yang akan mengubah manual
        // Jangan override status di sini agar perubahan dari admin terlihat oleh penyewa

        // Group transaksi by order_group_id jika ada, atau by id_sewa jika tidak
        $groupedTransaksis = [];
        foreach ($transaksis as $t) {
            $groupKey = $t->order_group_id ?? 'ORDER-' . $t->id_sewa;
            if (!isset($groupedTransaksis[$groupKey])) {
                $groupedTransaksis[$groupKey] = [];
            }
            $groupedTransaksis[$groupKey][] = $t;
        }

        return view('transaksi_sewa.index', compact('groupedTransaksis', 'transaksis'));
    }

    public function create(Request $request)
    {
        // AMBIL ID ALAT DARI QUERY STRING
        $idAlat = $request->query('id_alat');

        if (!$idAlat) {
            return redirect()
                ->route('home')
                ->with('error', 'Alat belum dipilih. Silakan pilih alat terlebih dahulu.');
        }

        $alat = Alat::find($idAlat);

        if (!$alat) {
            return redirect()
                ->route('home')
                ->with('error', 'Alat tidak ditemukan.');
        }

    $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();

    return view('transaksi_sewa.create', compact('alat', 'pelanggans'));
}


    public function store(Request $request)
    {
        \Log::info('Store request received:', $request->all());
        
        // Check if this is from checkout (multiple items)
        if ($request->has('from_checkout') && $request->from_checkout) {
            return $this->storeFromCheckout($request);
        }

        // Original single item flow
        try {
            $validated = $request->validate([
                'id_alat'         => 'required|exists:alats,id_alat',
                'tgl_sewa'        => 'required|date_format:Y-m-d',
                'tgl_kembali'     => 'required|date_format:Y-m-d|after_or_equal:tgl_sewa',
                'deskripsi'       => 'nullable|string',
                'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,cash',
            ]);
            
            \Log::info('Validation passed', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        $alat = Alat::findOrFail($request->id_alat);
        $user = auth()->user();

        \Log::info('User and Alat found', [
            'user_id' => $user?->id,
            'alat_id' => $alat->id_alat
        ]);

        // Buat pelanggan baru dengan data dari user
        $pelanggan = Pelanggan::create([
            'nama_pelanggan'      => $user->name,
            'no_telepon'          => '0822773493433',
            'alamat_pelanggan'    => 'Terdaftar di sistem',
            'email_pelanggan'     => $user->email,
        ]);

        \Log::info('Pelanggan created', ['pelanggan_id' => $pelanggan->id_pelanggan]);

        $tglSewa = Carbon::parse($request->tgl_sewa);
        $tglKembali = Carbon::parse($request->tgl_kembali);
        
        // Hitung jumlah hari: selisih + 1 (termasuk hari pertama)
        $hari = $tglKembali->diffInDays($tglSewa) + 1;
        
        // Jika tanggal sama, minimal 1 hari
        if ($hari <= 0) {
            $hari = 1;
        }
        
        $total = $hari * $alat->harga_sewa;

        \Log::info('Calculating total', [
            'hari' => $hari,
            'harga_sewa' => $alat->harga_sewa,
            'total' => $total
        ]);

        $transaksi = TransaksiSewa::create([
            'user_id'         => $user->id,
            'id_pelanggan'    => $pelanggan->id_pelanggan,
            'id_alat'         => $alat->id_alat,
            'tanggal_sewa'    => $request->tgl_sewa,
            'tanggal_kembali' => $request->tgl_kembali,
            'jumlah_hari'     => $hari,
            'jumlah_satuan'   => 1,
            'total_harga'     => $total,
            'status'          => 'disewa',
            'payment_status'  => 'pending',
        ]);

        // Kurangi stok alat sebesar 1
        $alat->decrement('stok');

        \Log::info('Transaksi created', ['transaksi_id' => $transaksi->id_sewa]);

        return redirect()->route('transaksi_sewa.index')
            ->with('success','Transaksi berhasil dibuat! Metode: ' . ucfirst(str_replace('_', ' ', $request->metode_pembayaran)) . ' | Harga: Rp ' . number_format($total, 0, ',', '.'));
    }

    /**
     * Handle checkout from shopping cart with multiple items
     */
    private function storeFromCheckout(Request $request)
{
    $cartData = json_decode($request->cart_data, true);
    $pajak = floatval($request->pajak ?? 0);
    $user = auth()->user();
    $orderGroupId = 'ORDER-' . uniqid(); // Generate unique group ID

    \Log::info('=== CHECKOUT DEBUG ===');
    \Log::info('Order Group ID:', ['order_group_id' => $orderGroupId]);
    \Log::info('Cart Data:', $cartData ?? []);
    \Log::info('Pajak:', ['pajak' => $pajak]);

    $pelanggan = Pelanggan::create([
        'nama_pelanggan'   => $request->nama_penyewa,
        'email_pelanggan'  => $request->email_penyewa,
        'no_telepon'       => $request->no_telepon,
        'alamat_pelanggan' => $request->alamat_penyewa,
    ]);

    foreach ($cartData as $item) {
        $alat = Alat::findOrFail($item['id_alat']);

        // Gunakan jumlah_hari dari cart item (sudah dihitung di frontend)
        if (isset($item['jumlah_hari']) && $item['jumlah_hari'] > 0) {
            $jumlahHari = intval($item['jumlah_hari']);
        } else {
            $tglSewa    = Carbon::parse($item['tgl_sewa']);
            $tglKembali = Carbon::parse($item['tgl_kembali']);
            $jumlahHari = $tglKembali->diffInDays($tglSewa) + 1;
            if ($jumlahHari <= 0) $jumlahHari = 1;
        }

        $jumlahSatuan = $item['qty'] ?? 1;
        $subtotal = $jumlahHari * $alat->harga_sewa * $jumlahSatuan;
        
        // Total = Subtotal + Pajak (pajak dibagi rata ke setiap item jika ada multiple)
        $total = $subtotal + $pajak;

        \Log::info('Creating Transaksi', [
            'order_group_id' => $orderGroupId,
            'item_from_cart' => $item,
            'jumlah_hari' => $jumlahHari,
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'total' => $total
        ]);

        TransaksiSewa::create([
            'user_id'         => $user->id,
            'id_pelanggan'    => $pelanggan->id_pelanggan,
            'id_alat'         => $alat->id_alat,
            'tanggal_sewa'    => $item['tgl_sewa'],
            'tanggal_kembali' => $item['tgl_kembali'],
            'jumlah_hari'     => $jumlahHari,
            'jumlah_satuan'   => $jumlahSatuan,
            'total_harga'     => $total,
            'status'          => 'disewa',
            'payment_status'  => 'pending',
            'payment_method'  => $request->metode_pembayaran,
            'order_group_id'  => $orderGroupId,
        ]);

        $alat->decrement('stok');
    }

    session()->forget('cart');

    return redirect()->route('transaksi_sewa.index')
        ->with('success', 'Checkout berhasil');
}

    public function payment(Request $request)
    {
        \Log::info('Payment page request:', $request->all());
        
        $request->validate([
            'id_alat'      => 'required|exists:alats,id_alat',
            'tgl_sewa'     => 'required|date_format:Y-m-d',
            'tgl_kembali'  => 'required|date_format:Y-m-d|after_or_equal:tgl_sewa',
            'jumlah_hari'  => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string',
        ]);

        $alat = Alat::findOrFail($request->id_alat);
        
        // Gunakan jumlah hari yang sudah dihitung dari frontend
        $totalHari = (int)$request->jumlah_hari;
        
        // Validasi extra: jika jumlah hari tidak cocok dengan tanggal, recalculate
        $tglSewa = Carbon::parse($request->tgl_sewa);
        $tglKembali = Carbon::parse($request->tgl_kembali);
        $calculatedDays = $tglKembali->diffInDays($tglSewa) + 1;
        
        if ($calculatedDays <= 0) {
            $calculatedDays = 1;
        }
        
        // Gunakan yang lebih besar sebagai safety measure
        if ($totalHari !== $calculatedDays) {
            \Log::warning('Jumlah hari mismatch', [
                'frontend_days' => $totalHari,
                'calculated_days' => $calculatedDays
            ]);
            // Gunakan yang dihitung dari tanggal untuk consistency
            $totalHari = $calculatedDays;
        }
        
        $totalPrice = $totalHari * $alat->harga_sewa;

        \Log::info('Payment page data prepared', [
            'alat_id' => $alat->id_alat,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'total_hari' => $totalHari,
            'total_price' => $totalPrice
        ]);

        return view('transaksi_sewa.payment', [
            'alat' => $alat,
            'tglSewa' => $request->tgl_sewa,
            'tglKembali' => $request->tgl_kembali,
            'totalHari' => $totalHari,
            'totalPrice' => $totalPrice,
            'idAlat' => $request->id_alat,
            'deskripsi' => $request->deskripsi ?? '',
        ]);
    }

    public function edit($id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);

        // penyewa hanya boleh edit miliknya
        if (
            auth()->user()->role === 'penyewa' &&
            $transaksi->user_id !== auth()->id()
        ) {
            abort(403);
        }

        $alats = Alat::all();
        $pelanggans = Pelanggan::all();

        return view('transaksi_sewa.edit', compact(
            'transaksi','alats','pelanggans'
        ));
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);

        // Penyewa hanya boleh edit miliknya, Admin boleh edit semua
        if (auth()->user()->role === 'penyewa' && $transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi tanggal sewa tidak boleh ke masa lalu
        if (Carbon::parse($request->tanggal_sewa)->lt(today()) && $transaksi->status === 'disewa') {
            return back()->withErrors([
                'tanggal_sewa' => 'Tanggal sewa tidak boleh ke masa lalu'
            ]);
        }

        $alat = Alat::findOrFail($request->id_alat);

        $hari = Carbon::parse($request->tanggal_sewa)
            ->diffInDays(Carbon::parse($request->tanggal_kembali));

        $total = max(1, $hari) * $alat->harga_sewa;

        // Jika status terlambat, hitung denda otomatis
        $denda = (int) $request->denda;
        if ($request->status === 'terlambat') {
            $tanggalKembali = Carbon::parse($request->tanggal_kembali)->startOfDay();
            $hariIni = Carbon::now()->startOfDay();
            
            // Jika today > tanggal_kembali, berarti terlambat
            if ($hariIni->gt($tanggalKembali)) {
                // Gunakan diffInDays - urutannya benar: lebih awal - lebih akhir
                $hariTerlambat = $tanggalKembali->diffInDays($hariIni);
            } else {
                $hariTerlambat = 0;
            }
            
            // Override denda hanya jika input denda 0
            if ($denda === 0 && $hariTerlambat > 0) {
                $denda = $hariTerlambat * 5000;
            }
        }

        // Jika status selesai, reset denda ke 0
        if ($request->status === 'selesai') {
            $denda = 0;
        }

        $transaksi->id_pelanggan = $request->id_pelanggan;
        $transaksi->id_alat = $request->id_alat;
        $transaksi->tanggal_sewa = $request->tanggal_sewa;
        $transaksi->tanggal_kembali = $request->tanggal_kembali;
        $transaksi->total_harga = $total;
        $transaksi->denda = $denda;
        $transaksi->status = $request->status;
        $transaksi->save();

        return redirect()->route('transaksi_sewa.index')
            ->with('success','Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        // ❌ hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        TransaksiSewa::findOrFail($id)->delete();

        return redirect()->route('transaksi_sewa.index');
    }

    /**
     * Confirm payment untuk transaksi
     */
    public function confirmPayment($id)
    {
        // Hanya admin yang bisa confirm
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $transaksi = TransaksiSewa::findOrFail($id);

        // Update payment status menjadi confirmed
        $transaksi->payment_status = 'confirmed';
        $transaksi->payment_confirmed_at = now();
        $transaksi->confirmed_by = auth()->id();
        $transaksi->save();

        \Log::info('Payment confirmed', [
            'transaksi_id' => $id,
            'confirmed_by' => auth()->user()->name
        ]);

        return redirect()->route('transaksi_sewa.index')
            ->with('success', 'Pembayaran untuk transaksi ID #' . $id . ' telah dikonfirmasi!');
    }

    /**
     * Detail page untuk penyewa
     */
    public function detailPenyewa($id)
    {
        $transaksi = TransaksiSewa::with(['pelanggan','alat'])->findOrFail($id);

        // Penyewa hanya bisa lihat detail miliknya
        if (auth()->check() && auth()->user()->role === 'penyewa' && $transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil SEMUA transaksi dalam grup yang sama
        $groupKey = $transaksi->order_group_id ?? 'ORDER-' . $transaksi->id_sewa;
        $transaksiGroup = TransaksiSewa::with(['pelanggan','alat'])
            ->where(function($query) use ($transaksi, $groupKey) {
                if ($transaksi->order_group_id) {
                    $query->where('order_group_id', $groupKey);
                } else {
                    $query->where('id_sewa', $transaksi->id_sewa);
                }
            })
            ->get();
        
        // Gunakan transaksi pertama sebagai reference untuk detail pelanggan
        $mainTransaksi = $transaksiGroup->first() ?? $transaksi;

        return view('transaksi_sewa.detail_penyewa', [
            'mainTransaksi' => $mainTransaksi,
            'transaksiGroup' => $transaksiGroup
        ]);
    }

    /**
     * Hapus semua data transaksi (ADMIN)
     */
    public function destroyAll(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        TransaksiSewa::query()->delete();

        return redirect()->route('transaksi_sewa.index')
            ->with('success', 'Semua data transaksi telah dihapus.');
    }

    /**
     * Generate Struk Pembayaran (HTML View)
     */
    public function generateStruk($id)
    {
        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->findOrFail($id);

        // Penyewa hanya bisa lihat struk miliknya
        if (auth()->check() && auth()->user()->role === 'penyewa' && $transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil SEMUA transaksi dalam grup yang sama
        $groupKey = $transaksi->order_group_id ?? 'ORDER-' . $transaksi->id_sewa;
        $transaksiGroup = TransaksiSewa::with(['pelanggan', 'alat'])
            ->where(function($query) use ($transaksi, $groupKey) {
                if ($transaksi->order_group_id) {
                    $query->where('order_group_id', $groupKey);
                } else {
                    $query->where('id_sewa', $transaksi->id_sewa);
                }
            })
            ->get();

        $mainTransaksi = $transaksiGroup->first() ?? $transaksi;
        $totalHarga = $transaksiGroup->sum('total_harga');
        $totalDenda = $mainTransaksi->denda ?? 0;
        $totalBayar = $totalHarga + $totalDenda;

        return view('transaksi_sewa.struk', [
            'transaksi' => $transaksi,
            'transaksiGroup' => $transaksiGroup,
            'mainTransaksi' => $mainTransaksi,
            'totalHarga' => $totalHarga,
            'totalDenda' => $totalDenda,
            'totalBayar' => $totalBayar,
        ]);
    }

    /**
     * Download Struk Pembayaran (PDF)
     */
    public function downloadStruk($id)
    {
        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->findOrFail($id);

        // Penyewa hanya bisa download struk miliknya
        if (auth()->check() && auth()->user()->role === 'penyewa' && $transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil SEMUA transaksi dalam grup yang sama
        $groupKey = $transaksi->order_group_id ?? 'ORDER-' . $transaksi->id_sewa;
        $transaksiGroup = TransaksiSewa::with(['pelanggan', 'alat'])
            ->where(function($query) use ($transaksi, $groupKey) {
                if ($transaksi->order_group_id) {
                    $query->where('order_group_id', $groupKey);
                } else {
                    $query->where('id_sewa', $transaksi->id_sewa);
                }
            })
            ->get();

        $mainTransaksi = $transaksiGroup->first() ?? $transaksi;
        $totalHarga = $transaksiGroup->sum('total_harga');
        $totalDenda = $mainTransaksi->denda ?? 0;
        $totalBayar = $totalHarga + $totalDenda;

        // Generate filename PDF
        $filename = 'struk_pembayaran_' . $transaksi->id_sewa . '_' . date('YmdHis') . '.pdf';

        // Generate HTML
        $html = view('transaksi_sewa.struk', [
            'transaksi' => $transaksi,
            'transaksiGroup' => $transaksiGroup,
            'mainTransaksi' => $mainTransaksi,
            'totalHarga' => $totalHarga,
            'totalDenda' => $totalDenda,
            'totalBayar' => $totalBayar,
            'download' => true,
        ])->render();

        // Buat direktori jika belum ada
        $strukDir = storage_path('app/public/struk');
        if (!file_exists($strukDir)) {
            mkdir($strukDir, 0755, true);
        }

        // Generate PDF menggunakan dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Simpan PDF ke file
        $path = $strukDir . '/' . $filename;
        file_put_contents($path, $dompdf->output());

        // Update database dengan path struk (cek jika kolom ada)
        try {
            $transaksi->struk_path = 'struk/' . $filename;
            $transaksi->save();
        } catch (\Exception $e) {
            // Kolom struk_path belum ada, skip update
            \Log::warning('struk_path column not found, skipping update');
        }

        // Download PDF dengan header yang benar
        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ])->deleteFileAfterSend(false);
    }
}
