<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Persewaan Alat</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                        url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=2070');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">PersewaanAlatApp</h1>
            <ul class="flex gap-6 font-medium">
                <li><a href="#home" class="hover:text-blue-600">Home</a></li>
                <li><a href="#alat" class="hover:text-blue-600">Daftar Alat</a></li>
                <li><a href="#about" class="hover:text-blue-600">Tentang</a></li>
                <li><a href="#contact" class="hover:text-blue-600">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="home" class="hero-bg h-screen flex items-center justify-center text-center text-white px-6">
        <div>
            <h2 class="text-5xl font-extrabold drop-shadow-md">Temukan Alat Terbaik Untuk Kebutuhan Anda</h2>
            <p class="text-lg mt-4 max-w-2xl mx-auto opacity-90">Kami menyediakan berbagai alat berkualitas untuk disewa dengan harga terjangkau.</p>
        </div>
    </section>

    <!-- SEARCH SECTION -->
    <section id="alat" class="max-w-7xl mx-auto px-6 py-16">
        <h3 class="text-3xl font-bold text-center mb-10">Cari Alat</h3>
        <div class="flex justify-center mb-10">
            <input type="text" placeholder="Cari nama alat..." class="w-full max-w-lg p-3 rounded-xl shadow-md border outline-blue-400">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @include('components.card-alat', [
            'id' => 1,
            'nama' => 'Kamera DSLR',
            'kategori' => 'Elektronik',
            'harga' => 'Rp 150.000 / hari',
            'gambar' => 'https://images.unsplash.com/photo-1602526216437-31c45e44a8d2?q=80&w=2070'
        ])

        
            @include('components.card-alat', [
                'id' => 2,
                'nama' => 'Lighting Studio',
                'kategori' => 'Fotografi',
                'harga' => 'Rp 100.000 / hari',
                'gambar' => 'https://images.unsplash.com/photo-1604507278048-5c2b9a0551c1?q=80&w=2070'
            ])

            @include('components.card-alat', [
                'id' => 3,
                'nama' => 'Drone 4K',
                'kategori' => 'Aerial',
                'harga' => 'Rp 300.000 / hari',
                'gambar' => 'https://images.unsplash.com/photo-1581093588401-22f83175fffa?q=80&w=2070'
            ])

        </div>


    <!-- ABOUT SECTION -->
    <section id="about" class="bg-blue-600 text-white py-16 px-6 text-center">
        <h3 class="text-3xl font-bold mb-4">Tentang Kami</h3>
        <p class="max-w-3xl mx-auto opacity-90">Kami adalah penyedia layanan persewaan alat terpercaya dengan koleksi lengkap dan harga terbaik. Melayani berbagai kebutuhan mulai dari acara, proyek, hingga dokumentasi profesional.</p>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="max-w-7xl mx-auto px-6 py-16 text-center">
        <h3 class="text-3xl font-bold mb-4">Kontak</h3>
        <p class="text-gray-700 mb-6">Hubungi kami kapan saja untuk pertanyaan atau pemesanan.</p>
        <a href="mailto:admin@persewaan.com" class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md hover:bg-blue-700">Email Kami</a>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-white text-center py-5">
        <p>© 2025 PersewaanAlatApp — All Rights Reserved</p>
    </footer>

</body>
</html>
