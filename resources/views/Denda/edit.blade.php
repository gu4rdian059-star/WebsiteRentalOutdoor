@extends('layouts.admin')
@section('title','Edit Denda - Admin')
@section('page-title', 'Edit Denda')
@section('page-description', 'Perbarui data denda')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('denda.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Denda
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-pencil-square" style="color:#d97706;"></i> Edit Denda</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('denda.update', $denda->id_denda) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Pilih Transaksi</label>
                    <select name="id_sewa" class="form-select" required>
                        @foreach($transaksis as $t)
                            <option value="{{ $t->id_sewa }}" {{ $denda->id_sewa == $t->id_sewa ? 'selected' : '' }}>
                                ID {{ $t->id_sewa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Denda</label>
                        <input type="date" name="tanggal_denda" value="{{ $denda->tanggal_denda }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Batas Waktu</label>
                        <input type="date" name="batas_waktu" value="{{ $denda->batas_waktu }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Denda</label>
                    <input type="text" name="jenis_denda" value="{{ $denda->jenis_denda }}" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Total Denda (Rp)</label>
                    <input type="number" name="total_denda" value="{{ $denda->total_denda }}" class="form-control" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                    <a href="{{ route('denda.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
