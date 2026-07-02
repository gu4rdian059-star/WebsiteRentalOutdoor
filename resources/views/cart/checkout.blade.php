@extends('layouts.app')

@section('title', 'Checkout - Persewaan Alat Outdoor')

@section('content')

<style>
    :root {
        --brand-green: #1e8e5a;
        --brand-light-green: #28c76f;
        --bg-light: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --white: #ffffff;
        --border-radius: 16px;
        --shadow-md: 0 10px 25px rgba(0,0,0,0.06);
    }

    .checkout-page-wrapper {
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
    }
    .step-item.completed .step-icon {
        background: #dcfce7;
        color: var(--brand-green);
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
    .step-item.active .step-label { color: var(--brand-green); }

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
    .step-connector.filled {
        background: var(--brand-green);
    }

    /* Layout Cards */
    .checkout-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        border: 1px solid #f1f5f9;
        margin-bottom: 25px;
        overflow: hidden;
    }
    .card-header-prime {
        padding: 20px 25px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-header-prime i {
        color: var(--brand-green);
        font-size: 1.25rem;
    }
    .card-header-prime h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
    }

    .card-body-prime {
        padding: 25px;
    }

    /* Order Item Mini */
    .mini-order-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .mini-order-item:last-child { border-bottom: none; }
    .mini-img {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #f1f5f9;
    }
    .mini-info h4 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }
    .mini-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .mini-price {
        margin-left: auto;
        font-weight: 700;
        color: var(--brand-green);
    }

    /* Form Styling */
    .form-group-prime {
        margin-bottom: 20px;
    }
    .form-group-prime label {
        display: block;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .form-control-prime {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    .form-control-prime:focus {
        border-color: var(--brand-green);
        background: white;
        outline: none;
        box-shadow: 0 0 0 4px rgba(30, 142, 90, 0.08);
    }

    /* Custom Radio Payment */
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 15px;
    }
    .payment-option {
        position: relative;
    }
    .payment-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .payment-box {
        padding: 20px;
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .payment-box i { font-size: 1.5rem; color: #94a3b8; }
    .payment-box span { font-weight: 700; font-size: 0.9rem; color: #64748b; }

    .payment-option input:checked + .payment-box {
        border-color: var(--brand-green);
        background: #f0fdf4;
    }
    .payment-option input:checked + .payment-box i { color: var(--brand-green); }
    .payment-option input:checked + .payment-box span { color: var(--brand-green); }

    /* Summary Sidebar */
    .sticky-summary {
        position: sticky;
        top: 100px;
    }
    .summary-prime {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .summary-prime h2 {
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
        color: rgba(255,255,255,0.7);
    }
    .summary-row .val { color: white; font-weight: 600; }
    .grand-total-row {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px dashed rgba(255,255,255,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .grand-total-row span { font-weight: 700; font-size: 1rem; }
    .grand-total-val { font-size: 1.75rem; font-weight: 900; color: var(--brand-light-green); }

    .btn-confirm-order {
        width: 100%;
        padding: 18px;
        background: var(--brand-green);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 1.1rem;
        margin-top: 30px;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .btn-confirm-order:hover {
        background: var(--brand-light-green);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(40, 199, 111, 0.3);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991px) {
        .sticky-summary { margin-top: 30px; }
    }
</style>

<div class="container checkout-page-wrapper">
    <!-- Progress Steps -->
    <div class="cart-steps">
        <div class="step-item completed">
            <div class="step-icon"><i class="bi bi-check-lg"></i></div>
            <div class="step-label">Keranjang</div>
        </div>
        <div class="step-connector filled"></div>
        <div class="step-item active">
            <div class="step-icon">2</div>
            <div class="step-label">Pesan</div>
        </div>
    </div>

    <form method="POST" action="{{ route('transaksi_sewa.store') }}" id="checkoutForm">
        @csrf
        
        {{-- HIDDEN DATA --}}
        <input type="hidden" name="cart_data" value="{{ json_encode($cart) }}">
        <input type="hidden" name="total_amount" value="{{ $total }}">
        <input type="hidden" name="pajak" value="{{ round($total * 0.1) }}">
        <input type="hidden" name="from_checkout" value="1">

        <div class="row g-4">
            <!-- Left: Forms -->
            <div class="col-lg-8">
                
                <!-- Order Detail List -->
                <div class="checkout-card">
                    <div class="card-header-prime">
                        <i class="bi bi-box-seam-fill"></i>
                        <h3>Pesanan Anda</h3>
                    </div>
                    <div class="card-body-prime">
                        @foreach($cart as $item)
                        <div class="mini-order-item">
                            <img src="{{ asset('images/alat/' . $item['gambar']) }}" class="mini-img" alt="">
                            <div class="mini-info">
                                <h4>{{ $item['nama_alat'] }}</h4>
                                <div class="mini-meta">
                                    {{ $item['qty'] ?? 1 }} Unit × {{ $item['jumlah_hari'] }} Hari
                                    <span class="mx-2">•</span>
                                    {{ \Carbon\Carbon::parse($item['tgl_sewa'])->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item['tgl_kembali'])->translatedFormat('d M Y') }}
                                </div>
                            </div>
                            <div class="mini-price">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="checkout-card">
                    <div class="card-header-prime">
                        <i class="bi bi-person-badge-fill"></i>
                        <h3>Informasi Pengiriman & Penyewa</h3>
                    </div>
                    <div class="card-body-prime">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-prime">
                                    <label>Nama Penerima / Penyewa</label>
                                    <input type="text" name="nama_penyewa" class="form-control-prime" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-prime">
                                    <label>Nomor WhatsApp (Aktif)</label>
                                    <input type="tel" name="no_telepon" class="form-control-prime" placeholder="Contoh: 081234567890" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-prime">
                            <label>Alamat Pengiriman / Pengambilan</label>
                            <textarea name="alamat_penyewa" class="form-control-prime" rows="3" placeholder="Tuliskan alamat lengkap Anda..." required></textarea>
                        </div>
                        <div class="p-3 rounded-4 mt-2" style="background-color: #fefce8; border: 1px solid #fef08a;">
                            <div class="d-flex gap-2">
                                <i class="bi bi-info-circle-fill text-warning"></i>
                                <small class="text-dark fw-500">KTP/SIM asli wajib diserahkan sebagai jaminan saat pengambilan alat.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="checkout-card">
                    <div class="card-header-prime">
                        <i class="bi bi-credit-card-fill"></i>
                        <h3>Metode Pembayaran</h3>
                    </div>
                    <div class="card-body-prime">
                        <div class="payment-grid">
                            <label class="payment-option">
                                <input type="radio" name="metode_pembayaran" value="transfer_bank" checked onchange="togglePaymentDetails('bank')">
                                <div class="payment-box">
                                    <i class="bi bi-bank"></i>
                                    <span>Bank</span>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="metode_pembayaran" value="e_wallet" onchange="togglePaymentDetails('ewallet')">
                                <div class="payment-box">
                                    <i class="bi bi-phone-fill"></i>
                                    <span>E-Wallet</span>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="metode_pembayaran" value="qris" onchange="togglePaymentDetails('qris')">
                                <div class="payment-box">
                                    <i class="bi bi-qr-code-scan"></i>
                                    <span>QRIS</span>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="metode_pembayaran" value="cod" onchange="togglePaymentDetails('cod')">
                                <div class="payment-box">
                                    <i class="bi bi-cash-stack"></i>
                                    <span>COD</span>
                                </div>
                            </label>
                        </div>

                        <!-- Payment Info Details -->
                        <div id="payment-details-area" class="mt-4 p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            
                            <!-- BANK DETAILS -->
                            <div id="detail-bank" class="payment-detail-item">
                                <h5 class="fw-bold mb-3" style="font-size: 0.95rem;">🏦 Instruksi Transfer Bank / Virtual Account</h5>
                                
                                {{-- BNI --}}
                                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border mb-2">
                                    <div style="width: 60px; text-align: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1024px-BNI_logo.svg.png" height="18" alt="BNI">
                                    </div>
                                    <div>
                                        <div class="small text-muted">Virtual Account BNI</div>
                                        <div class="fw-bold text-dark">8236 1327 6300 1234</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light ms-auto" onclick="copyText('8236132763001234')">Salin</button>
                                </div>

                                {{-- BCA --}}
                                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border mb-2">
                                    <div style="width: 60px; text-align: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1024px-Bank_Central_Asia.svg.png" height="18" alt="BCA">
                                    </div>
                                    <div>
                                        <div class="small text-muted">Virtual Account BCA</div>
                                        <div class="fw-bold text-dark">7710 5236 1327</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light ms-auto" onclick="copyText('771052361327')">Salin</button>
                                </div>

                                {{-- MANDIRI --}}
                                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border mb-2">
                                    <div style="width: 60px; text-align: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1024px-Bank_Mandiri_logo_2016.svg.png" height="18" alt="Mandiri">
                                    </div>
                                    <div>
                                        <div class="small text-muted">Virtual Account Mandiri</div>
                                        <div class="fw-bold text-dark">1230 0823 6132 7</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light ms-auto" onclick="copyText('1230082361327')">Salin</button>
                                </div>

                                {{-- BRI --}}
                                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border mb-2">
                                    <div style="width: 60px; text-align: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_Logo.svg/1024px-BRI_Logo.svg.png" height="18" alt="BRI">
                                    </div>
                                    <div>
                                        <div class="small text-muted">Virtual Account BRI (BRIVA)</div>
                                        <div class="fw-bold text-dark">1276 0085 2361 327</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light ms-auto" onclick="copyText('127600852361327')">Salin</button>
                                </div>

                                {{-- CIMB NIAGA --}}
                                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
                                    <div style="width: 60px; text-align: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/CIMB_Niaga_logo.svg/1024px-CIMB_Niaga_logo.svg.png" height="18" alt="CIMB Niaga">
                                    </div>
                                    <div>
                                        <div class="small text-muted">Virtual Account CIMB Niaga</div>
                                        <div class="fw-bold text-dark">8059 0852 3613 2763</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light ms-auto" onclick="copyText('8059085236132763')">Salin</button>
                                </div>

                                <small class="text-muted d-block mt-3">* Pesanan akan diproses otomatis setelah transaksi Anda terverifikasi oleh sistem.</small>
                            </div>

                            <!-- E-WALLET DETAILS -->
                            <div id="detail-ewallet" class="payment-detail-item" style="display: none;">
                                <h5 class="fw-bold mb-3" style="font-size: 0.95rem;">📱 E-Wallet (Dana / OVO / GoPay)</h5>
                                <div class="p-4 bg-white rounded-4 border text-center">
                                    <div class="d-flex justify-content-center gap-4 mb-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" height="25" alt="Dana">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" height="25" alt="OVO">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Gopay_logo.svg/1200px-Gopay_logo.svg.png" height="25" alt="GoPay">
                                    </div>
                                    <div class="text-muted small mb-1">Nomor TUJUAN Pembayaran:</div>
                                    <div class="h4 fw-bolder text-success mb-2">0852 3613 2763</div>
                                    <div class="small text-muted">A.N. OUTDOOR RENT ADMIN</div>
                                    <button type="button" class="btn btn-success btn-sm mt-3 px-4 rounded-5" onclick="copyText('085236132763')">Salin Nomor</button>
                                </div>
                            </div>

                            <!-- QRIS DETAILS -->
                            <div id="detail-qris" class="payment-detail-item" style="display: none;">
                                <h5 class="fw-bold mb-3" style="font-size: 0.95rem;">📸 QRIS Scan Cepat</h5>
                                <div class="bg-white p-4 rounded-4 border text-center">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=OutdoorRent_085236132763" class="img-fluid mb-3" style="max-width: 180px; border: 8px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" alt="QRIS">
                                    <div class="small fw-bold text-dark">SCAN QRIS UNTUK MEMBAYAR</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Mendukung All Bank & All E-Wallet</div>
                                </div>
                            </div>

                            <!-- COD DETAILS -->
                            <div id="detail-cod" class="payment-detail-item" style="display: none;">
                                <h5 class="fw-bold mb-3" style="font-size: 0.95rem;">🤝 Cash On Delivery (Bayar di Tempat)</h5>
                                <div class="bg-white p-3 rounded-3 border d-flex gap-3 align-items-start">
                                    <i class="bi bi-info-circle-fill text-success fs-4"></i>
                                    <div class="small">
                                        Anda dapat membayar langsung secara tunai saat pengambilan alat di store atau saat alat diantar ke lokasi Anda.
                                        <br><br>
                                        <strong>Catatan:</strong> Siapkan uang pas untuk mempercepat proses transaksi.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function togglePaymentDetails(type) {
                    // Hide all
                    document.querySelectorAll('.payment-detail-item').forEach(el => {
                        el.style.display = 'none';
                    });
                    // Show target
                    document.getElementById('detail-' + type).style.display = 'block';
                }

                function copyText(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert("Berhasil disalin: " + text);
                    });
                }
            </script>

            <!-- Right: Summary Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-summary">
                    <div class="summary-prime">
                        <h2>Ringkasan Biaya</h2>
                        
                        <div class="summary-row">
                            <span class="label">Total Sewa Alat</span>
                            <span class="val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Pajak Layanan (10%)</span>
                            <span class="val">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Biaya Admin</span>
                            <span class="val text-success">Gratis</span>
                        </div>

                        <div class="grand-total-row">
                            <span>TOTAL BAYAR</span>
                            <div class="grand-total-val">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</div>
                        </div>

                        <button type="submit" class="btn-confirm-order">
                            LANJUT PEMBAYARAN <i class="bi bi-arrow-right-circle ms-2"></i>
                        </button>

                        <div class="mt-4 text-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" height="15" alt="" class="me-2 opacity-50">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" height="15" alt="" class="me-2 opacity-50">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Gopay_logo.svg/1200px-Gopay_logo.svg.png" height="12" alt="" class="opacity-50">
                        </div>

                        <p class="mt-4 small text-center text-white-50">
                            Dengan menekan tombol di atas, Anda menyetujui <a href="#" class="text-white text-decoration-underline">Syarat & Ketentuan</a> penyewaan.
                        </p>
                    </div>

                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-3 border-0 rounded-4 py-3 fw-bold">
                        <i class="bi bi-arrow-left me-2"></i>Kembali Edit Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
