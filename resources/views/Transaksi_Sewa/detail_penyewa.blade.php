@extends('layouts.app')
@section('title','Detail Transaksi Sewa')

@section('content')
{{-- AMBIL JUMLAH HARI DARI DATABASE --}}
@php
    $jumlahHari = $mainTransaksi->jumlah_hari ?? 1;
@endphp

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('transaksi_sewa.index') }}" class="btn btn-secondary rounded-pill">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow border-0 rounded-4 p-4">
        <h3 class="fw-bold text-success mb-4">
            <i class="bi bi-receipt-cutoff"></i> Detail Transaksi Sewa
        </h3>

        {{-- INFORMASI TRANSAKSI --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">ID Transaksi</p>
                    <h5 class="fw-bold">#{{ $mainTransaksi->id_sewa }}</h5>
                </div>
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">Nama Pelanggan</p>
                    <h5 class="fw-bold">{{ $mainTransaksi->pelanggan->nama_pelanggan ?? '-' }}</h5>
                </div>
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">Kontak</p>
                    <h5 class="fw-bold">{{ $mainTransaksi->pelanggan->no_telepon ?? '-' }}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">Alamat</p>
                    <h5 class="fw-bold">{{ $mainTransaksi->pelanggan->alamat_pelanggan ?? '-' }}</h5>
                </div>
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">Email</p>
                    <h5 class="fw-bold">{{ $mainTransaksi->pelanggan->email_pelanggan ?? '-' }}</h5>
                </div>
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">Tanggal Pemesanan</p>
                    <h5 class="fw-bold">{{ $mainTransaksi->created_at ? $mainTransaksi->created_at->format('d-m-Y H:i') : '-' }}</h5>
                </div>
            </div>
        </div>

        <hr>

        {{-- INFORMASI ALAT --}}
        <h4 class="fw-bold text-success mb-3">
            <i class="bi bi-box-seam"></i> Detail Alat ({{ $transaksiGroup->count() }} Item)
        </h4>
        
        @forelse($transaksiGroup as $idx => $trx)
            <div class="card border-0 bg-light p-4 mb-3">
                <div class="row align-items-center">
                    {{-- GAMBAR --}}
                    <div class="col-md-3">
                        @if($trx->alat && $trx->alat->gambar)
                            <img src="{{ asset('images/alat/'.$trx->alat->gambar) }}"
                                 class="img-fluid rounded shadow-sm object-fit-cover"
                                 style="width: 100%; height: 250px;">
                        @else
                            <div class="bg-white rounded p-5 text-center">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        @endif
                    </div>
                    
                    {{-- INFO --}}
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted" width="150">Nama Alat</td>
                                <td><strong>{{ $trx->alat->nama_alat ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kategori</td>
                                <td><strong>{{ $trx->alat->kategori ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Deskripsi</td>
                                <td><strong>{{ $trx->alat->deskripsi ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Stok Tersedia</td>
                                <td><strong class="text-success">{{ $trx->alat->stok ?? '-' }} unit</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Harga / Hari</td>
                                <td><strong class="text-primary">Rp {{ number_format($trx->alat->harga_sewa ?? 0, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jumlah Satuan</td>
                                <td><strong class="text-info">{{ $trx->jumlah_satuan ?? 1 }} unit</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">Tidak ada data alat dalam transaksi ini</div>
        @endforelse

        <hr>

        {{-- INFORMASI RENTAL --}}
        <h4 class="fw-bold text-success mb-3">
            <i class="bi bi-calendar-event"></i> Jadwal & Total Sewa
        </h4>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-light border-0 p-3">
                    <p class="text-muted mb-1">Tanggal Sewa</p>
                    <h5 class="fw-bold">{{ \Carbon\Carbon::parse($mainTransaksi->tanggal_sewa)->format('d-m-Y') }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light border-0 p-3">
                    <p class="text-muted mb-1">Tanggal Kembali</p>
                    <h5 class="fw-bold">{{ \Carbon\Carbon::parse($mainTransaksi->tanggal_kembali)->format('d-m-Y') }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light border-0 p-3">
                    <p class="text-muted mb-1">Total Hari</p>
                    <h5 class="fw-bold text-primary">
                        {{ $jumlahHari }} hari
                    </h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light border-0 p-3">
                    <p class="text-muted mb-1">Total Item</p>
                    <h5 class="fw-bold text-info">
                        {{ $transaksiGroup->count() }} alat
                    </h5>
                </div>
            </div>
        </div>

        <hr>

        {{-- INFORMASI PEMBAYARAN --}}
        <h4 class="fw-bold text-success mb-3">
            <i class="bi bi-credit-card"></i> Informasi Pembayaran
        </h4>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-light border-0 p-3 mb-3">
                    <p class="text-muted mb-1">Metode Pembayaran</p>
                    <h5 class="fw-bold">
                        @if($mainTransaksi->payment_method === 'transfer_bank')
                            <i class="bi bi-bank"></i> Transfer Bank
                        @elseif($mainTransaksi->payment_method === 'e_wallet')
                            <i class="bi bi-wallet2"></i> E-Wallet
                        @else
                            {{ $mainTransaksi->payment_method ?? '-' }}
                        @endif
                    </h5>
                </div>
                <div class="card border-0 p-3 mb-3 @if($mainTransaksi->payment_status === 'pending') bg-warning bg-opacity-10 @else bg-success bg-opacity-10 @endif">
                    <p class="text-muted mb-1">Status Pembayaran</p>
                    @if($mainTransaksi->payment_status === 'pending')
                        <h5 class="fw-bold text-warning">
                            <i class="bi bi-clock-history"></i> PENDING (Menunggu Konfirmasi Admin)
                        </h5>
                    @elseif($mainTransaksi->payment_status === 'confirmed')
                        <h5 class="fw-bold text-success">
                            <i class="bi bi-check-circle"></i> CONFIRMED (Pembayaran Dikonfirmasi)
                        </h5>
                    @else
                        <h5 class="fw-bold">{{ $mainTransaksi->payment_status ?? '-' }}</h5>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                @if($mainTransaksi->payment_confirmed_at)
                    <div class="card bg-light border-0 p-3 mb-3">
                        <p class="text-muted mb-1">Dikonfirmasi Pada</p>
                        <h5 class="fw-bold">{{ \Carbon\Carbon::parse($mainTransaksi->payment_confirmed_at)->format('d-m-Y H:i') }}</h5>
                    </div>
                @endif
                @if($mainTransaksi->confirmed_by)
                    <div class="card bg-light border-0 p-3 mb-3">
                        <p class="text-muted mb-1">Dikonfirmasi Oleh</p>
                        <h5 class="fw-bold">Admin Sistem</h5>
                    </div>
                @endif
            </div>
        </div>

        <hr>

        {{-- RINGKASAN PEMBAYARAN --}}
        <h4 class="fw-bold text-success mb-3">
            <i class="bi bi-calculator"></i> Ringkasan Pembayaran
        </h4>
        @php
            // Hitung total harga dari SEMUA alat dalam group
            $totalHargaSemuaAlat = $transaksiGroup->sum('total_harga');
        @endphp
        <table class="table table-borderless">
            <tr>
                <td class="text-muted" width="60%">Total Harga (Semua Alat × {{ $jumlahHari }} hari)</td>
                <td class="text-end fw-bold">Rp {{ number_format($totalHargaSemuaAlat, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-muted">Denda</td>
                <td class="text-end fw-bold text-danger">Rp {{ number_format($mainTransaksi->denda ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="table-active">
                <td class="text-success fw-bold" width="60%">TOTAL BAYAR</td>
                <td class="text-end fw-bold text-success" style="font-size: 1.2rem;">
                    Rp {{ number_format($totalHargaSemuaAlat + ($mainTransaksi->denda ?? 0), 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <hr>

        {{-- INFORMASI STATUS SEWA --}}
        <h4 class="fw-bold text-success mb-3">
            <i class="bi bi-info-circle"></i> Status Sewa
        </h4>
        <div class="card border-0 p-3 @if($mainTransaksi->status === 'disewa') bg-warning bg-opacity-10 @elseif($mainTransaksi->status === 'selesai') bg-success bg-opacity-10 @elseif($mainTransaksi->status === 'terlambat') bg-danger bg-opacity-10 @endif">
            @if($mainTransaksi->status === 'disewa')
                <h5 class="fw-bold text-warning">
                    <i class="bi bi-hourglass-split"></i> Status: DISEWA (Sedang Berlangsung)
                </h5>
                <small class="text-muted">Alat ini sedang dalam periode sewa Anda.</small>
            @elseif($mainTransaksi->status === 'selesai')
                <h5 class="fw-bold text-success">
                    <i class="bi bi-check-circle"></i> Status: SELESAI
                </h5>
                <small class="text-muted">Alat telah dikembalikan dan sewa selesai.</small>
            @elseif($mainTransaksi->status === 'terlambat')
                <h5 class="fw-bold text-danger">
                    <i class="bi bi-exclamation-circle"></i> Status: TERLAMBAT
                </h5>
                <small class="text-muted">Alat terlambat dikembalikan. Denda telah dihitung.</small>
            @else
                <h5 class="fw-bold">Status: {{ $mainTransaksi->status ?? '-' }}</h5>
            @endif
        </div>

        <div class="mt-4 d-flex gap-3">
            {{-- TOMBOL DOWNLOAD STRUK --}}
            <a href="{{ route('transaksi_sewa.downloadStruk', $mainTransaksi->id_sewa) }}" class="btn btn-success rounded-pill" target="_blank">
                <i class="bi bi-download"></i> Download Struk (PDF)
            </a>

            {{-- TOMBOL LIHAT STRUK --}}
            <a href="{{ route('transaksi_sewa.struk', $mainTransaksi->id_sewa) }}" class="btn btn-primary rounded-pill" target="_blank">
                <i class="bi bi-receipt"></i> Lihat Struk
            </a>

            {{-- TOMBOL KERANJANG --}}
            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary rounded-pill">
                <i class="bi bi-cart3"></i> Lihat Keranjang
            </a>

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('transaksi_sewa.index') }}" class="btn btn-secondary rounded-pill">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Sewa
            </a>
        </div>
    </div>
</div>
@endsection
