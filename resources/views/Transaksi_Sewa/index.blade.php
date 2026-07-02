@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')
@section('title','Data Transaksi')
@if(auth()->check() && auth()->user()->role === 'admin')
@section('page-title', 'Data Transaksi')
@section('page-description', 'Kelola semua transaksi penyewaan alat outdoor')
@endif

@section('content')

<style>
/* ========== TRANSACTION HERO SECTION ========== */
.txn-hero {
    position: relative;
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 24px;
    padding: 50px 40px;
    margin-bottom: 35px;
    overflow: hidden;
}

.txn-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}

.txn-hero-content {
    position: relative;
    z-index: 1;
}

.txn-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    border: 1px solid rgba(255,255,255,0.2);
}

.txn-hero-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
}

.txn-hero-subtitle {
    font-size: 1rem;
    color: rgba(255,255,255,0.75);
}

/* Header Actions */
.txn-header-actions {
    display: flex;
    gap: 12px;
}

.txn-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.txn-btn-add {
    background: linear-gradient(135deg, #0d9668 0%, #28c76f 100%);
    color: #fff;
    box-shadow: 0 4px 15px rgba(13,150,104,0.3);
}

.txn-btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(13,150,104,0.4);
    color: #fff;
}

.txn-btn-delete {
    background: rgba(255,255,255,0.1);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.3);
}

.txn-btn-delete:hover {
    background: #e74c3c;
    border-color: #e74c3c;
    transform: translateY(-3px);
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-disewa {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #d97706;
}

.status-selesai {
    background: linear-gradient(135deg, #d4f4e5 0%, #a7f3d0 100%);
    color: #0d9668;
}

.status-terlambat {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    color: #dc2626;
}

.status-pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #d97706;
}

.status-confirmed {
    background: linear-gradient(135deg, #d4f4e5 0%, #a7f3d0 100%);
    color: #0d9668;
}

/* ========== PENYEWA VIEW: TRANSACTION CARDS ========== */
.txn-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
}

.txn-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e2e8f0;
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.txn-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    border-color: rgba(13,150,104,0.2);
}

.txn-card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    flex-shrink: 0;
}

.txn-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.txn-card:hover .txn-card-image img {
    transform: scale(1.08);
}

.txn-card-image-grid {
    height: 200px;
    background: #f0f0f0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2px;
    padding: 2px;
    position: relative;
}

.txn-card-image-grid > div {
    overflow: hidden;
    background: #e0e0e0;
    position: relative;
}

.txn-card-image-grid img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.txn-card-image-grid .more-items {
    grid-column: span 2;
    background: #0d9668;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.1rem;
}

.txn-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);
}

.txn-card-status {
    position: absolute;
    top: 15px;
    right: 15px;
}

.txn-card-items-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(255,255,255,0.95);
    color: #0d9668;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
}

.txn-card-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.txn-card-items {
    margin-bottom: 15px;
}

.txn-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}

.txn-item:last-child {
    border-bottom: none;
}

.txn-item-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.95rem;
}

.txn-item-qty {
    background: #e0f2fe;
    color: #0284c7;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.txn-item-date {
    font-size: 0.8rem;
    color: #64748b;
}

.txn-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-top: 1px solid #e2e8f0;
    margin-top: auto;
    flex-shrink: 0;
}

.txn-card-price {
    font-size: 1.3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #0d9668 0%, #28c76f 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.txn-card-actions {
    display: flex;
    gap: 8px;
}

.txn-card-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.txn-card-btn-download {
    background: #e0f2fe;
    color: #0284c7;
}

.txn-card-btn-download:hover {
    background: #0284c7;
    color: #fff;
}

.txn-card-btn-detail {
    background: linear-gradient(135deg, #0d9668 0%, #28c76f 100%);
    color: #fff;
}

.txn-card-btn-detail:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(13,150,104,0.3);
}

/* Empty State */
.txn-empty {
    text-align: center;
    padding: 80px 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 24px;
    border: 2px dashed #e2e8f0;
}

.txn-empty-icon {
    width: 100px;
    height: 100px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    font-size: 2.5rem;
}

.txn-empty h5 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 10px;
}

.txn-empty p {
    color: #64748b;
    margin-bottom: 25px;
}

.txn-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #0d9668 0%, #28c76f 100%);
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(13,150,104,0.3);
}

.txn-empty-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(13,150,104,0.4);
    color: #fff;
}

/* ========== ADMIN VIEW: TABLE ========== */
.txn-table-container {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.txn-table {
    width: 100%;
    border-collapse: collapse;
}

.txn-table thead {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.txn-table th {
    padding: 18px 15px;
    font-weight: 700;
    color: #0f172a;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #0d9668;
    text-align: center;
}

.txn-table td {
    padding: 16px 15px;
    text-align: center;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.txn-table tbody tr:hover {
    background: #f8fafc;
}

.txn-table tbody tr.group-start td {
    border-top: 2px solid #e2e8f0;
}

.txn-table-pelanggan {
    display: flex;
    align-items: center;
    gap: 10px;
}

.txn-table-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #0d9668 0%, #28c76f 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.85rem;
}

.txn-table-alat-img {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.txn-table-alat-name {
    font-weight: 600;
    color: #0f172a;
}

.txn-table-alat-qty {
    display: inline-block;
    background: #e0f2fe;
    color: #0284c7;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-top: 5px;
}

.txn-table-hari {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f1f5f9;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    color: #0d9668;
}

.txn-table-denda {
    color: #dc2626;
    font-weight: 700;
}

.txn-table-total {
    font-weight: 800;
    color: #0d9668;
    font-size: 1.05rem;
}

.txn-table-actions {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.txn-table-btn {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.txn-table-btn-edit {
    background: #fef3c7;
    color: #d97706;
}

.txn-table-btn-edit:hover {
    background: #d97706;
    color: #fff;
}

.txn-table-btn-confirm {
    background: linear-gradient(135deg, #0d9668 0%, #28c76f 100%);
    color: #fff;
}

.txn-table-btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13,150,104,0.3);
}

.txn-table-btn-delete {
    background: #fee2e2;
    color: #dc2626;
}

.txn-table-btn-delete:hover {
    background: #dc2626;
    color: #fff;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .txn-hero {
        padding: 30px 25px;
    }
    
    .txn-hero-title {
        font-size: 1.5rem;
    }
    
    .txn-cards-grid {
        grid-template-columns: 1fr;
    }
    
    .txn-table-container {
        overflow-x: auto;
    }
    
    .txn-table {
        min-width: 900px;
    }
}
</style>

@if(auth()->check() && auth()->user()->role === 'admin')
    <div class="page-header">
        <div>
            <h3><i class="bi bi-receipt" style="color:#1e8e5a;"></i> Manajemen Transaksi</h3>
            <p>Kelola semua transaksi penyewaan alat outdoor</p>
        </div>
        <div class="page-header-actions">
            @if(count($transaksis) > 0)
                <form action="{{ route('transaksi_sewa.destroyAll') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA data transaksi?')">
                    @csrf
                    <button type="submit" class="btn-danger-soft">
                        <i class="bi bi-trash3-fill"></i> Hapus Semua Transaksi
                    </button>
                </form>
            @endif
            <a href="{{ route('transaksi_sewa.create') }}" class="btn-green">
                <i class="bi bi-plus-lg"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Sewa</th>
                            <th>Pelanggan</th>
                            <th>Alat</th>
                            <th>Tgl Sewa</th>
                            <th>Tgl Kembali</th>
                            <th>Hari</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th style="min-width:140px;">Total</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $i => $t)
                            <tr>
                                <td><strong>{{ $i + 1 }}</strong></td>
                                <td>
                                    <span style="background:linear-gradient(135deg,#1e8e5a,#28c76f);color:#fff;padding:4px 12px;border-radius:6px;font-weight:700;font-size:0.82rem;">
                                        #{{ $t->id_sewa }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $t->pelanggan->nama_pelanggan ?? '-' }}</strong>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        @if($t->alat && $t->alat->gambar)
                                            <img src="{{ asset('images/alat/'.$t->alat->gambar) }}" style="width:36px;height:36px;object-fit:cover;border-radius:8px;">
                                        @endif
                                        <span>{{ $t->alat->nama_alat ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal_sewa)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d/m/Y') }}</td>
                                <td><span class="status-badge badge-info">{{ $t->jumlah_hari }} Hari</span></td>
                                <td>
                                    @if($t->status === 'disewa')
                                        <span class="status-badge badge-warning">Disewa</span>
                                    @elseif($t->status === 'selesai')
                                        <span class="status-badge badge-success">Selesai</span>
                                    @elseif($t->status === 'terlambat')
                                        <span class="status-badge badge-danger">Terlambat</span>
                                    @endif
                                </td>
                                <td>
                                    @if($t->payment_status === 'confirmed')
                                        <span class="status-badge badge-success">
                                            <i class="bi bi-check-circle-fill"></i> Confirmed
                                        </span>
                                    @else
                                        <span class="status-badge badge-warning">
                                            <i class="bi bi-clock-history"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color:#1e8e5a;">Rp {{ number_format($t->total_harga + ($t->denda ?? 0), 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <div class="actions-cell" style="justify-content:center;">
                                        {{-- TOMBOL KONFIRMASI (HANYA JIKA BELUM CONFIRMED) --}}
                                        @if($t->payment_status !== 'confirmed')
                                            <form action="{{ route('transaksi_sewa.confirmPayment', $t->id_sewa) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-warning-soft" style="padding: 5px 12px; font-size: 0.75rem;" title="Konfirmasi Pembayaran" onclick="return confirm('Konfirmasi pembayaran untuk transaksi ini?')">
                                                    <i class="bi bi-check-lg"></i> Konfirmasi
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('transaksi_sewa.edit', $t->id_sewa) }}" class="action-edit" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('transaksi_sewa.destroy', $t->id_sewa) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="action-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox" style="font-size:3rem;color:#cbd5e1;"></i>
                                        <p class="mt-3 text-muted">Belum ada data transaksi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid py-4">
    <!-- ========== HERO SECTION ========== -->
    <div class="txn-hero">
        <div class="d-flex justify-content-between align-items-start">
            <div class="txn-hero-content">
                <span class="txn-hero-badge">
                    <i class="bi bi-calendar-check"></i>
                    @if(auth()->check() && auth()->user()->role === 'penyewa')
                        Riwayat Penyewaan
                    @else
                        Manajemen Transaksi
                    @endif
                </span>
                <h1 class="txn-hero-title">
                    @if(auth()->check() && auth()->user()->role === 'penyewa')
                        Sewa Saya
                    @else
                        Data Transaksi Sewa
                    @endif
                </h1>
                <p class="txn-hero-subtitle">
                    @if(auth()->check() && auth()->user()->role === 'penyewa')
                        Pantau status penyewaan dan riwayat transaksi Anda
                    @else
                        Kelola semua transaksi penyewaan alat outdoor
                    @endif
                </p>
            </div>
            
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="txn-header-actions">
                    <a href="{{ route('transaksi_sewa.create') }}" class="txn-btn txn-btn-add">
                        <i class="bi bi-plus-lg"></i>
                        <span>Tambah</span>
                    </a>
                    <form action="{{ route('transaksi_sewa.destroyAll') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="txn-btn txn-btn-delete"
                                onclick="return confirm('Yakin ingin menghapus SEMUA data transaksi?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- ========== PENYEWA VIEW: CARD GRID ========== -->
    @if(auth()->check() && auth()->user()->role === 'penyewa')
        @if(count($groupedTransaksis) > 0)
            <div class="txn-cards-grid">
                @foreach($groupedTransaksis as $groupKey => $items)
                    @php
                        $firstItem = $items[0];
                        $totalPrice = collect($items)->sum('total_harga');
                    @endphp
                    <div class="txn-card" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <!-- Image Section -->
                        @if(count($items) > 1)
                            <div class="txn-card-image-grid">
                                @foreach($items as $idx => $t)
                                    @if($idx < 4)
                                        <div>
                                            @if($t->alat && $t->alat->gambar)
                                                <img src="{{ asset('images/alat/'.$t->alat->gambar) }}" alt="">
                                            @else
                                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                                    <i class="bi bi-image" style="color:#999;"></i>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($idx === 4)
                                        <div class="more-items">
                                            +{{ count($items) - 4 }} Lagi
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="txn-card-image">
                                @if($firstItem->alat && $firstItem->alat->gambar)
                                    <img src="{{ asset('images/alat/'.$firstItem->alat->gambar) }}" alt="">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f0f0f0;">
                                        <i class="bi bi-image" style="font-size:3rem;color:#ccc;"></i>
                                    </div>
                                @endif
                                <div class="txn-card-overlay"></div>
                                @if(count($items) > 1)
                                    <div class="txn-card-items-badge">{{ count($items) }} Items</div>
                                @endif
                                <div class="txn-card-status">
                                    @if($firstItem->status === 'disewa')
                                        <span class="status-badge status-disewa">
                                            <i class="bi bi-clock"></i> Disewa
                                        </span>
                                    @elseif($firstItem->status === 'selesai')
                                        <span class="status-badge status-selesai">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </span>
                                    @elseif($firstItem->status === 'terlambat')
                                        <span class="status-badge status-terlambat">
                                            <i class="bi bi-exclamation-triangle"></i> Terlambat
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <!-- Content -->
                        <div class="txn-card-content">
                            <div class="txn-card-items">
                                @foreach($items as $t)
                                    @php
                                        $tglSewa = \Carbon\Carbon::parse($t->tanggal_sewa);
                                        $tglKembali = \Carbon\Carbon::parse($t->tanggal_kembali);
                                    @endphp
                                    <div class="txn-item">
                                        <div>
                                            <div class="txn-item-name">{{ $t->alat->nama_alat ?? '-' }}</div>
                                            <div class="txn-item-date">
                                                {{ $tglSewa->format('d M') }} - {{ $tglKembali->format('d M Y') }} 
                                                ({{ $t->jumlah_hari }} hari)
                                            </div>
                                        </div>
                                        @if($t->jumlah_satuan && $t->jumlah_satuan > 1)
                                            <span class="txn-item-qty">x{{ $t->jumlah_satuan }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($firstItem->payment_status === 'pending')
                                <div class="mb-3">
                                    <span class="status-badge status-pending">
                                        <i class="bi bi-hourglass-split"></i> Belum Bayar
                                    </span>
                                </div>
                            @elseif($firstItem->payment_status === 'confirmed')
                                <div class="mb-3">
                                    <span class="status-badge status-confirmed">
                                        <i class="bi bi-check-circle-fill"></i> Terbayar
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Footer -->
                        <div class="txn-card-footer">
                            <div class="txn-card-price">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </div>
                            <div class="txn-card-actions">
                                <a href="{{ route('transaksi_sewa.downloadStruk', $firstItem->id_sewa) }}" 
                                   class="txn-card-btn txn-card-btn-download" target="_blank" title="Download Struk">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="{{ route('transaksi_sewa.detail', $firstItem->id_sewa) }}" 
                                   class="txn-card-btn txn-card-btn-detail" title="Lihat Detail">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="txn-empty">
                <div class="txn-empty-icon">📭</div>
                <h5>Belum ada transaksi</h5>
                <p>Mulai petualangan Anda dengan menyewa alat outdoor kami</p>
                <a href="{{ route('home') }}" class="txn-empty-btn">
                    <i class="bi bi-shop"></i> Lihat Katalog
                </a>
            </div>
        @endif

    @endif
</div>

@endif
@endsection
