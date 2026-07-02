@extends('layouts.admin')
@section('title','Data Denda - Admin')
@section('page-title', 'Data Denda')
@section('page-description', 'Kelola denda dan potongan penyewaan')

@section('content')
<div class="page-header">
    <div>
        <h3><i class="bi bi-exclamation-triangle-fill" style="color:#dc2626;"></i> Data Denda</h3>
        <p>Kelola denda dan potongan penyewaan alat outdoor</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('denda.create') }}" class="btn-green">
            <i class="bi bi-plus-lg"></i> Tambah Denda
        </a>
    </div>
</div>

@if($dendas->count() > 0)
    @php
        $totalDenda = $dendas->sum('total_denda');
        $totalPotongan = $dendas->sum('potongan_denda');
        $totalDendaAkhir = $dendas->sum('denda_akhir');
    @endphp

    <!-- Stats Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:25px;">
        <div class="admin-card" style="border-top:3px solid #dc2626;">
            <div class="admin-card-body" style="padding:20px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;background:#fef2f2;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#dc2626;font-size:1.2rem;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:#1a1d23;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                        <div style="font-size:0.8rem;color:#9aa0a6;">Total Denda</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-card" style="border-top:3px solid #1e8e5a;">
            <div class="admin-card-body" style="padding:20px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;background:#e8f5e9;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#1e8e5a;font-size:1.2rem;">
                        <i class="bi bi-scissors"></i>
                    </div>
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:#1a1d23;">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</div>
                        <div style="font-size:0.8rem;color:#9aa0a6;">Total Potongan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-card" style="border-top:3px solid #0284c7;">
            <div class="admin-card-body" style="padding:20px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;background:#e0f2fe;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#0284c7;font-size:1.2rem;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:#1a1d23;">Rp {{ number_format($totalDendaAkhir, 0, ',', '.') }}</div>
                        <div style="font-size:0.8rem;color:#9aa0a6;">Denda Akhir</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="admin-card" style="border-top:3px solid #d97706;">
            <div class="admin-card-body" style="padding:20px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#d97706;font-size:1.2rem;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div style="font-size:1.3rem;font-weight:800;color:#1a1d23;">{{ $dendas->count() }}</div>
                        <div style="font-size:0.8rem;color:#9aa0a6;">Jumlah Denda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="admin-card">
        <div class="admin-card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Sewa</th>
                            <th>Pelanggan</th>
                            <th>Alat</th>
                            <th>Jenis Denda</th>
                            <th>Total Denda</th>
                            <th>Potongan</th>
                            <th>Denda Akhir</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dendas as $i => $d)
                            <tr>
                                <td><strong>{{ $i + 1 }}</strong></td>
                                <td>
                                    <span style="background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;padding:4px 12px;border-radius:6px;font-weight:700;font-size:0.82rem;">
                                        #{{ $d->id_sewa }}
                                    </span>
                                </td>
                                <td>{{ $d->transaksiSewa->pelanggan->nama_pelanggan }}</td>
                                <td>{{ $d->transaksiSewa->alat->nama_alat }}</td>
                                <td>
                                    <span class="status-badge badge-warning">{{ ucfirst($d->jenis_denda) }}</span>
                                </td>
                                <td style="font-weight:800;color:#dc2626;">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                                <td>
                                    @if($d->potongan_denda > 0)
                                        <span class="status-badge badge-success">
                                            <i class="bi bi-scissors"></i>
                                            Rp {{ number_format($d->potongan_denda, 0, ',', '.') }}
                                        </span>
                                        <div style="margin-top:4px;">
                                            <small style="color:#1e8e5a;font-weight:600;">
                                                {{ round(($d->potongan_denda / $d->total_denda) * 100, 1) }}%
                                            </small>
                                        </div>
                                    @else
                                        <span style="color:#9aa0a6;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color:#0284c7;font-size:1.05rem;">Rp {{ number_format($d->denda_akhir, 0, ',', '.') }}</strong>
                                    @if($d->denda_akhir == 0)
                                        <div style="margin-top:4px;">
                                            <span class="status-badge badge-success">
                                                <i class="bi bi-check-circle"></i> Lunas
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions-cell" style="justify-content:center;">
                                        <a href="{{ route('denda.editPotongan', $d->id_denda) }}" class="action-view" title="Potongan">
                                            <i class="bi bi-scissors"></i>
                                        </a>
                                        <form action="{{ route('denda.destroy', $d->id_denda) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-delete" title="Hapus"
                                                    onclick="return confirm('Hapus denda ini?')">
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
@else
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
            <h5>Belum ada data denda</h5>
            <p>Klik tombol "Tambah Denda" untuk membuat data denda baru</p>
            <a href="{{ route('denda.create') }}" class="btn-green">
                <i class="bi bi-plus-lg"></i> Tambah Denda
            </a>
        </div>
    </div>
@endif
@endsection
