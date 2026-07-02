@extends('layouts.admin')

@section('title', 'Berikan Potongan Denda - Admin')
@section('page-title', 'Potongan Denda')
@section('page-description', 'Berikan potongan denda untuk pelanggan')

@section('content')
<style>
    .potongan-card {
        background: linear-gradient(135deg, #f8fafb 0%, #f0f7f4 100%);
        border-radius: 20px;
        border: 1px solid rgba(30, 142, 90, 0.1);
        box-shadow: 0 10px 30px rgba(30, 142, 90, 0.08);
        padding: 40px;
    }

    .info-section {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border-left: 5px solid #1e8e5a;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .info-value {
        font-weight: 700;
        color: #1e8e5a;
        font-size: 1.1rem;
    }

    .form-section {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 25px;
    }

    .form-section h5 {
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 25px;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
        font-size: 0.95rem;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1e8e5a;
        box-shadow: 0 0 0 4px rgba(30, 142, 90, 0.1);
        outline: none;
    }

    .calculation-box {
        background: linear-gradient(135deg, #e8f8f1 0%, #d4f4e5 100%);
        border-radius: 15px;
        padding: 20px;
        border-left: 5px solid #1e8e5a;
        margin-top: 20px;
    }

    .calculation-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-weight: 600;
    }

    .calculation-row.total {
        border-top: 2px solid #1e8e5a;
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.2rem;
        color: #1e8e5a;
    }

    .btn-submit {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px 35px;
        font-weight: 700;
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
        font-size: 1.05rem;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 142, 90, 0.3);
    }

    .btn-cancel {
        background: #e0e0e0;
        color: #666;
        border: none;
        border-radius: 12px;
        padding: 14px 35px;
        font-weight: 700;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 12px;
        width: 100%;
    }

    .btn-cancel:hover {
        background: #d0d0d0;
    }

    .alert {
        border-radius: 12px;
        border: none;
        border-left: 5px solid;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .alert-danger {
        background: #fadbd8;
        color: #c0392b;
        border-left-color: #e74c3c;
    }

    .input-with-info {
        position: relative;
    }

    .input-info {
        font-size: 0.85rem;
        color: #7f8c8d;
        margin-top: 8px;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .potongan-card {
            padding: 25px;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .info-row .info-value {
            font-size: 1rem;
        }
    }
</style>

<div class="container mt-5 mb-5" style="max-width: 700px;">
    <a href="{{ route('denda.index') }}" class="btn btn-link text-decoration-none mb-4">
        ← Kembali ke Data Denda
    </a>

    <div class="potongan-card">
        <h3 class="mb-4" style="color: #2c3e50; font-weight: 800;">
            💰 Berikan Potongan Denda
        </h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>⚠️ Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Info Transaksi & Denda -->
        <div class="info-section">
            <h5 style="margin: 0 0 15px 0; font-weight: 700; color: #1e8e5a;">📋 Informasi Denda</h5>
            
            <div class="info-row">
                <span class="info-label">ID Sewa</span>
                <span class="info-value">#{{ $denda->id_sewa }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Pelanggan</span>
                <span class="info-value">{{ $denda->transaksiSewa->pelanggan->nama_pelanggan }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Alat</span>
                <span class="info-value">{{ $denda->transaksiSewa->alat->nama_alat }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Jenis Denda</span>
                <span class="info-value">{{ ucfirst($denda->jenis_denda) }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Tanggal Denda</span>
                <span class="info-value">{{ $denda->tanggal_denda->format('d M Y') }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Total Denda</span>
                <span class="info-value">Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</span>
            </div>

            @if($denda->potongan_denda > 0)
                <div class="info-row" style="background: #e8f8f1; margin: 12px -25px -12px; padding: 12px 25px;">
                    <span class="info-label">Potongan Saat Ini</span>
                    <span class="info-value" style="color: #e74c3c;">- Rp {{ number_format($denda->potongan_denda, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>

        <!-- Form Potongan -->
        <form method="POST" action="{{ route('denda.storePotongan', $denda->id_denda) }}">
            @csrf

            <div class="form-section">
                <h5>⚙️ Pengaturan Potongan</h5>

                <!-- Jumlah Potongan -->
                <div class="form-group">
                    <label for="potongan_denda">Jumlah Potongan (Rp)</label>
                    <input 
                        type="number" 
                        id="potongan_denda"
                        name="potongan_denda" 
                        class="form-control @error('potongan_denda') is-invalid @enderror"
                        placeholder="Contoh: 20000"
                        min="0"
                        max="{{ $denda->total_denda }}"
                        value="{{ old('potongan_denda', $denda->potongan_denda ?? 0) }}"
                        required
                    >
                    <div class="input-info">
                        ℹ️ Maksimal: Rp {{ number_format($denda->total_denda, 0, ',', '.') }}
                    </div>
                    @error('potongan_denda')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alasan Potongan -->
                <div class="form-group">
                    <label for="alasan_potongan">Alasan Potongan</label>
                    <textarea 
                        id="alasan_potongan"
                        name="alasan_potongan" 
                        class="form-control @error('alasan_potongan') is-invalid @enderror"
                        placeholder="Jelaskan alasan memberikan potongan denda..."
                        rows="4"
                        required
                    >{{ old('alasan_potongan', $denda->alasan_potongan ?? '') }}</textarea>
                    @error('alasan_potongan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Calculation Box -->
                <div class="calculation-box">
                    <div class="calculation-row">
                        <span>Total Denda:</span>
                        <span>Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</span>
                    </div>
                    <div class="calculation-row">
                        <span>Potongan:</span>
                        <span>- Rp <span id="potonganDisplay">{{ number_format($denda->potongan_denda ?? 0, 0, ',', '.') }}</span></span>
                    </div>
                    <div class="calculation-row total">
                        <span>Denda Akhir:</span>
                        <span>Rp <span id="dendaAkhirDisplay">{{ number_format($denda->denda_akhir, 0, ',', '.') }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn-submit">
                    ✓ Simpan Potongan
                </button>
            </div>
        </form>

        <!-- Cancel Potongan Button (jika sudah ada potongan) -->
        @if($denda->potongan_denda > 0)
            <form method="POST" action="{{ route('denda.cancelPotongan', $denda->id_denda) }}" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-cancel" onclick="return confirm('Batalkan potongan denda ini?')">
                    🔄 Batalkan Potongan
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    // Real-time calculation
    document.getElementById('potongan_denda').addEventListener('input', function() {
        const totalDenda = {{ $denda->total_denda }};
        const potongan = parseInt(this.value) || 0;
        const dendaAkhir = Math.max(0, totalDenda - potongan);

        document.getElementById('potonganDisplay').textContent = 
            new Intl.NumberFormat('id-ID').format(potongan);
        document.getElementById('dendaAkhirDisplay').textContent = 
            new Intl.NumberFormat('id-ID').format(dendaAkhir);
    });
</script>
@endsection
