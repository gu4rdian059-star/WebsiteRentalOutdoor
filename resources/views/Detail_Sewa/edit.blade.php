@extends('layouts.admin')
@section('title', 'Edit Detail Sewa - Admin')
@section('page-title', 'Edit Detail Sewa')
@section('page-description', 'Perbarui rincian item transaksi penyewaan')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('detail_sewa.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Detail Sewa
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-pencil-square" style="color:#d97706;"></i> Edit Rincian Sewa</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('detail_sewa.update', $detail->id_detail) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ID Transaksi Sewa</label>
                    <select name="id_sewa" class="form-select" required>
                        @foreach($transaksi as $t)
                            <option value="{{ $t->id_sewa }}" {{ $t->id_sewa == $detail->id_sewa ? 'selected' : '' }}>
                                #{{ $t->id_sewa }} - {{ $t->pelanggan->nama_pelanggan ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Alat</label>
                    <select name="id_alat" class="form-select" required>
                        @foreach($alat as $a)
                            <option value="{{ $a->id_alat }}" {{ $a->id_alat == $detail->id_alat ? 'selected' : '' }}>
                                {{ $a->nama_alat }} (Rp {{ number_format($a->harga_sewa, 0, ',', '.') }}/Hari)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah Sewa</label>
                        <input type="number" name="jumlah_sewa" class="form-control" value="{{ old('jumlah_sewa', $detail->jumlah_sewa) }}" required min="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subtotal (Rp)</label>
                        <input type="number" name="subtotal" class="form-control" value="{{ old('subtotal', $detail->subtotal) }}" required min="0">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Perbarui Detail
                    </button>
                    <a href="{{ route('detail_sewa.index') }}" class="btn-outline-green">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
