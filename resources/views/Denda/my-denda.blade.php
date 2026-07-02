@extends('layouts.app')

@section('title', 'Denda Saya')

@section('content')
<style>
/* ========== HERO SECTION ========== */
.my-denda-hero {
    position: relative;
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
    border-radius: 24px;
    padding: 50px 40px;
    margin-bottom: 35px;
    overflow: hidden;
}

.my-denda-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.my-denda-hero-content {
    position: relative;
    z-index: 1;
}

.my-denda-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    border: 1px solid rgba(255,255,255,0.3);
}

.my-denda-hero-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
}

.my-denda-hero-subtitle {
    font-size: 1rem;
    color: rgba(255,255,255,0.85);
}

/* ========== STATS CARDS ========== */
.my-denda-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 35px;
}

.my-denda-stat-card {
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
}

.my-denda-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.my-denda-stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}

.my-denda-stat-icon.total { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626; }
.my-denda-stat-icon.potongan { background: linear-gradient(135deg, #d4f4e5 0%, #a7f3d0 100%); color: #0d9668; }
.my-denda-stat-icon.akhir { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7; }
.my-denda-stat-icon.count { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706; }

.my-denda-stat-content h4 {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

.my-denda-stat-content p {
    font-size: 0.95rem;
    color: #64748b;
    margin: 6px 0 0 0;
}

/* ========== DENDA CARDS ========== */
.my-denda-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 25px;
}

.my-denda-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.my-denda-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    border-color: rgba(220, 38, 38, 0.2);
}

.my-denda-card-header {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    padding: 25px;
    border-bottom: 1px solid #fecaca;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.my-denda-card-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 1.15rem;
    margin: 0;
}

.my-denda-card-title span {
    color: #dc2626;
}

.my-denda-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.my-denda-status.active {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
}

.my-denda-status.potong {
    background: linear-gradient(135deg, #d4f4e5 0%, #a7f3d0 100%);
    color: #0d9668;
}

.my-denda-card-body {
    padding: 25px;
}

.my-denda-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.my-denda-info-item {
    background: #f8fafc;
    padding: 16px;
    border-radius: 12px;
    border-left: 4px solid #dc2626;
}

.my-denda-info-label {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.my-denda-info-value {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
}

/* Calculation Section */
.my-denda-calculation {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #fecaca;
}

.my-denda-calc-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px dashed #fecaca;
}

.my-denda-calc-row:last-child {
    border-bottom: none;
}

.my-denda-calc-label {
    color: #64748b;
    font-weight: 500;
}

.my-denda-calc-value {
    color: #dc2626;
    font-weight: 700;
}

.my-denda-calc-value.potongan {
    color: #0d9668;
}

.my-denda-calc-row.total {
    border-top: 2px solid #dc2626;
    margin-top: 10px;
    padding-top: 15px;
}

.my-denda-calc-row.total .my-denda-calc-value {
    font-size: 1.3rem;
    color: #0284c7;
}

/* Lunas Badge */
.my-denda-lunas-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #d4f4e5 0%, #a7f3d0 100%);
    color: #0d9668;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 700;
    margin-top: 10px;
}

/* Alasan Potongan */
.my-denda-alasan {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid #d97706;
    margin-top: 20px;
}

.my-denda-alasan-label {
    font-weight: 700;
    color: #d97706;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.my-denda-alasan-text {
    color: #7c6a00;
    line-height: 1.6;
}

.my-denda-admin-info {
    background: #e0f2fe;
    border-radius: 10px;
    padding: 15px;
    border-left: 4px solid #0284c7;
    margin-top: 12px;
    font-size: 0.9rem;
    color: #0c4a6e;
}

/* Empty State */
.my-denda-empty {
    text-align: center;
    padding: 80px 20px;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-radius: 24px;
    border: 2px dashed #86efac;
}

.my-denda-empty-icon {
    width: 120px;
    height: 120px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    font-size: 3rem;
}

.my-denda-empty h4 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 10px;
}

.my-denda-empty p {
    color: #64748b;
    font-size: 1.1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .my-denda-hero {
        padding: 30px 25px;
    }
    
    .my-denda-hero-title {
        font-size: 1.5rem;
    }
    
    .my-denda-cards {
        grid-template-columns: 1fr;
    }
    
    .my-denda-info-grid {
        grid-template-columns: 1fr;
    }
    
    .my-denda-calc-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>

<div class="container-fluid py-4">
    <!-- Hero Section -->
    <div class="my-denda-hero">
        <div class="my-denda-hero-content">
            <span class="my-denda-hero-badge">
                <i class="bi bi-exclamation-triangle"></i> Riwayat Denda
            </span>
            <h1 class="my-denda-hero-title">Denda Saya</h1>
            <p class="my-denda-hero-subtitle">Lihat riwayat denda dan status pembayaran Anda</p>
        </div>
    </div>

    @if($dendas->count() > 0)
        <!-- Stats Section -->
        @php
            $totalDenda = $dendas->sum('total_denda');
            $totalPotongan = $dendas->sum('potongan_denda');
            $totalDendaAkhir = $dendas->sum(function($d) { return $d->denda_akhir; });
        @endphp

        <div class="my-denda-stats">
            <div class="my-denda-stat-card">
                <div class="my-denda-stat-icon total">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="my-denda-stat-content">
                    <h4>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h4>
                    <p>Total Denda</p>
                </div>
            </div>
            <div class="my-denda-stat-card">
                <div class="my-denda-stat-icon potongan">
                    <i class="bi bi-scissors"></i>
                </div>
                <div class="my-denda-stat-content">
                    <h4>Rp {{ number_format($totalPotongan, 0, ',', '.') }}</h4>
                    <p>Total Potongan</p>
                </div>
            </div>
            <div class="my-denda-stat-card">
                <div class="my-denda-stat-icon akhir">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="my-denda-stat-content">
                    <h4>Rp {{ number_format($totalDendaAkhir, 0, ',', '.') }}</h4>
                    <p>Denda Akhir</p>
                </div>
            </div>
            <div class="my-denda-stat-card">
                <div class="my-denda-stat-icon count">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div class="my-denda-stat-content">
                    <h4>{{ $dendas->count() }}</h4>
                    <p>Jumlah Denda</p>
                </div>
            </div>
        </div>

        <!-- Denda Cards -->
        <div class="my-denda-cards">
            @foreach($dendas as $denda)
                <div class="my-denda-card">
                    <!-- Header -->
                    <div class="my-denda-card-header">
                        <div>
                            <h5 class="my-denda-card-title">
                                ID Sewa <span>#{{ $denda->id_sewa }}</span>
                            </h5>
                            <small style="color: #64748b;">{{ $denda->transaksiSewa->alat->nama_alat }}</small>
                        </div>
                        @if($denda->hasPotong())
                            <span class="my-denda-status potong">
                                <i class="bi bi-check-circle"></i> Ada Potongan
                            </span>
                        @else
                            <span class="my-denda-status active">
                                <i class="bi bi-clock"></i> Belum Dipotong
                            </span>
                        @endif
                    </div>

                    <!-- Body -->
                    <div class="my-denda-card-body">
                        <!-- Info Grid -->
                        <div class="my-denda-info-grid">
                            <div class="my-denda-info-item">
                                <div class="my-denda-info-label">Tanggal Denda</div>
                                <div class="my-denda-info-value">{{ $denda->tanggal_denda->format('d M Y') }}</div>
                            </div>
                            <div class="my-denda-info-item">
                                <div class="my-denda-info-label">Jenis</div>
                                <div class="my-denda-info-value">{{ ucfirst($denda->jenis_denda) }}</div>
                            </div>
                            <div class="my-denda-info-item">
                                <div class="my-denda-info-label">Batas Waktu</div>
                                <div class="my-denda-info-value">{{ $denda->batas_waktu->format('d M Y') }}</div>
                            </div>
                        </div>

                        <!-- Calculation -->
                        <div class="my-denda-calculation">
                            <div class="my-denda-calc-row">
                                <span class="my-denda-calc-label">Total Denda</span>
                                <span class="my-denda-calc-value">Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</span>
                            </div>

                            @if($denda->hasPotong())
                                <div class="my-denda-calc-row">
                                    <span class="my-denda-calc-label">Potongan</span>
                                    <span class="my-denda-calc-value potongan">- Rp {{ number_format($denda->potongan_denda, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <div class="my-denda-calc-row total">
                                <span class="my-denda-calc-label">Denda Akhir</span>
                                <span class="my-denda-calc-value">
                                    Rp {{ number_format($denda->denda_akhir, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        @if($denda->denda_akhir == 0)
                            <div style="text-align: center; margin-top: 15px;">
                                <span class="my-denda-lunas-badge">
                                    <i class="bi bi-check-circle-fill"></i> LUNAS
                                </span>
                            </div>
                        @endif

                        <!-- Alasan Potongan -->
                        @if($denda->hasPotong())
                            <div class="my-denda-alasan">
                                <div class="my-denda-alasan-label">
                                    <i class="bi bi-chat-square-text"></i> Alasan Potongan
                                </div>
                                <div class="my-denda-alasan-text">{{ $denda->alasan_potongan }}</div>

                                @if($denda->tanggal_potongan)
                                    <div class="my-denda-admin-info">
                                        <strong>👤 Diputuskan oleh:</strong> {{ $denda->adminPelayu->name ?? 'Admin' }}<br>
                                        <strong>📅 Tanggal:</strong> {{ $denda->tanggal_potongan->format('d M Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="my-denda-empty">
            <div class="my-denda-empty-icon">🎉</div>
            <h4>Tidak Ada Denda</h4>
            <p>Bagus! Anda tidak memiliki denda saat ini. Terus jaga ketepatan waktu pengembalian!</p>
        </div>
    @endif
</div>

@endsection
