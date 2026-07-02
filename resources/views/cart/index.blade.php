@extends('layouts.app')

@section('title', 'Keranjang Sewa - Persewaan Alat Outdoor')

@section('content')

<style>
    :root {
        --brand-green: #1e8e5a;
        --brand-light-green: #28c76f;
        --bg-light: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --white: #ffffff;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 10px 25px rgba(0,0,0,0.08);
        --border-radius: 16px;
    }

    .cart-page-wrapper {
        padding-top: 20px;
        animation: fadeIn 0.6s ease-out;
    }

    /* Progress Steps */
    .cart-steps {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 40px;
        position: relative;
    }
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 2;
        background: var(--bg-light);
        padding: 0 20px;
    }
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    .step-item.active .step-icon {
        background: var(--brand-green);
        color: white;
        box-shadow: 0 0 0 5px rgba(30, 142, 90, 0.15);
    }
    .step-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #94a3b8;
    }
    .step-item.active .step-label {
        color: var(--brand-green);
    }
    .step-connector {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 40%;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    /* Cart Header */
    .cart-title-section {
        margin-bottom: 30px;
    }
    .cart-title-section h1 {
        font-weight: 800;
        font-size: 1.75rem;
        color: var(--text-dark);
        margin-bottom: 5px;
    }
    .item-count-badge {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Main Cart Content */
    .cart-main-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .cart-table-header {
        background: #f8fafc;
        padding: 15px 25px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cart-item {
        padding: 25px;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }
    .cart-item:last-child {
        border-bottom: none;
    }
    .cart-item:hover {
        background-color: #fbfcfe;
    }

    .product-info-wrap {
        display: flex;
        gap: 20px;
    }
    .product-img-box {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid #f1f5f9;
    }
    .product-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-details h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 6px;
    }
    .product-category {
        display: inline-block;
        padding: 4px 10px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .rent-period-box {
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 0.85rem;
    }
    .period-label {
        color: var(--brand-green);
        font-weight: 700;
        margin-bottom: 4px;
        display: block;
    }
    .period-dates {
        color: #166534;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Quantity Controls */
    .qty-control-group {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border-radius: 10px;
        padding: 4px;
        width: fit-content;
        border: 1px solid #e2e8f0;
    }
    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: white;
        color: var(--text-dark);
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        box-shadow: var(--shadow-sm);
    }
    .qty-btn:hover {
        background: var(--brand-green);
        color: white;
    }
    .qty-val {
        padding: 0 15px;
        font-weight: 700;
        color: var(--text-dark);
    }

    /* Subtotal Column */
    .item-subtotal {
        text-align: right;
    }
    .subtotal-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 4px;
        display: block;
    }
    .subtotal-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--brand-green);
    }

    .btn-delete-item {
        color: #ef4444;
        background: #fef2f2;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-delete-item:hover {
        background: #fee2e2;
        color: #dc2626;
        transform: scale(1.05);
    }

    /* Sidebar Summary */
    .summary-sidebar {
        position: sticky;
        top: 100px;
    }
    .summary-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        padding: 25px;
        border: 1px solid #f1f5f9;
    }
    .summary-title {
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--text-dark);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e2e8f0;
    }
    .summary-info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }
    .summary-info-row .label { color: var(--text-muted); }
    .summary-info-row .val { font-weight: 600; color: var(--text-dark); }
    
    .total-highlight {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f1f5f9;
        margin-bottom: 25px;
    }
    .total-highlight .label {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-dark);
    }
    .total-highlight .val {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--brand-green);
    }

    .btn-checkout-prime {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-light-green) 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 10px 20px rgba(30, 142, 90, 0.2);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }
    .btn-checkout-prime:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(30, 142, 90, 0.3);
        color: white;
    }

    .trust-badges {
        margin-top: 25px;
        display: flex;
        justify-content: center;
        gap: 20px;
        opacity: 0.6;
    }
    .trust-badge {
        font-size: 0.7rem;
        font-weight: 600;
        text-align: center;
    }
    .trust-badge i { font-size: 1.2rem; display: block; margin-bottom: 4px; color: var(--brand-green); }

    /* Empty Cart State */
    .empty-state-wrap {
        text-align: center;
        padding: 100px 30px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
    }
    .empty-illustration {
        width: 280px;
        margin-bottom: 30px;
        opacity: 0.9;
    }
    .empty-state-wrap h2 {
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 12px;
    }
    .empty-state-wrap p {
        color: var(--text-muted);
        margin-bottom: 35px;
    }
    .btn-go-shopping {
        background: var(--brand-green);
        color: white;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    .btn-go-shopping:hover {
        background: var(--brand-light-green);
        transform: scale(1.05);
        color: white;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991px) {
        .summary-sidebar { margin-top: 30px; }
        .product-info-wrap { flex-direction: column; }
        .product-img-box { width: 100%; height: 180px; }
    }
</style>

<div class="container cart-page-wrapper">
    <!-- Progress Steps -->
    <div class="cart-steps">
        <div class="step-item active">
            <div class="step-icon">1</div>
            <div class="step-label">Keranjang</div>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-icon">2</div>
            <div class="step-label">Pesan</div>
        </div>
    </div>

    @if(empty($cart))
        <!-- EMPTY STATE -->
        <div class="empty-state-wrap">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-2130356-1800917.png" alt="Empty Cart" class="empty-illustration">
            <h2>Keranjang Masih Kosong</h2>
            <p>Sepertinya Anda belum memilih petualangan apapun. <br>Mari temukan peralatan outdoor terbaik kami!</p>
            <a href="{{ route('home') }}" class="btn-go-shopping">
                <i class="bi bi-shop me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
        <!-- CART DATA -->
        <div class="cart-title-section d-flex justify-content-between align-items-end">
            <div>
                <h1>Keranjang Saya</h1>
                <span class="item-count-badge">Terisi {{ count($cart) }} jenis peralatan outdoor</span>
            </div>
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua item?')">
                @csrf
                <button type="submit" class="btn btn-link text-muted text-decoration-none p-0">
                    <i class="bi bi-trash3 me-1"></i> Kosongkan Keranjang
                </button>
            </form>
        </div>

        <div class="row g-4">
            <!-- Left: Items List -->
            <div class="col-lg-8">
                <div class="cart-main-card">
                    <div class="cart-table-header d-none d-md-flex row m-0">
                        <div class="col-6">Informasi Produk</div>
                        <div class="col-3 text-center">Kuantitas</div>
                        <div class="col-3 text-end">Subtotal</div>
                    </div>

                    @foreach($cart as $cartKey => $item)
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <!-- Product Detail -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="product-info-wrap">
                                    <div class="product-img-box">
                                        <img src="{{ asset('images/alat/' . $item['gambar']) }}" alt="{{ $item['nama_alat'] }}">
                                    </div>
                                    <div class="product-details">
                                        <div class="product-category">{{ $item['kategori'] ?? 'Outdoor Gear' }}</div>
                                        <h3>{{ $item['nama_alat'] }}</h3>
                                        
                                        <!-- Rent Period Badge -->
                                        <div class="rent-period-box">
                                            <span class="period-label">Masa Sewa ({{ $item['jumlah_hari'] }} Hari)</span>
                                            <div class="period-dates">
                                                <i class="bi bi-calendar3"></i>
                                                {{ \Carbon\Carbon::parse($item['tgl_sewa'])->translatedFormat('d M') }}
                                                <i class="bi bi-arrow-right mx-1" style="font-size: 0.7rem;"></i>
                                                {{ \Carbon\Carbon::parse($item['tgl_kembali'])->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Qty Control -->
                            <div class="col-md-3 mb-3 mb-md-0 d-flex flex-column align-items-center">
                                <span class="d-md-none text-muted mb-2 small fw-bold">JUMLAH UNIT</span>
                                <div class="qty-control-group">
                                    <form action="{{ route('cart.decrease', $cartKey) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="qty-btn"><i class="bi bi-dash"></i></button>
                                    </form>
                                    <div class="qty-val">{{ $item['qty'] }}</div>
                                    <form action="{{ route('cart.increase', $cartKey) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="qty-btn"><i class="bi bi-plus"></i></button>
                                    </form>
                                </div>
                                <small class="text-muted mt-2">@ Rp {{ number_format($item['harga_sewa'], 0, ',', '.') }}/hari</small>
                            </div>

                            <!-- Subtotal -->
                            <div class="col-md-3 d-flex flex-md-column align-items-center align-items-md-end justify-content-between justify-content-md-center">
                                <div class="item-subtotal">
                                    <span class="subtotal-label d-none d-md-block">Biaya Sewa</span>
                                    <span class="subtotal-value">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                                <form action="{{ route('cart.remove', $cartKey) }}" method="POST" class="mt-md-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-item" onclick="return confirm('Hapus item ini?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('home') }}" class="btn btn-link text-success fw-bold text-decoration-none p-0">
                    <i class="bi bi-arrow-left me-2"></i>Kembali Berbelanja
                </a>
            </div>

            <!-- Right: Summary Sidebar -->
            <div class="col-lg-4">
                <div class="summary-sidebar">
                    <div class="summary-card">
                        <h2 class="summary-title">Ringkasan Sewa</h2>
                        
                        <div class="summary-info-row">
                            <span class="label">Total Harga Alat</span>
                            <span class="val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-info-row">
                            <span class="label">Pajak Layanan (10%)</span>
                            <span class="val">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-info-row">
                            <span class="label">Voucher / Diskon</span>
                            <span class="val text-success">- Rp 0</span>
                        </div>

                        <div class="total-highlight d-flex justify-content-between align-items-center">
                            <span class="label">Estimasi Total</span>
                            <span class="val">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('cart.checkout') }}" class="btn-checkout-prime">
                            Checkout Sekarang <i class="bi bi-arrow-right"></i>
                        </a>

                        <div class="trust-badges">
                            <div class="trust-badge">
                                <i class="bi bi-shield-check"></i>
                                Secure Payment
                            </div>
                            <div class="trust-badge">
                                <i class="bi bi-clock-history"></i>
                                24/7 Support
                            </div>
                            <div class="trust-badge">
                                <i class="bi bi-check-circle"></i>
                                Quality Alat
                            </div>
                        </div>
                    </div>

                    <!-- Additional Promo/Info Card -->
                    <div class="mt-3 p-4 rounded-4" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0;">
                        <div class="d-flex gap-3 align-items-center">
                            <div style="font-size: 2rem;">💡</div>
                            <div class="small fw-500 text-success">
                                <strong>Tips:</strong> Pastikan Anda telah memeriksa ketersediaan stok alat pilihan Anda sebelum melakukan pembayaran.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
