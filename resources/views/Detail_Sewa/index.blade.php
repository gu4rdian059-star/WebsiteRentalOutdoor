@extends('layouts.admin')
@section('title', 'Detail Sewa - Admin')
@section('page-title', 'Data Detail Sewa')
@section('page-description', 'Kelola detail sewa')

@section('content')
<div class="page-header">
    <div>
        <h3><i class="bi bi-list-check" style="color:#1e8e5a;"></i> Data Detail Sewa</h3>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('detail_sewa.create') }}" class="btn-green">
            <i class="bi bi-plus-lg"></i> Tambah Detail Sewa
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Sewa</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $d)
                    <tr>
                        <td><strong>{{ $d->id }}</strong></td>
                        <td>
                            <span style="background:linear-gradient(135deg,#1e8e5a,#28c76f);color:#fff;padding:4px 12px;border-radius:6px;font-weight:700;font-size:0.82rem;">
                                #{{ $d->id_sewa }}
                            </span>
                        </td>
                        <td>{{ $d->alat->nama_alat ?? '-' }}</td>
                        <td><span class="status-badge badge-info">x{{ $d->jumlah_sewa }}</span></td>
                        <td style="font-weight:700;color:#1e8e5a;">Rp {{ number_format($d->subtotal) }}</td>
                        <td>
                            <div class="actions-cell" style="justify-content:center;">
                                <a href="{{ route('detail_sewa.edit', $d->id) }}" class="action-edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('detail_sewa.destroy', $d->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="action-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
