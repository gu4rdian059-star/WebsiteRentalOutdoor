@extends('layouts.admin')
@section('title','Tambah Denda - Admin')
@section('page-title', 'Tambah Denda')
@section('page-description', 'Tambah data denda baru')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('denda.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Denda
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-exclamation-diamond-fill" style="color:#dc2626;"></i> Tambah Denda</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('denda.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Transaksi</label>
                    <select name="id_sewa" class="form-select" required>
                        <option value="">-- Pilih Transaksi --</option>
                        @foreach($transaksi as $t)
                            <option value="{{ $t->id_sewa }}">
                                ID {{ $t->id_sewa }} - Rp {{ number_format($t->total_harga,0,',','.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Denda</label>
                        <input type="date" name="tanggal_denda" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Batas Waktu</label>
                        <input type="date" name="batas_waktu" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Denda</label>
                    <input type="text" name="jenis_denda" class="form-control" placeholder="Jenis Denda" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Total Denda (Rp)</label>
                    <input type="number" name="total_denda" class="form-control" placeholder="Total Denda" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                    <a href="{{ route('denda.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
