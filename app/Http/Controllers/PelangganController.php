<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    // 🔥 TAMBAHAN (WAJIB)
    public function show($id)
    {
        $pel = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pel'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pel = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pel'));
    }

    public function update(Request $request, $id)
    {
        $pel = Pelanggan::findOrFail($id);
        $pel->update($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diupdate');
    }

    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus');
    }

    /**
     * Hapus semua data pelanggan (ADMIN)
     */
    public function destroyAll(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        Pelanggan::query()->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Semua data pelanggan telah dihapus.');
    }
}
