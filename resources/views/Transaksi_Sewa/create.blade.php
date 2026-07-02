@extends('layouts.admin')
@section('title', 'Tambah Transaksi - Admin')
@section('page-title', 'Tambah Transaksi')
@section('page-description', 'Tambah transaksi sewa baru')

@section('content')
<div style="max-width: 700px;">
    <a href="{{ route('transaksi_sewa.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Transaksi
    </a>

    @if (!isset($alat))
        <div class="admin-alert admin-alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            Alat belum dipilih. Silakan pilih alat terlebih dahulu dari menu alat.
        </div>
    @else
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-journal-plus" style="color:#1e8e5a;"></i> Tambah Transaksi Sewa</h5>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('transaksi_sewa.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_alat" value="{{ $alat->id_alat }}">

                    <div class="mb-3">
                        <label class="form-label">Alat</label>
                        <input type="text" class="form-control" value="{{ $alat->nama_alat }}" readonly style="background:#f8fafb;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="id_pelanggan" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $p)
                                <option value="{{ $p->id_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Sewa</label>
                            <input type="date" name="tanggal_sewa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('transaksi_sewa.index') }}" class="btn-outline-green">Batal</a>
                        <button class="btn-green" type="submit">
                            <i class="bi bi-check-lg"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
