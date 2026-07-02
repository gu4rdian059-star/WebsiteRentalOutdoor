<?php

namespace App\Http\Controllers;

use App\Models\DetailSewa;
use App\Models\TransaksiSewa;
use App\Models\Alat;
use Illuminate\Http\Request;

class DetailSewaController extends Controller
{
    public function index()
    {
        $details = DetailSewa::with(['transaksi', 'alat'])->get();
        return view('detail_sewa.index', compact('details'));
    }

    public function create()
    {
        $transaksi = TransaksiSewa::all();
        $alat = Alat::all();
        return view('detail_sewa.create', compact('transaksi', 'alat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_sewa' => 'required',
            'id_alat' => 'required',
            'jumlah_sewa' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ]);

        DetailSewa::create($request->all());

        return redirect()->route('detail_sewa.index')
            ->with('success', 'Detail sewa berhasil ditambahkan!');
    }

    public function edit($id_detail)
    {
        $detail = DetailSewa::findOrFail($id_detail);
        $transaksi = TransaksiSewa::all();
        $alat = Alat::all();

        return view('detail_sewa.edit', compact('detail', 'transaksi', 'alat'));
    }

    public function update(Request $request, $id_detail)
    {
        $request->validate([
            'id_sewa' => 'required',
            'id_alat' => 'required',
            'jumlah_sewa' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ]);

        $detail = DetailSewa::findOrFail($id_detail);
        $detail->update($request->all());

        return redirect()->route('detail_sewa.index')
            ->with('success', 'Detail sewa berhasil diperbarui!');
    }

    public function destroy($id_detail)
    {
        $detail = DetailSewa::findOrFail($id_detail);
        $detail->delete();

        return redirect()->route('detail_sewa.index')
            ->with('success', 'Detail sewa berhasil dihapus!');
    }
}
