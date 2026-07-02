@extends('layouts.admin')
@section('title','Edit Alat - Admin')
@section('page-title', 'Edit Alat')
@section('page-description', 'Perbarui data alat outdoor')

@section('content')
<div style="max-width: 700px;">
    <a href="{{ route('alat.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Alat
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-pencil-square" style="color:#d97706;"></i> Edit Alat Outdoor</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('alat.update', $alat->id_alat) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control"
                               value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control"
                               value="{{ old('kategori', $alat->kategori) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control"
                               value="{{ old('stok', $alat->stok) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga Sewa / Hari</label>
                        <input type="number" name="harga_sewa" class="form-control"
                               value="{{ old('harga_sewa', $alat->harga_sewa) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Merk</label>
                        <input type="text" name="merk" class="form-control"
                               value="{{ old('merk', $alat->merk) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kegunaan</label>
                    <textarea name="kegunaan" class="form-control" rows="2">{{ old('kegunaan', $alat->kegunaan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                </div>

                @if ($alat->gambar)
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <img src="{{ asset('images/alat/'.$alat->gambar) }}" style="width:120px;height:120px;object-fit:cover;border-radius:12px;border:2px solid #e8eaed;">
                    </div>
                @endif

                <div class="mb-4">
                    <label class="form-label">Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar" class="form-control">
                    <small style="color:#9aa0a6;">JPG / PNG, max 2MB</small>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                    <a href="{{ route('alat.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
