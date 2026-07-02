<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    // ADMIN: View semua denda
    public function index()
    {
        $dendas = Denda::with('transaksiSewa.pelanggan', 'adminPelayu')->orderBy('id_denda', 'desc')->get();
        return view('denda.index', compact('dendas'));
    }

    // PENYEWA: View denda mereka sendiri
    public function myDenda()
    {
        $userId = Auth::id();
        
        // Get transaksi sewa user via pelanggan -> user relationship
        $dendas = Denda::whereHas('transaksiSewa.pelanggan', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with('transaksiSewa.pelanggan', 'transaksiSewa.alat', 'adminPelayu')
        ->orderBy('id_denda', 'desc')
        ->get();

        return view('denda.my-denda', compact('dendas'));
    }

    // ADMIN: Form potongan denda
    public function editPotongan($id)
    {
        $denda = Denda::with('transaksiSewa.pelanggan', 'transaksiSewa.alat')->findOrFail($id);
        return view('denda.potongan', compact('denda'));
    }

    // ADMIN: Simpan potongan denda
    public function storePotongan(Request $request, $id)
    {
        $request->validate([
            'potongan_denda' => 'required|integer|min:0',
            'alasan_potongan' => 'required|string|min:5',
        ], [
            'potongan_denda.required' => 'Jumlah potongan harus diisi',
            'potongan_denda.integer' => 'Jumlah potongan harus berupa angka',
            'alasan_potongan.required' => 'Alasan potongan harus diisi',
            'alasan_potongan.min' => 'Alasan minimal 5 karakter',
        ]);

        $denda = Denda::findOrFail($id);

        // Validasi: potongan tidak boleh lebih dari total denda
        if ($request->potongan_denda > $denda->total_denda) {
            return redirect()->back()
                ->with('error', 'Potongan tidak boleh lebih dari total denda (' . number_format($denda->total_denda, 0, ',', '.') . ')')
                ->withInput();
        }

        // Update denda dengan potongan
        $denda->update([
            'potongan_denda' => $request->potongan_denda,
            'alasan_potongan' => $request->alasan_potongan,
            'diputuskan_oleh' => Auth::id(),
            'tanggal_potongan' => now(),
        ]);

        return redirect()
            ->route('denda.index')
            ->with('success', "Potongan denda berhasil ditambahkan! Denda akhir: Rp " . number_format($denda->denda_akhir, 0, ',', '.'));
    }

    // ADMIN: Batal potongan denda
    public function cancelPotongan($id)
    {
        $denda = Denda::findOrFail($id);

        $denda->update([
            'potongan_denda' => 0,
            'alasan_potongan' => null,
            'diputuskan_oleh' => null,
            'tanggal_potongan' => null,
        ]);

        return redirect()
            ->route('denda.index')
            ->with('success', 'Potongan denda berhasil dibatalkan!');
    }

    // ADMIN: Delete denda
    public function destroy($id)
    {
        Denda::findOrFail($id)->delete();

        return redirect()
            ->route('denda.index')
            ->with('success', 'Denda berhasil dihapus');
    }
}

