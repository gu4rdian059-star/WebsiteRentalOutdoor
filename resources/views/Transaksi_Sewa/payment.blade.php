@extends('layouts.app')

@section('title', 'Pembayaran Sewa Alat')

@section('content')

<style>
    .payment-container {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .payment-header {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        color: #fff;
        padding: 40px;
        text-align: center;
    }

    .payment-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .payment-header p {
        opacity: 0.95;
        font-size: 1.05rem;
    }

    .payment-content {
        padding: 40px;
    }

    .order-summary {
        background: linear-gradient(135deg, #f8fafb 0%, #f0f7f4 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border-left: 5px solid #1e8e5a;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        font-weight: 600;
        color: #555;
    }

    .summary-value {
        color: #2c3e50;
        font-weight: 700;
    }

    .summary-total {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
        text-align: center;
        border: 2px solid #1e8e5a;
    }

    .total-amount {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e8e5a;
    }

    .total-label {
        color: #7f8c8d;
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .payment-methods {
        margin-top: 40px;
    }

    .payment-methods h4 {
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .method-box {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .method-box:hover {
        border-color: #1e8e5a;
        background: rgba(30, 142, 90, 0.02);
        box-shadow: 0 5px 20px rgba(30, 142, 90, 0.1);
    }

    .method-box input[type="radio"] {
        position: absolute;
        top: 20px;
        right: 20px;
        cursor: pointer;
    }

    .method-box.selected {
        border-color: #1e8e5a;
        background: rgba(30, 142, 90, 0.05);
    }

    .method-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .method-name {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .method-desc {
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .payment-info {
        background: linear-gradient(135deg, #e8f8f1 0%, #d4f4e5 100%);
        border-left: 4px solid #1e8e5a;
        color: #1e8e5a;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: none;
    }

    .payment-info.active {
        display: block;
    }

    .payment-info h5 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .payment-info p {
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .payment-info code {
        background: rgba(30, 142, 90, 0.1);
        padding: 3px 8px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
    }

    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 40px;
    }

    .btn-cancel {
        flex: 1;
        padding: 14px;
        background: #e0e0e0;
        color: #555;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #d0d0d0;
    }

    .btn-confirm {
        flex: 1;
        padding: 14px;
        background: linear-gradient(135deg, #1e8e5a, #28c76f);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 142, 90, 0.3);
    }

    .btn-confirm:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .info-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .info-box strong {
        color: #856404;
    }

    @media (max-width: 768px) {
        .payment-container {
            margin: 20px;
            border-radius: 15px;
        }

        .payment-header {
            padding: 30px 20px;
        }

        .payment-header h2 {
            font-size: 1.5rem;
        }

        .payment-content {
            padding: 20px;
        }

        .total-amount {
            font-size: 1.8rem;
        }

        .button-group {
            flex-direction: column;
        }
    }
</style>

<div class="payment-container">
    <div class="payment-header">
        <h2>💳 Pembayaran Sewa</h2>
        <p>Lengkapi pembayaran untuk menyelesaikan transaksi</p>
    </div>

    <div class="payment-content">
        {{-- RINGKASAN PESANAN --}}
        <div class="order-summary">
            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 15px;">📦 Ringkasan Pesanan</h4>
            
            <div class="summary-row">
                <span class="summary-label">Alat:</span>
                <span class="summary-value">{{ $alat->nama_alat }}</span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Tanggal Sewa:</span>
                <span class="summary-value">{{ date('d-m-Y', strtotime($tglSewa)) }}</span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Tanggal Kembali:</span>
                <span class="summary-value">{{ date('d-m-Y', strtotime($tglKembali)) }}</span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Harga Per Hari:</span>
                <span class="summary-value">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Jumlah Hari:</span>
                <span class="summary-value">{{ $totalHari }} hari</span>
            </div>

            <div class="summary-total">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- INFO BOX --}}
        <div class="info-box">
            <strong>⚠️ Perhatian:</strong> Pastikan Anda memilih metode pembayaran yang sesuai. Transaksi Anda akan dikonfirmasi setelah pembayaran diterima.
        </div>

        {{-- PILIH METODE PEMBAYARAN --}}
        <form id="formPembayaran" action="{{ route('transaksi_sewa.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_alat" value="{{ $idAlat }}">
            <input type="hidden" name="tgl_sewa" value="{{ $tglSewa }}">
            <input type="hidden" name="tgl_kembali" value="{{ $tglKembali }}">
            <input type="hidden" name="deskripsi" value="{{ $deskripsi }}">
            <input type="hidden" name="total_harga" value="{{ $totalPrice }}">

            <div class="payment-methods">
                <h4>💰 Pilih Metode Pembayaran</h4>

                {{-- TRANSFER BANK --}}
                <label class="method-box" onclick="selectMethod('transfer_bank')">
                    <input type="radio" name="metode_pembayaran" value="transfer_bank">
                    <div class="method-icon">🏦</div>
                    <div class="method-name">Transfer Bank</div>
                    <div class="method-desc">Transfer ke rekening bisnis kami via ATM atau Mobile Banking</div>
                </label>

                <div id="transfer_bank_info" class="payment-info">
                    <h5>📍 Informasi Transfer Bank</h5>
                    <p><strong>Bank BRI</strong></p>
                    <p>No Rekening: <code>0123456789</code></p>
                    <p>Atas Nama: <code>OUTDOOR RENT</code></p>
                    <p style="margin-top: 10px; font-size: 0.85rem; color: rgba(30, 142, 90, 0.8);">
                        Silakan transfer sesuai nominal total pembayaran di atas. Konfirmasi pembayaran akan diverifikasi dalam 1x24 jam.
                    </p>
                </div>

                {{-- E-WALLET --}}
                <label class="method-box" onclick="selectMethod('e_wallet')">
                    <input type="radio" name="metode_pembayaran" value="e_wallet">
                    <div class="method-icon">📱</div>
                    <div class="method-name">E-Wallet (GCash / Dana)</div>
                    <div class="method-desc">Pembayaran via GCash atau Dana dengan cepat dan mudah</div>
                </label>

                <div id="e_wallet_info" class="payment-info">
                    <h5>📱 Informasi E-Wallet</h5>
                    <p><strong>GCash / Dana ID:</strong> <code>09170822773493</code></p>
                    <p>Nomor registrasi: <code>OUTDOOR_RENT_PHILIPPINES</code></p>
                    <p style="margin-top: 10px; font-size: 0.85rem; color: rgba(30, 142, 90, 0.8);">
                        Kirim pembayaran ke nomor GCash/Dana di atas. Transaksi biasanya langsung terkoneksi ke sistem kami.
                    </p>
                </div>

                {{-- TUNAI --}}
                <label class="method-box" onclick="selectMethod('cash')">
                    <input type="radio" name="metode_pembayaran" value="cash">
                    <div class="method-icon">💵</div>
                    <div class="method-name">Tunai di Lokasi</div>
                    <div class="method-desc">Bayar langsung saat Anda datang ke lokasi kami</div>
                </label>

                <div id="cash_info" class="payment-info">
                    <h5>💵 Informasi Pembayaran Tunai</h5>
                    <p><strong>Alamat Lokasi:</strong></p>
                    <p>Jl. Raya Magersari Pleret, Kec. Pohjentrek, Kab. Pasuruan, Jawa Timur, Indonesia</p>
                    <p style="margin-top: 10px; font-size: 0.85rem; color: rgba(30, 142, 90, 0.8);">
                        Pembayaran tunai diterima saat Anda datang mengambil alat. Pastikan Anda datang sesuai jadwal yang telah ditentukan.
                    </p>
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn-cancel" onclick="window.history.back()">
                    ← Kembali
                </button>
                <button type="submit" class="btn-confirm" id="btnSubmit" disabled>
                    ✅ Konfirmasi & Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectMethod(method) {
        // Remove active class from all
        document.querySelectorAll('.method-box').forEach(box => {
            box.classList.remove('selected');
        });
        document.querySelectorAll('.payment-info').forEach(info => {
            info.classList.remove('active');
        });

        // Add active class to selected
        event.currentTarget.classList.add('selected');
        document.getElementById(method + '_info').classList.add('active');

        // Set radio button value
        document.querySelector(`input[name="metode_pembayaran"][value="${method}"]`).checked = true;

        // Enable submit button
        document.getElementById('btnSubmit').disabled = false;
        
        console.log('Metode pembayaran dipilih:', method);
    }

    // Form submit validation
    document.getElementById('formPembayaran').addEventListener('submit', function(e) {
        const metode = document.querySelector('input[name="metode_pembayaran"]:checked')?.value;
        if (!metode) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu');
            console.error('Metode pembayaran tidak dipilih');
            return false;
        }
        console.log('Form akan disubmit dengan metode:', metode);
    });
</script>

@endsection
