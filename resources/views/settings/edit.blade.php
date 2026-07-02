@extends('layouts.admin')

@section('title', 'Pengaturan Lokasi & Kontak - Admin')
@section('page-title', 'Pengaturan')
@section('page-description', 'Kelola lokasi & kontak OutdoorRent')

@section('content')

<style>
    .settings-header {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        color: #fff;
        padding: 40px;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(30, 142, 90, 0.2);
    }

    .settings-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .settings-card {
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .settings-card h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #1e8e5a;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1.05rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #1e8e5a;
        box-shadow: 0 0 0 3px rgba(30, 142, 90, 0.1);
    }

    .form-text {
        display: block;
        margin-top: 8px;
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        font-family: 'Courier New', monospace;
    }

    .input-group-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .input-group-wrapper {
            grid-template-columns: 1fr;
        }
    }

    .form-error {
        color: #e74c3c;
        font-size: 0.9rem;
        margin-top: 8px;
        display: block;
    }

    .btn-submit {
        background: linear-gradient(135deg, #1e8e5a, #28c76f);
        color: #fff;
        border: none;
        padding: 14px 40px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 142, 90, 0.3);
    }

    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .alert-success {
        background: #e8f5e9;
        border-left: 4px solid #28c76f;
        color: #27ae60;
    }

    .alert-error {
        background: #fadbd8;
        border-left: 4px solid #e74c3c;
        color: #c0392b;
    }

    .preview-map {
        width: 100%;
        height: 300px;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .preview-map iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .coordinate-info {
        background: linear-gradient(135deg, #e9f9f1 0%, #d4f4e5 100%);
        border-left: 4px solid #1e8e5a;
        padding: 16px;
        border-radius: 8px;
        margin-top: 25px;
    }

    .coordinate-info p {
        margin: 8px 0;
        color: #1e8e5a;
        font-weight: 500;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 20px;
        background: #e0e0e0;
        color: #2c3e50;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #bdbdbd;
        color: #2c3e50;
    }
</style>

<div class="container mt-4">
    {{-- Back Button --}}
    <a href="{{ route('home') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    {{-- Header --}}
    <div class="settings-header">
        <h2><i class="bi bi-gear"></i> Pengaturan Lokasi & Kontak</h2>
        <p>Kelola informasi alamat dan koordinat untuk Google Maps di halaman utama</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle" style="font-size: 1.3rem; flex-shrink: 0;"></i>
            <div>
                <strong>Berhasil!</strong><br>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Settings Form --}}
    <div class="settings-card">
        <h3><i class="bi bi-map-fill" style="color: #1e8e5a; margin-right: 10px;"></i>Informasi Lokasi</h3>

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            @method('PUT')

            {{-- Alamat --}}
            <div class="form-group">
                <label class="form-label" for="alamat">
                    <i class="bi bi-geo-alt"></i> Alamat Lengkap
                </label>
                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                          placeholder="Masukkan alamat lengkap toko Anda" required>{{ old('alamat', $alamat) }}</textarea>
                <span class="form-text">📍 Alamat yang ditampilkan di halaman utama</span>
                @error('alamat')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Latitude & Longitude --}}
            <div class="input-group-wrapper">
                {{-- Latitude --}}
                <div class="form-group">
                    <label class="form-label" for="latitude">
                        <i class="bi bi-pin-map"></i> Latitude
                    </label>
                    <input type="text" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" 
                           placeholder="-7.519166" value="{{ old('latitude', $latitude) }}" required>
                    <span class="form-text">🧭 Koordinat garis lintang (contoh: -7.519166)</span>
                    @error('latitude')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Longitude --}}
                <div class="form-group">
                    <label class="form-label" for="longitude">
                        <i class="bi bi-pin-map"></i> Longitude
                    </label>
                    <input type="text" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" 
                           placeholder="112.7275" value="{{ old('longitude', $longitude) }}" required>
                    <span class="form-text">🧭 Koordinat garis bujur (contoh: 112.7275)</span>
                    @error('longitude')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Telepon --}}
            <div class="form-group">
                <label class="form-label" for="telepon">
                    <i class="bi bi-telephone"></i> Nomor Telepon
                </label>
                <input type="text" id="telepon" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                       placeholder="+62 822-773-4933" value="{{ old('telepon', $telepon) }}" required>
                <span class="form-text">📞 Nomor kontak yang ditampilkan di halaman utama</span>
                @error('telepon')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-submit">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
        </form>

        {{-- Coordinate Info --}}
        <div class="coordinate-info">
            <p>
                <strong>💡 Cara mendapatkan Latitude & Longitude:</strong>
            </p>
            <ol style="margin: 10px 0 0 20px; color: #1e8e5a;">
                <li style="margin: 8px 0;">Buka <a href="https://maps.google.com" target="_blank" style="color: #1e8e5a; text-decoration: underline; font-weight: 700;">Google Maps</a></li>
                <li style="margin: 8px 0;">Cari lokasi toko Anda</li>
                <li style="margin: 8px 0;">Klik kanan pada lokasi yang tepat</li>
                <li style="margin: 8px 0;">Salin latitude dan longitude dari dropdown</li>
                <li style="margin: 8px 0;">Tempel di form ini dan simpan</li>
            </ol>
        </div>
    </div>

    {{-- Preview Map --}}
    <div class="settings-card">
        <h3><i class="bi bi-map" style="color: #1e8e5a; margin-right: 10px;"></i>Pratinjau Google Maps</h3>
        <p style="color: #7f8c8d; margin-bottom: 20px;">
            Peta akan diperbarui secara otomatis sesuai koordinat yang Anda masukkan:
        </p>
        
        @php
            $lat = old('latitude', $latitude);
            $lng = old('longitude', $longitude);
            $mapUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.9186629506337!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{$lat},{$lng}!5e0!3m2!1sid!2sid!4v1700000000000";
        @endphp

        <div class="preview-map">
            <iframe src="{{ $mapUrl }}" 
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="coordinate-info" style="margin-top: 20px;">
            <p>
                📍 <strong>Koordinat Saat Ini:</strong> 
                <span id="current-coords">{{ $lat }}, {{ $lng }}</span>
            </p>
        </div>
    </div>

</div>

<script>
    // Update coordinates display as user types
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const coordsDisplay = document.getElementById('current-coords');
    const previewFrame = document.querySelector('.preview-map iframe');

    function updatePreview() {
        const lat = latInput.value || '-7.519166';
        const lng = lngInput.value || '112.7275';
        
        coordsDisplay.textContent = lat + ', ' + lng;
        
        // Update the iframe src with new coordinates
        const mapUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.9186629506337!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z${lat},${lng}!5e0!3m2!1sid!2sid!4v1700000000000`;
        previewFrame.src = mapUrl;
    }

    latInput.addEventListener('input', updatePreview);
    lngInput.addEventListener('input', updatePreview);
</script>

@endsection
