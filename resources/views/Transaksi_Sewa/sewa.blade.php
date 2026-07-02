@extends('layouts.landing')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold mb-6">Form Sewa Alat</h2>

    <div class="bg-white rounded-xl shadow-lg p-6">

        <h3 class="text-2xl font-semibold mb-4">{{ $alat->nama }}</h3>

        <img src="{{ $alat->gambar ?? 'https://via.placeholder.com/400' }}"
             class="rounded-lg mb-6 w-64">

        <p class="mb-2"><strong>Kategori:</strong> {{ $alat->kategori }}</p>
        <p class="mb-4"><strong>Harga Sewa:</strong> Rp {{ number_format($alat->harga, 0, ',', '.') }} / Hari</p>

        <form action="{{ route('transaksi_sewa.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_alat" value="{{ $alat->id }}">

            <label class="block font-semibold mt-4">Nama Penyewa</label>
            <input type="text" name="nama_penyewa" class="w-full border p-3 rounded-lg" required>

            <label class="block font-semibold mt-4">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="w-full border p-3 rounded-lg" required>

            <label class="block font-semibold mt-4">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="w-full border p-3 rounded-lg" required>

            <button type="submit"
                    class="mt-6 bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700">
                Buat Transaksi
            </button>

        </form>
    </div>
</div>
@endsection
