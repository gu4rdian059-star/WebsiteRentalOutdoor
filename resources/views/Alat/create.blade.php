@extends('layouts.admin')
@section('title','Tambah Alat - Admin')
@section('page-title', 'Tambah Alat')
@section('page-description', 'Tambah data alat outdoor baru')

@section('content')
<div style="max-width: 700px;">
    <a href="{{ route('alat.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Alat
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-plus-circle-fill" style="color:#1e8e5a;"></i> Tambah Alat Baru</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" value="{{ old('stok') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga Sewa / Hari</label>
                        <input type="number" name="harga_sewa" class="form-control" min="0" value="{{ old('harga_sewa') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Merk Alat</label>
                        <input type="text" name="merk" class="form-control" value="{{ old('merk') }}" placeholder="Contoh: Eiger">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kegunaan</label>
                    <textarea name="kegunaan" class="form-control" rows="2" placeholder="Digunakan untuk camping, hiking, dll">{{ old('kegunaan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Detail</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Spesifikasi, bahan, keunggulan alat">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Gambar Alat</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    <small style="color:#9aa0a6;">JPG / PNG / WEBP (opsional)</small>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                    <a href="{{ route('alat.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
