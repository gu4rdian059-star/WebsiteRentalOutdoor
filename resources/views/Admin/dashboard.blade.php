@extends('layouts.admin')

@section('title', 'Dashboard - Admin OutdoorRent')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview performa bisnis OutdoorRent')

@section('admin-styles')
<style>
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e8eaed;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card.green::before { background: linear-gradient(90deg, #1e8e5a, #28c76f); }
    .stat-card.blue::before { background: linear-gradient(90deg, #0284c7, #38bdf8); }
    .stat-card.orange::before { background: linear-gradient(90deg, #ea580c, #fb923c); }
    .stat-card.purple::before { background: linear-gradient(90deg, #7c3aed, #a78bfa); }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .stat-card.green .stat-card-icon { background: #e8f5e9; color: #1e8e5a; }
    .stat-card.blue .stat-card-icon { background: #e0f2fe; color: #0284c7; }
    .stat-card.orange .stat-card-icon { background: #fff7ed; color: #ea580c; }
    .stat-card.purple .stat-card-icon { background: #f3e8ff; color: #7c3aed; }

    .stat-card-label {
        font-size: 0.82rem;
        color: #9aa0a6;
        font-weight: 500;
        text-align: right;
    }

    .stat-card-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a1d23;
        line-height: 1.2;
    }

    .stat-card-subtitle {
        font-size: 0.82rem;
        color: #9aa0a6;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stat-card-subtitle .trend-up {
        color: #1e8e5a;
        font-weight: 600;
    }

    .stat-card-subtitle .trend-down {
        color: #dc2626;
        font-weight: 600;
    }

    /* Dashboard grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 991.98px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 30px;
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 20px 15px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eaed;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .quick-action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: #1e8e5a;
    }

    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .quick-action-btn span {
        font-size: 0.82rem;
        font-weight: 600;
        color: #333;
    }

    /* Recent table */
    .recent-section {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e8eaed;
        overflow: hidden;
    }

    .recent-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e8eaed;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .recent-header h5 {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1a1d23;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .recent-header a {
        color: #1e8e5a;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .recent-header a:hover {
        text-decoration: underline;
    }

    /* Warning cards */
    .warning-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e8eaed;
        overflow: hidden;
    }

    .warning-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e8eaed;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .warning-card-header h5 {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1a1d23;
        margin: 0;
    }

    .warning-card-body {
        padding: 16px 24px;
        max-height: 350px;
        overflow-y: auto;
    }

    .warning-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .warning-item:last-child {
        border-bottom: none;
    }

    .warning-item-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .warning-item-icon {
        width: 36px;
        height: 36px;
        background: #fef2f2;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        font-size: 0.9rem;
    }

    .warning-item-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: #333;
    }

    .warning-item-badge {
        background: #fecaca;
        color: #dc2626;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Recent transaction items */
    .recent-txn-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 24px;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.2s;
    }

    .recent-txn-item:last-child {
        border-bottom: none;
    }

    .recent-txn-item:hover {
        background: #f8fafb;
    }

    .recent-txn-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e8e5a, #28c76f);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .recent-txn-info {
        flex: 1;
    }

    .recent-txn-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1a1d23;
    }

    .recent-txn-detail {
        font-size: 0.78rem;
        color: #9aa0a6;
    }

    .recent-txn-amount {
        font-weight: 700;
        color: #1e8e5a;
        font-size: 0.95rem;
        text-align: right;
    }

    .recent-txn-date {
        font-size: 0.75rem;
        color: #9aa0a6;
        text-align: right;
    }
</style>
@endsection

@section('content')
    {{-- ⚠️ WARNING STOK KOSONG --}}
    @if($stokKosong > 0)
        <div class="admin-alert admin-alert-warning alert-dismissible fade show" role="alert" style="position:relative;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem;"></i>
            <div>
                <strong>⚠️ Peringatan!</strong> {{ $stokKosong }} alat memiliki stok kosong dan perlu diisi ulang.
                <a href="{{ route('alat.index') }}" style="color: #92400e; font-weight:600; margin-left:5px;">Lihat Detail →</a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="position:absolute;right:15px;top:50%;transform:translateY(-50%);"></button>
        </div>
    @endif

    <!-- ========== STATS CARDS ========== -->
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-receipt"></i>
                </div>
                <span class="stat-card-label">Bulan Ini</span>
            </div>
            <div class="stat-card-value">{{ $transaksiBulanIni }}</div>
            <div class="stat-card-subtitle">
                <i class="bi bi-graph-up-arrow"></i>
                Transaksi Bulan Ini
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <span class="stat-card-label">Bulan Ini</span>
            </div>
            <div class="stat-card-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            <div class="stat-card-subtitle">
                <i class="bi bi-cash-stack"></i>
                Pendapatan Bulan Ini
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-clipboard-data"></i>
                </div>
                <span class="stat-card-label">All Time</span>
            </div>
            <div class="stat-card-value">{{ $totalTransaksi }}</div>
            <div class="stat-card-subtitle">
                <i class="bi bi-bar-chart"></i>
                Total Transaksi
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>
                <span class="stat-card-label">All Time</span>
            </div>
            <div class="stat-card-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="stat-card-subtitle">
                <i class="bi bi-gem"></i>
                Total Pendapatan
            </div>
        </div>
    </div>

    <!-- ========== QUICK ACTIONS ========== -->
    <div class="quick-actions">
        <a href="{{ route('alat.create') }}" class="quick-action-btn">
            <div class="quick-action-icon" style="background: #e8f5e9; color: #1e8e5a;">
                <i class="bi bi-plus-circle-fill"></i>
            </div>
            <span>Tambah Alat</span>
        </a>
        <a href="{{ route('pelanggan.create') }}" class="quick-action-btn">
            <div class="quick-action-icon" style="background: #e0f2fe; color: #0284c7;">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <span>Tambah Pelanggan</span>
        </a>
        <a href="{{ route('transaksi_sewa.create') }}" class="quick-action-btn">
            <div class="quick-action-icon" style="background: #fff7ed; color: #ea580c;">
                <i class="bi bi-journal-plus"></i>
            </div>
            <span>Tambah Transaksi</span>
        </a>
        <a href="{{ route('denda.create') }}" class="quick-action-btn">
            <div class="quick-action-icon" style="background: #fef2f2; color: #dc2626;">
                <i class="bi bi-exclamation-diamond-fill"></i>
            </div>
            <span>Tambah Denda</span>
        </a>
        <a href="{{ route('settings.edit') }}" class="quick-action-btn">
            <div class="quick-action-icon" style="background: #f3e8ff; color: #7c3aed;">
                <i class="bi bi-gear-fill"></i>
            </div>
            <span>Pengaturan</span>
        </a>
    </div>

    <!-- ========== MAIN CONTENT GRID ========== -->
    <div class="dashboard-grid">
        <!-- Recent Transactions -->
        <div class="recent-section">
            <div class="recent-header">
                <h5><i class="bi bi-clock-history"></i> Transaksi Terbaru</h5>
                <a href="{{ route('transaksi_sewa.index') }}">Lihat Semua →</a>
            </div>
            @if($recentTransaksi->count() > 0)
                @foreach($recentTransaksi as $txn)
                    <div class="recent-txn-item">
                        <div class="recent-txn-avatar">
                            {{ strtoupper(substr($txn->pelanggan->nama_pelanggan ?? 'U', 0, 2)) }}
                        </div>
                        <div class="recent-txn-info">
                            <div class="recent-txn-name">{{ $txn->pelanggan->nama_pelanggan ?? '-' }}</div>
                            <div class="recent-txn-detail">
                                {{ $txn->alat->nama_alat ?? '-' }}
                                @if($txn->jumlah_satuan > 1) (x{{ $txn->jumlah_satuan }}) @endif
                                · {{ $txn->jumlah_hari }} hari
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div class="recent-txn-amount">Rp {{ number_format($txn->total_harga, 0, ',', '.') }}</div>
                            <div class="recent-txn-date">{{ $txn->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                    <h5>Belum ada transaksi</h5>
                    <p>Transaksi terbaru akan muncul di sini</p>
                </div>
            @endif
        </div>

        <!-- Stok Warning / Info Panel -->
        <div class="warning-card">
            <div class="warning-card-header">
                <i class="bi bi-box-seam" style="font-size:1.2rem; color:#1e8e5a;"></i>
                <h5>Informasi Stok</h5>
            </div>
            <div class="warning-card-body">
                @if($stokKosong > 0)
                    <div style="background:#fef2f2; border-radius:10px; padding:14px; margin-bottom:16px;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                            <i class="bi bi-exclamation-triangle-fill" style="color:#dc2626;"></i>
                            <strong style="color:#991b1b; font-size:0.88rem;">{{ $stokKosong }} Stok Kosong</strong>
                        </div>
                        @foreach($alatStokKosong as $alat)
                            <div class="warning-item" style="padding:8px 0;">
                                <div class="warning-item-info">
                                    <div class="warning-item-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <span class="warning-item-name">{{ $alat->nama_alat }}</span>
                                </div>
                                <span class="warning-item-badge">Stok: {{ $alat->stok }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="background:#f0fdf4; border-radius:10px; padding:14px; margin-bottom:16px; text-align:center;">
                        <i class="bi bi-check-circle-fill" style="color:#1e8e5a; font-size:1.5rem;"></i>
                        <p style="color:#166534; font-weight:600; margin:8px 0 0; font-size:0.88rem;">Semua stok aman!</p>
                    </div>
                @endif

                <!-- Quick Stats -->
                <div style="padding-top:10px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:0.85rem; color:#666;">Total Jenis Alat</span>
                        <strong style="color:#1a1d23;">{{ $totalAlat }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:0.85rem; color:#666;">Total Pelanggan</span>
                        <strong style="color:#1a1d23;">{{ $totalPelanggan }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:0.85rem; color:#666;">Sedang Disewa</span>
                        <strong style="color:#d97706;">{{ $sedangDisewa }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0;">
                        <span style="font-size:0.85rem; color:#666;">Total Denda Aktif</span>
                        <strong style="color:#dc2626;">{{ $totalDenda }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
