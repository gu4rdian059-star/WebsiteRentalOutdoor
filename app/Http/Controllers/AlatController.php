<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $alats = $query->get();
        return view('alat.index', compact('alats'));
    }

    public function show($id)
    {
        $alat = Alat::findOrFail($id);
        return view('alat.show', compact('alat'));
    }

    public function create()
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'  => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'stok'       => 'required|integer|min:0',
            'harga_sewa' => 'required|integer|min:0',
            'merk'       => 'nullable|string|max:100',
            'kegunaan'   => 'nullable|string',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarName = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('images/alat'), $gambarName);
        }

        Alat::create([
            'nama_alat'  => $request->nama_alat,
            'kategori'   => $request->kategori,
            'stok'       => $request->stok,
            'harga_sewa' => $request->harga_sewa,
            'merk'       => $request->merk,
            'kegunaan'   => $request->kegunaan,
            'deskripsi'  => $request->deskripsi,
            'gambar'     => $gambarName,
        ]);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat'  => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'stok'       => 'required|integer|min:0',
            'harga_sewa' => 'required|integer|min:0',
            'merk'       => 'nullable|string|max:100',
            'kegunaan'   => 'nullable|string',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_alat'  => $request->nama_alat,
            'kategori'   => $request->kategori,
            'stok'       => $request->stok,
            'harga_sewa' => $request->harga_sewa,
            'merk'       => $request->merk,
            'kegunaan'   => $request->kegunaan,
            'deskripsi'  => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            if ($alat->gambar && file_exists(public_path('images/alat/'.$alat->gambar))) {
                unlink(public_path('images/alat/'.$alat->gambar));
            }

            $gambar = $request->file('gambar');
            $gambarName = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('images/alat'), $gambarName);

            $data['gambar'] = $gambarName;
        }

        $alat->update($data);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil diupdate');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        if ($alat->gambar && file_exists(public_path('images/alat/'.$alat->gambar))) {
            unlink(public_path('images/alat/'.$alat->gambar));
        }

        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil dihapus');
    }
}
