@extends('layouts.admin')
@section('title','Edit Pelanggan - Admin')
@section('page-title', 'Edit Pelanggan')
@section('page-description', 'Perbarui data pelanggan')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('pelanggan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Pelanggan
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-pencil-square" style="color:#d97706;"></i> Edit Pelanggan</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('pelanggan.update', $pel->id_pelanggan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control"
                           value="{{ old('nama_pelanggan', $pel->nama_pelanggan) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat_pelanggan" class="form-control" rows="2" required>{{ old('alamat_pelanggan', $pel->alamat_pelanggan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control"
                           value="{{ old('no_telepon', $pel->no_telepon) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email_pelanggan" class="form-control"
                           value="{{ old('email_pelanggan', $pel->email_pelanggan) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                    <a href="{{ route('pelanggan.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
