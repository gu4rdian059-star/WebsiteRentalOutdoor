@extends('layouts.admin')
@section('title', 'Tambah Detail Sewa - Admin')
@section('page-title', 'Tambah Detail Sewa')
@section('page-description', 'Catat rincian item untuk transaksi penyewaan')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('detail_sewa.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Detail Sewa
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-plus-circle-fill" style="color:#1e8e5a;"></i> Tambah Rincian Sewa</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('detail_sewa.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ID Transaksi Sewa</label>
                    <select name="id_sewa" class="form-select" required>
                        <option value="">-- Pilih Transaksi --</option>
                        @foreach($transaksi as $t)
                            <option value="{{ $t->id_sewa }}">#{{ $t->id_sewa }} - {{ $t->pelanggan->nama_pelanggan ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Alat</label>
                    <select name="id_alat" class="form-select" required>
                        <option value="">-- Pilih Alat --</option>
                        @foreach($alat as $a)
                            <option value="{{ $a->id_alat }}">{{ $a->nama_alat }} (Rp {{ number_format($a->harga_sewa, 0, ',', '.') }}/Hari)</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah Sewa</label>
                        <input type="number" name="jumlah_sewa" class="form-control" placeholder="0" required min="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subtotal (Rp)</label>
                        <input type="number" name="subtotal" class="form-control" placeholder="0" required min="0">
                    </div>
                </div>

                <div class="admin-alert admin-alert-info mt-2">
                    <i class="bi bi-info-circle-fill"></i>
                    Pastikan subtotal telah dihitung dengan benar (Harga x Jumlah x Hari).
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Simpan Detail
                    </button>
                    <a href="{{ route('detail_sewa.index') }}" class="btn-outline-green">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
