@extends('layouts.admin')
@section('title','Tambah Pelanggan - Admin')
@section('page-title', 'Tambah Pelanggan')
@section('page-description', 'Tambah data pelanggan baru')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('pelanggan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Pelanggan
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-person-plus-fill" style="color:#1e8e5a;"></i> Tambah Pelanggan Baru</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat_pelanggan" class="form-control" rows="2" required>{{ old('alamat_pelanggan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email_pelanggan" class="form-control" value="{{ old('email_pelanggan') }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                    <a href="{{ route('pelanggan.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
