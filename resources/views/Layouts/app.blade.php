<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Persewaan Alat Outdoor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(135deg, #f5f7fa 0%, #f8fafb 100%); min-height: 100vh; }
        .navbar-custom { background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%); padding: 15px 0; box-shadow: 0 8px 20px rgba(30, 142, 90, 0.15); }
        .navbar-brand { font-weight: 800; color: #fff !important; letter-spacing: 1px; font-size: 24px; }
        .nav-link { color: #eafff3 !important; font-weight: 500; margin: 0 8px; padding: 10px 16px !important; border-radius: 25px; }
        .nav-link:hover { background: rgba(255, 255, 255, 0.2); color: #fff !important; }
        .login-btn { background: rgba(255, 255, 255, 0.95); color: #1e8e5a !important; font-weight: 600; border-radius: 25px; padding: 10px 20px !important; margin-left: 15px; }
        .dropdown-menu { border: none; border-radius: 15px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12); }
        .content-wrapper { margin-top: 30px; margin-bottom: 50px; }
        footer { background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%); color: #ecf0f1; padding: 40px 0 20px; margin-top: 80px; }
        footer h5 { color: #fff; font-weight: 700; margin-bottom: 20px; }
        footer a { color: #ffffff; text-decoration: none; display: block; padding: 5px 0; }
        .badge-admin { background: #e8f4f8; color: #2c3e50; padding: 6px 12px; border-radius: 20px; font-size: 11px; }
        .badge-penyewa { background: #e8f8f1; color: #1e8e5a; padding: 6px 12px; border-radius: 20px; font-size: 11px; }
    </style>
</head>
<body class="@if(Auth::user()?->role === 'admin') admin-theme @endif">
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="bi bi-tree-fill"></i> OUTDOOR RENT @auth @if(Auth::user()->role === 'admin')<span class="badge-admin">ADMIN</span>@else<span class="badge-penyewa">PENYEWA</span>@endif @endauth</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/alat"><i class="bi bi-box-seam"></i> Katalog</a></li>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.dashboard') }}" style="background: rgba(255,255,255,0.2); font-weight: 700;">
                                <i class="bi bi-speedometer2"></i> PANEL ADMIN
                            </a>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/transaksi_sewa"><i class="bi bi-receipt-cutoff"></i> Transaksi Sewa</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('denda.my') }}"><i class="bi bi-exclamation-triangle-fill"></i> Denda Saya</a></li>
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                <i class="bi bi-cart3"></i>
                                @php $cartCount = count(session()->get('cart', [])); @endphp
                                <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                      style="{{ $cartCount > 0 ? '' : 'display: none;' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> {{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i> Profil</a></li>
                            <li><form method="POST" action="{{ route('logout') }}">@csrf<button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button></form></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link login-btn"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="container content-wrapper">@yield('content')</div>
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3"><h5><i class="bi bi-tree-fill"></i> OUTDOOR RENT</h5><p class="small">Penyedia layanan persewaan alat outdoor terlengkap dan terpercaya.</p></div>
            <div class="col-md-3"><h5>Menu</h5><a href="/"><i class="bi bi-chevron-right"></i> Home</a><a href="/alat"><i class="bi bi-chevron-right"></i> Daftar Alat</a><a href="/transaksi_sewa"><i class="bi bi-chevron-right"></i> Transaksi</a></div>
            <div class="col-md-3"><h5>Layanan</h5><a href="#"><i class="bi bi-chevron-right"></i> Sewa Alat</a><a href="#"><i class="bi bi-chevron-right"></i> Pembayaran</a><a href="#"><i class="bi bi-chevron-right"></i> Pengembalian</a></div>
            <div class="col-md-3">
                <h5>Kontak Kami</h5>
                <p class="small"><i class="bi bi-telephone"></i> 085236132763/p>
                <p class="small"><i class="bi bi-envelope"></i> outdoorrent@gmail.com</p>
                <div class="mt-3">
                    <a href="https://instagram.com/ferdyfrmansky" target="_blank" class="d-inline-flex align-items-center justify-content-center rounded-circle text-white me-2" style="width:36px;height:36px;background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);text-decoration:none;"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/6282277349333" target="_blank" class="d-inline-flex align-items-center justify-content-center rounded-circle text-white" style="width:36px;height:36px;background:#25D366;text-decoration:none;"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,0.1);">
            <p class="small">&copy; 2026 OUTDOOR RENT. All rights reserved.</p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
