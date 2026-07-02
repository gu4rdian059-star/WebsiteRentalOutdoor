@extends('layouts.admin')
@section('title', 'Detail Pelanggan - Admin')
@section('page-title', 'Detail Pelanggan')
@section('page-description', 'Informasi detail pelanggan')

@section('content')
<div style="max-width: 650px;">
    <a href="{{ route('pelanggan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Pelanggan
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-person-lines-fill" style="color:#1e8e5a;"></i> Detail Pelanggan</h5>
            <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn-warning-soft">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>
        <div class="admin-card-body">
            <table class="admin-table" style="border:none;">
                <tr><th style="width:150px;border:none;background:none;text-transform:none;letter-spacing:0;font-weight:600;color:#555;">ID</th><td style="border:none;">{{ $pelanggan->id_pelanggan }}</td></tr>
                <tr><th style="border:none;background:none;text-transform:none;letter-spacing:0;font-weight:600;color:#555;">Nama</th><td style="border:none;">{{ $pelanggan->nama_pelanggan }}</td></tr>
                <tr><th style="border:none;background:none;text-transform:none;letter-spacing:0;font-weight:600;color:#555;">Alamat</th><td style="border:none;">{{ $pelanggan->alamat_pelanggan }}</td></tr>
                <tr><th style="border:none;background:none;text-transform:none;letter-spacing:0;font-weight:600;color:#555;">Email</th><td style="border:none;">{{ $pelanggan->email_pelanggan }}</td></tr>
                <tr><th style="border:none;background:none;text-transform:none;letter-spacing:0;font-weight:600;color:#555;">No Telepon</th><td style="border:none;">{{ $pelanggan->no_telepon }}</td></tr>
                <tr><th style="border:none;background:none;text-transform:none;letter-spacing:0;font-weight:600;color:#555;">No KTP</th><td style="border:none;">{{ $pelanggan->no_ktp }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
