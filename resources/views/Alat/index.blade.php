@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')
@section('title', 'Data Alat')

@if(auth()->check() && auth()->user()->role === 'admin')
@section('page-title', 'Data Alat')
@section('page-description', 'Kelola inventaris alat outdoor')
@endif

@section('content')

<style>
/* ========== GLOBAL TOKENS ========== */
:root {
    --primary: #10b981;
    --primary-dark: #059669;
    --primary-soft: rgba(16, 185, 129, 0.1);
    --secondary: #6366f1;
    --dark: #0f172a;
    --slate-600: #475569;
    --slate-400: #94a3b8;
    --white: #ffffff;
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
    --shadow-md: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
    --shadow-lg: 0 20px 50px rgba(0,0,0,0.15);
    --radius-xl: 24px;
    --radius-lg: 16px;
}

/* ========== ADMIN STYLE REFINEMENT ========== */
.id-badge {
    background: linear-gradient(135deg, #0f172a, #334155);
    color: #fff;
    padding: 6px 14px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

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

.status-badge.badge-info {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0284c7;
}

.status-badge.badge-success {
    background: linear-gradient(135deg, #d4f4e5 0%, #a7f3d0 100%);
    color: #0d9668;
}

.status-badge.badge-danger {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    color: #dc2626;
}

.txn-table-alat-img {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.txn-table-alat-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
}

.actions-cell {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.action-edit, .action-delete {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
}

.action-edit {
    background: #fef3c7;
    color: #d97706;
}

.action-edit:hover {
    background: #d97706;
    color: #fff;
    transform: translateY(-2px);
}

.action-delete {
    background: #fee2e2;
    color: #dc2626;
}

.action-delete:hover {
    background: #dc2626;
    color: #fff;
    transform: translateY(-2px);
}

/* ========== PREMIUM PRODUCT CARDS ========== */
.product-grid-section {
    padding: 30px 0 80px;
    animation: fadeInSection 0.8s ease-out;
}

.product-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 32px;
}

@keyframes fadeInSection {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.product-card-modern {
    background: var(--white);
    border-radius: var(--radius-xl);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-sm);
}

.product-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-soft);
}

.card-image-container {
    height: 240px;
    position: relative;
    overflow: hidden;
    background: #f8fafc;
}

.card-image-modern {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.product-card-modern:hover .card-image-modern {
    transform: scale(1.1);
}

.card-badge-kategori {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.65rem;
    font-weight: 800;
    color: var(--dark);
    text-transform: uppercase;
    letter-spacing: 1px;
    z-index: 2;
    box-shadow: var(--shadow-sm);
}

.card-badge-stok {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.65rem;
    font-weight: 800;
    z-index: 2;
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: center;
    gap: 5px;
}

.card-overlay-modern {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.6), transparent);
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 25px;
    z-index: 3;
}

.product-card-modern:hover .card-overlay-modern {
    opacity: 1;
}

.view-detail-hint {
    background: var(--white);
    color: var(--dark);
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.8rem;
    transform: translateY(20px);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: var(--shadow-md);
}

.product-card-modern:hover .view-detail-hint {
    transform: translateY(0);
}

.card-content-modern {
    padding: 24px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-title-modern {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 8px;
    line-height: 1.4;
    min-height: 3.2rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-merk-modern {
    font-size: 0.8rem;
    color: var(--slate-400);
    margin-bottom: 15px;
    font-weight: 600;
    min-height: 1.2rem;
}

.card-footer-modern {
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px dashed #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-price-modern {
    display: flex;
    flex-direction: column;
}

.price-label-modern {
    font-size: 0.6rem;
    font-weight: 700;
    color: var(--slate-400);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.price-value-modern {
    color: var(--primary);
    font-weight: 800;
    font-size: 1.25rem;
}

.btn-sewa-modern {
    background: var(--primary);
    color: var(--white);
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

.product-card-modern:hover .btn-sewa-modern {
    background: var(--dark);
    transform: rotate(90deg);
}

.stock-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
</style>

@if(auth()->check() && auth()->user()->role === 'admin')
    <!-- ========== PAGE HEADER (ADMIN) ========== -->
    <div class="page-header">
        <div>
            <h3><i class="bi bi-box-seam" style="color:#1e8e5a;"></i> Manajemen Alat</h3>
            <p>Kelola semua inventaris alat outdoor yang tersedia</p>
        </div>
        <div class="page-header-actions">
            @if(count($alats) > 0)
                <form action="{{ route('alat.destroyAll') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA data alat?')">
                    @csrf
                    <button type="submit" class="btn-danger-soft">
                        <i class="bi bi-trash3-fill"></i> Hapus Semua Alat
                    </button>
                </form>
            @endif
            <a href="{{ route('alat.create') }}" class="btn-green">
                <i class="bi bi-plus-lg"></i> Tambah Alat
            </a>
        </div>
    </div>

    <!-- ========== ADMIN CARD TABLE ========== -->
    <div class="admin-card">
        <div class="admin-card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>ID ALAT</th>
                            <th>GAMBAR</th>
                            <th style="text-align:left;">INFORMASI ALAT</th>
                            <th>KATEGORI</th>
                            <th>STOK</th>
                            <th>HARGA SEWA</th>
                            <th style="text-align:center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alats as $i => $alat)
                            <tr>
                                <td><strong>{{ $i + 1 }}</strong></td>
                                <td>
                                    <span class="id-badge">#{{ $alat->id_alat }}</span>
                                </td>
                                <td>
                                    @if($alat->gambar)
                                        <img src="{{ asset('images/alat/'.$alat->gambar) }}" class="txn-table-alat-img">
                                    @else
                                        <div class="txn-table-alat-img d-flex align-items-center justify-content-center bg-light">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align:left;">
                                    <div class="txn-table-alat-name">{{ $alat->nama_alat }}</div>
                                    <small class="text-muted">{{ $alat->merk ?? 'No Brand' }}</small>
                                </td>
                                <td>
                                    <span class="status-badge badge-info">{{ $alat->kategori }}</span>
                                </td>
                                <td>
                                    @if($alat->stok > 0)
                                        <span class="status-badge badge-success">{{ $alat->stok }} Tersedia</span>
                                    @else
                                        <span class="status-badge badge-danger">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color:#1e8e5a; font-size: 1.05rem;">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</strong>
                                    <small class="text-muted">/hari</small>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('alat.edit', $alat->id_alat) }}" class="action-edit" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('alat.destroy', $alat->id_alat) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus alat ini?')">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div style="padding:40px;">
                                        <i class="bi bi-inbox" style="font-size:3rem;color:#cbd5e1;"></i>
                                        <p class="mt-3 text-muted">Belum ada data alat yang tersedia.</p>
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
    <!-- ========== PENYEWA VIEW: KATEGORI FILTER & SEARCH (EXISTING HERO) ========== -->
    @include('alat.hero')

    <!-- ========== USER VIEW: PRODUCT GRID ========== -->
    <div class="product-grid-section">
        <div class="product-grid-modern">
        @forelse($alats as $alat)
            <div class="product-card-modern btn-detail-alat cursor-pointer"
                     data-id="{{ $alat->id_alat }}"
                     data-nama="{{ $alat->nama_alat }}"
                     data-harga="{{ $alat->harga_sewa }}"
                     data-kategori="{{ $alat->kategori }}"
                     data-merk="{{ $alat->merk }}"
                     data-deskripsi="{{ $alat->deskripsi }}"
                     data-kegunaan="{{ $alat->kegunaan }}"
                     data-stok="{{ $alat->stok }}"
                     data-gambar="{{ asset('images/alat/'.$alat->gambar) }}">
                    
                    <div class="card-image-container">
                        <span class="card-badge-kategori">{{ $alat->kategori }}</span>
                        <div class="card-badge-stok">
                            <span class="stock-dot" style="background: {{ $alat->stok > 0 ? '#10b981' : '#f43f5e' }}"></span>
                            <span style="color: {{ $alat->stok > 0 ? '#10b981' : '#f43f5e' }}">
                                {{ $alat->stok > 0 ? $alat->stok : 'Habis' }}
                            </span>
                        </div>
                        @if($alat->gambar)
                            <img src="{{ asset('images/alat/'.$alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="card-image-modern">
                        @else
                            <div class="card-image-modern bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-slate-400" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-overlay-modern">
                            <div class="view-detail-hint">
                                <i class="bi bi-eye-fill me-2"></i> Lihat Detail
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-content-modern">
                        <h5 class="card-title-modern">{{ $alat->nama_alat }}</h5>
                        <p class="card-merk-modern">{{ $alat->merk ?? 'Generic Brand' }}</p>
                        
                        <div class="card-footer-modern">
                            <div class="card-price-modern">
                                <span class="price-label-modern">Harga Sewa</span>
                                <div class="d-flex align-items-baseline gap-1">
                                    <span class="price-value-modern">Rp {{ number_format($alat->harga_sewa,0,',','.') }}</span>
                                    <small class="text-muted">/hari</small>
                                </div>
                            </div>
                            
                            @if($alat->stok > 0)
                                <div class="btn-sewa-modern">
                                    <i class="bi bi-arrow-right-short"></i>
                                </div>
                            @else
                                <div class="btn-sewa-modern bg-light text-muted shadow-none">
                                    <i class="bi bi-slash-circle"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
@empty
            <div class="col-12 text-center py-5">
                <div class="bg-white rounded-4 shadow-sm p-5 border border-dashed">
                    <i class="bi bi-search" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h4 class="mt-4 fw-800">Ups! Alat tidak ditemukan</h4>
                    <p class="text-muted">Coba gunakan kata kunci pencarian yang lain atau jelajahi kategori lainnya.</p>
                </div>
            </div>
        @endforelse
        </div>
    </div>
@endif

<!-- ========== MODALS (REMAINS ACCESSIBLE) ========== -->
@include('alat.modals')

@endsection
