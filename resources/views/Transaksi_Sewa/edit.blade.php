@extends('layouts.admin')
@section('title','Edit Transaksi Sewa - Admin')
@section('page-title', 'Edit Transaksi')
@section('page-description', 'Perbarui data transaksi sewa')

@section('content')
<div style="max-width: 700px;">
    <a href="{{ route('transaksi_sewa.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#1e8e5a;text-decoration:none;font-weight:600;margin-bottom:20px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Data Transaksi
    </a>

    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="bi bi-pencil-square" style="color:#d97706;"></i> Edit Transaksi Sewa</h5>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('transaksi_sewa.update', $transaksi->id_sewa) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- PELANGGAN --}}
                <div class="mb-3">
                    <label class="form-label">Pelanggan</label>
                    <select name="id_pelanggan" class="form-select" required>
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->id_pelanggan }}"
                                {{ $p->id_pelanggan == $transaksi->id_pelanggan ? 'selected' : '' }}>
                                {{ $p->nama_pelanggan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ALAT --}}
                <div class="mb-3">
                    <label class="form-label">Alat Disewa</label>
                    <select name="id_alat" class="form-select" required>
                        @foreach($alats as $a)
                            <option value="{{ $a->id_alat }}"
                                {{ $a->id_alat == $transaksi->id_alat ? 'selected' : '' }}>
                                {{ $a->nama_alat }} - Rp {{ number_format($a->harga_sewa,0,',','.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TANGGAL --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Sewa</label>
                        <input type="date" name="tanggal_sewa" class="form-control"
                               value="{{ $transaksi->tanggal_sewa }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control"
                               value="{{ $transaksi->tanggal_kembali }}" required>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="statusSelect">
                        <option value="disewa" {{ $transaksi->status=='disewa'?'selected':'' }}>Disewa</option>
                        <option value="selesai" {{ $transaksi->status=='selesai'?'selected':'' }}>Selesai</option>
                        <option value="terlambat" {{ $transaksi->status=='terlambat'?'selected':'' }}>Terlambat</option>
                    </select>
                    <small style="color:#9aa0a6;">Pilih "Terlambat" untuk menghitung denda otomatis</small>
                </div>

                {{-- DENDA --}}
                <div class="mb-3">
                    <label class="form-label">Denda</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e8eaed;border-right:none;">Rp</span>
                        <input type="number" name="denda" class="form-control" id="dendaInput"
                               value="{{ $transaksi->denda ?? 0 }}" style="border-radius:0 10px 10px 0;">
                    </div>
                    <small style="color:#9aa0a6;" id="dendaInfo">
                        @if($transaksi->status === 'terlambat' && $transaksi->denda > 0)
                            Denda dihitung otomatis: {{ now()->diffInDays($transaksi->tanggal_kembali) }} hari × Rp 5.000
                        @elseif($transaksi->status === 'terlambat')
                            Denda akan dihitung saat status disimpan
                        @else
                            Denda muncul otomatis saat status diubah ke "Terlambat"
                        @endif
                    </small>
                </div>

                {{-- TOTAL --}}
                <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="number" name="total_harga" class="form-control"
                           value="{{ $transaksi->total_harga }}" required>
                </div>

                {{-- TOTAL BAYAR --}}
                <div class="mb-4">
                    <label class="form-label">Total Bayar</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e8eaed;border-right:none;">Rp</span>
                        <input type="number" class="form-control" id="totalBayar"
                               value="{{ ($transaksi->total_harga ?? 0) + ($transaksi->denda ?? 0) }}"
                               readonly style="background:#f8fafb;border-radius:0 10px 10px 0;">
                    </div>
                    <small style="color:#9aa0a6;">Total Harga + Denda</small>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn-green" type="submit">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                    <a href="{{ route('transaksi_sewa.index') }}" class="btn-outline-green">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('statusSelect');
    const dendaInput = document.getElementById('dendaInput');
    const totalBayar = document.getElementById('totalBayar');
    const totalHargaInput = document.querySelector('input[name="total_harga"]');

    const tanggalKembali = '{{ $transaksi->tanggal_kembali }}';
    const tglKembali = new Date(tanggalKembali);
    const hariIni = new Date();

    function hitungHariTerlambat() {
        tglKembali.setHours(0, 0, 0, 0);
        hariIni.setHours(0, 0, 0, 0);
        const diffTime = hariIni - tglKembali;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays > 0 ? diffDays : 0;
    }

    statusSelect.addEventListener('change', function() {
        const status = this.value;
        if (status === 'terlambat') {
            const hariTerlambat = hitungHariTerlambat();
            const denda = hariTerlambat * 5000;
            dendaInput.value = denda;
            const totalHarga = parseInt(totalHargaInput.value) || 0;
            totalBayar.value = totalHarga + denda;
            document.getElementById('dendaInfo').textContent = 'Denda: ' + hariTerlambat + ' hari x Rp 5.000 = Rp ' + denda.toLocaleString('id-ID');
        } else if (status === 'selesai') {
            dendaInput.value = 0;
            const totalHarga = parseInt(totalHargaInput.value) || 0;
            totalBayar.value = totalHarga;
            document.getElementById('dendaInfo').textContent = 'Status selesai - Denda 0';
        }
    });

    if (statusSelect.value === 'terlambat') {
        const hariTerlambat = hitungHariTerlambat();
        if (hariTerlambat > 0) {
            document.getElementById('dendaInfo').textContent = 'Denda: ' + hariTerlambat + ' hari x Rp 5.000';
        }
    }
});
</script>
@endsection
