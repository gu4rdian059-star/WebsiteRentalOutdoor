@extends('layouts.admin')
@section('title','Data Pelanggan - Admin')
@section('page-title', 'Data Pelanggan')
@section('page-description', 'Kelola data pelanggan OutdoorRent')

@section('content')
<div class="page-header">
    <div>
        <h3><i class="bi bi-people-fill" style="color:#1e8e5a;"></i> Data Pelanggan</h3>
        <p>Total {{ $pelanggan->count() }} pelanggan terdaftar</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('pelanggan.create') }}" class="btn-green">
            <i class="bi bi-plus-lg"></i> Tambah Pelanggan
        </a>
        <form action="{{ route('pelanggan.destroyAll') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn-danger-soft"
                    onclick="return confirm('Yakin ingin menghapus SEMUA data pelanggan? Tindakan ini tidak dapat dibatalkan.')">
                <i class="bi bi-trash3"></i> Hapus Semua
            </button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:60px;">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Email</th>
                        <th style="width:140px; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggan as $i => $p)
                    <tr>
                        <td><strong>{{ $i+1 }}</strong></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px;height:36px;background:linear-gradient(135deg,#1e8e5a,#28c76f);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem;flex-shrink:0;">
                                    {{ strtoupper(substr($p->nama_pelanggan, 0, 2)) }}
                                </div>
                                <strong>{{ $p->nama_pelanggan }}</strong>
                            </div>
                        </td>
                        <td>{{ $p->alamat_pelanggan }}</td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>{{ $p->email_pelanggan }}</td>
                        <td>
                            <div class="actions-cell" style="justify-content:center;">
                                <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="action-edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-delete" title="Hapus"
                                            onclick="return confirm('Hapus data pelanggan ini?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @if($pelanggan->count() == 0)
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                                <h5>Data pelanggan masih kosong</h5>
                                <p>Klik tombol "Tambah Pelanggan" untuk menambahkan data baru</p>
                                <a href="{{ route('pelanggan.create') }}" class="btn-green">
                                    <i class="bi bi-plus-lg"></i> Tambah Pelanggan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
