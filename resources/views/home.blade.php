@extends('layouts.app')

@section('title','Home Persewaan Alat Outdoor')

@section('content')

@php
    use App\Models\Setting;
    
    // Get dynamic settings from database
    $alamat = Setting::get('alamat', 'Jl. Gatot Subroto, Indonesia');
    $latitude = Setting::get('latitude', '-7.519166');
    $longitude = Setting::get('longitude', '112.7275');
    $telepon = Setting::get('telepon', '+62 822-773-4933');
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
@endphp

<style>
    /* ===============================
       PREMIUM CORPORATE DESIGN SYSTEM
       =============================== */
    :root {
        --primary: #0d9668;
        --primary-dark: #07745a;
        --primary-light: #34d399;
        --accent: #f59e0b;
        --dark: #0f172a;
        --dark-card: #1e293b;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-500: #64748b;
        --gray-700: #334155;
        --gray-900: #0f172a;
        --radius-lg: 24px;
        --radius-xl: 32px;
        --shadow-soft: 0 4px 24px rgba(0,0,0,0.06);
        --shadow-medium: 0 8px 40px rgba(0,0,0,0.1);
        --shadow-heavy: 0 20px 60px rgba(0,0,0,0.15);
        --gradient-brand: linear-gradient(135deg, #0d9668 0%, #34d399 100%);
        --gradient-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    /* ===============================
       FADE IN ANIMATIONS
       =============================== */
    .fade-in-section {
        opacity: 0;
        visibility: hidden;
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .fade-in-section.visible { opacity: 1; visibility: visible; }
    .fade-in-section.delay-1 { transition-delay: 0.1s; }
    .fade-in-section.delay-2 { transition-delay: 0.2s; }
    .fade-in-section.delay-3 { transition-delay: 0.3s; }
    .fade-in-section.delay-4 { transition-delay: 0.4s; }
    .fade-in-section.delay-5 { transition-delay: 0.5s; }
    .fade-in-section.fade-up { transform: translateY(50px); }
    .fade-in-section.fade-up.visible { transform: translateY(0); }
    .fade-in-section.fade-left { transform: translateX(-50px); }
    .fade-in-section.fade-left.visible { transform: translateX(0); }
    .fade-in-section.fade-right { transform: translateX(50px); }
    .fade-in-section.fade-right.visible { transform: translateX(0); }

    /* ===============================
       PREMIUM SECTION HEADERS
       =============================== */
    .section-header { text-align: center; margin-bottom: 60px; }
    .section-header .section-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, rgba(13,150,104,0.1), rgba(52,211,153,0.1));
        border: 1px solid rgba(13,150,104,0.2);
        color: var(--primary); font-weight: 600; font-size: 0.85rem;
        padding: 8px 20px; border-radius: 50px; margin-bottom: 16px;
        text-transform: uppercase; letter-spacing: 1.5px;
    }
    .section-header h2 {
        font-size: 2.8rem; font-weight: 800; color: var(--dark);
        line-height: 1.2; margin-bottom: 16px; letter-spacing: -0.5px;
    }
    .section-header p { font-size: 1.15rem; color: var(--gray-500); max-width: 600px; margin: 0 auto; line-height: 1.7; }
    .section-header.light h2 { color: #fff; }
    .section-header.light p { color: rgba(255,255,255,0.75); }

    /* ===============================
       FEATURE CARDS (GLASSMORPHISM)
       =============================== */
    .feature-card {
        opacity: 0; transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        background: #fff; border-radius: var(--radius-lg); padding: 40px 30px;
        border: 1px solid var(--gray-200); position: relative; overflow: hidden;
        box-shadow: var(--shadow-soft);
    }
    .feature-card.visible { opacity: 1; transform: translateY(0); }
    .feature-card:nth-child(1) { transition-delay: 0.0s; }
    .feature-card:nth-child(2) { transition-delay: 0.12s; }
    .feature-card:nth-child(3) { transition-delay: 0.24s; }
    .feature-card:nth-child(4) { transition-delay: 0.36s; }
    .feature-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: var(--gradient-brand); opacity: 0; transition: opacity 0.4s;
    }
    .feature-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-medium); }
    .feature-card:hover::before { opacity: 1; }
    .feature-icon-wrap {
        width: 72px; height: 72px; border-radius: 20px;
        background: linear-gradient(135deg, rgba(13,150,104,0.08), rgba(52,211,153,0.12));
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 24px; font-size: 2rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .feature-card:hover .feature-icon-wrap {
        background: var(--gradient-brand); transform: scale(1.1) rotate(-5deg);
    }
    .feature-card:hover .feature-icon-wrap span { filter: brightness(10); }
    .feature-card h5 { font-weight: 700; font-size: 1.15rem; color: var(--dark); margin-bottom: 10px; }
    .feature-card p { color: var(--gray-500); font-size: 0.92rem; line-height: 1.7; margin: 0; }

    /* ===============================
       WHY CHOOSE US (DARK SECTION)
       =============================== */
    .why-section {
        background: var(--gradient-dark); border-radius: var(--radius-xl);
        padding: 80px 50px; margin: 0 -12px 60px; position: relative; overflow: hidden;
    }
    .why-section::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(13,150,104,0.15), transparent 70%);
        border-radius: 50%;
    }
    .why-section::after {
        content: ''; position: absolute; bottom: -80px; left: -80px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(52,211,153,0.1), transparent 70%);
        border-radius: 50%;
    }
    .why-card {
        opacity: 0; transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        background: rgba(255,255,255,0.05); backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.08); border-radius: 20px;
        padding: 32px 28px; position: relative; overflow: hidden;
    }
    .why-card.visible { opacity: 1; transform: translateY(0); }
    .why-card:nth-child(1) { transition-delay: 0.0s; }
    .why-card:nth-child(2) { transition-delay: 0.08s; }
    .why-card:nth-child(3) { transition-delay: 0.16s; }
    .why-card:nth-child(4) { transition-delay: 0.24s; }
    .why-card:nth-child(5) { transition-delay: 0.32s; }
    .why-card:nth-child(6) { transition-delay: 0.4s; }
    .why-card:hover {
        background: rgba(255,255,255,0.1); border-color: rgba(13,150,104,0.4);
        transform: translateY(-6px);
    }
    .why-card .why-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: linear-gradient(135deg, rgba(13,150,104,0.3), rgba(52,211,153,0.2));
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .why-card h6 { font-weight: 700; color: #fff; font-size: 1.05rem; margin-bottom: 6px; }
    .why-card p { color: rgba(255,255,255,0.6); font-size: 0.88rem; margin: 0; line-height: 1.6; }

    /* ===============================
       STATS SECTION (ANIMATED COUNTERS)
       =============================== */
    .stats-section {
        background: var(--gradient-brand); border-radius: var(--radius-xl);
        padding: 70px 50px; margin: 0 -12px 60px;
        position: relative; overflow: hidden;
    }
    .stats-section::before {
        content: ''; position: absolute; inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .stat-counter {
        opacity: 0; transform: scale(0.7);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: center; position: relative; z-index: 1;
    }
    .stat-counter.visible { opacity: 1; transform: scale(1); }
    .stat-counter .stat-num {
        font-size: 3.5rem; font-weight: 900; color: #fff;
        line-height: 1; margin-bottom: 8px; text-shadow: 0 2px 10px rgba(0,0,0,0.15);
    }
    .stat-counter .stat-label {
        font-size: 0.95rem; color: rgba(255,255,255,0.85);
        font-weight: 500; text-transform: uppercase; letter-spacing: 1px;
    }
    .stat-divider {
        width: 1px; height: 60px; background: rgba(255,255,255,0.2); align-self: center;
    }

    /* ===============================
       TESTIMONIALS (PREMIUM)
       =============================== */
    .testimonial-card {
        opacity: 0; transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        background: #fff; border-radius: var(--radius-lg); padding: 36px 32px;
        border: 1px solid var(--gray-200); position: relative;
        box-shadow: var(--shadow-soft);
    }
    .testimonial-card.visible { opacity: 1; transform: translateY(0); }
    .testimonial-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-medium); }
    .testimonial-card::before {
        content: '"'; position: absolute; top: 20px; right: 28px;
        font-size: 5rem; font-family: Georgia, serif; color: rgba(13,150,104,0.08);
        line-height: 1;
    }
    .testimonial-stars { color: var(--accent); font-size: 1rem; margin-bottom: 16px; letter-spacing: 2px; }
    .testimonial-card .testi-text { color: var(--gray-700); font-size: 0.95rem; line-height: 1.8; font-style: italic; margin-bottom: 24px; }
    .testi-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: var(--gradient-brand); display: flex; align-items: center;
        justify-content: center; color: #fff; font-weight: 700; font-size: 1.1rem;
        flex-shrink: 0;
    }
    .testi-name { font-weight: 700; color: var(--dark); font-size: 0.95rem; }
    .testi-role { font-size: 0.82rem; color: var(--gray-500); }

    /* ===============================
       CTA SECTION (PREMIUM)
       =============================== */
    .cta-section {
        background: var(--gradient-dark); border-radius: var(--radius-xl);
        padding: 80px 50px; position: relative; overflow: hidden;
        box-shadow: var(--shadow-heavy);
    }
    .cta-section::before {
        content: ''; position: absolute; top: -100px; right: -50px;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(13,150,104,0.25) 0%, transparent 70%);
        border-radius: 50%;
    }
    .cta-section::after {
        content: ''; position: absolute; bottom: -80px; left: -80px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(52,211,153,0.15), transparent 70%);
        border-radius: 50%;
    }
    .cta-section h2 { color: #fff; font-size: 2.8rem; font-weight: 800; position: relative; z-index: 1; }
    .cta-section p { color: rgba(255,255,255,0.7); position: relative; z-index: 1; font-size: 1.15rem; }
    .cta-btn-primary {
        background: var(--gradient-brand); color: #fff; border: none;
        padding: 16px 40px; border-radius: 50px; font-weight: 700;
        font-size: 1.05rem; text-decoration: none; display: inline-flex;
        align-items: center; gap: 10px; transition: all 0.4s;
        box-shadow: 0 8px 30px rgba(13,150,104,0.4); position: relative; z-index: 1;
    }
    .cta-btn-primary:hover { transform: translateY(-4px) scale(1.03); box-shadow: 0 14px 40px rgba(13,150,104,0.5); color: #fff; }
    .cta-btn-outline {
        background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.3);
        padding: 14px 38px; border-radius: 50px; font-weight: 600;
        font-size: 1.05rem; text-decoration: none; display: inline-flex;
        align-items: center; gap: 10px; transition: all 0.4s;
        position: relative; z-index: 1; backdrop-filter: blur(4px);
    }
    .cta-btn-outline:hover { background: rgba(255,255,255,0.1); border-color: #fff; color: #fff; transform: translateY(-4px); }

    /* =============== DASHBOARD ADMIN STYLES =============== */
    .stat-card {
        border: none;
        border-radius: 20px;
        background: linear-gradient(135deg, #f8fafb 0%, #f0f7f4 100%);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 30px 25px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(30, 142, 90, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(30, 142, 90, 0.15);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e8e5a;
        margin-top: 10px;
    }

    .stat-label {
        font-size: 1rem;
        color: #7f8c8d;
        font-weight: 600;
        margin-top: 10px;
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .dashboard-welcome {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        color: #fff;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 40px;
        box-shadow: 0 15px 40px rgba(30, 142, 90, 0.2);
    }

    .dashboard-welcome h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .dashboard-welcome p {
        font-size: 1.05rem;
        opacity: 0.95;
    }

    .menu-card {
        border: none;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 25px;
        min-height: 200px;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        color: inherit;
        text-decoration: none;
    }

    .menu-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1e8e5a, #28c76f);
    }

    .menu-card.customers::before {
        background: linear-gradient(90deg, #3498db, #2980b9);
    }

    .menu-card.equipment::before {
        background: linear-gradient(90deg, #2ecc71, #27ae60);
    }

    .menu-card.transactions::before {
        background: linear-gradient(90deg, #f39c12, #e67e22);
    }

    .menu-card.fines::before {
        background: linear-gradient(90deg, #e74c3c, #c0392b);
    }

    .menu-card .alert-dot {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.12);
        border: 2px solid #fff;
        z-index: 10;
    }

    .menu-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .menu-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .menu-desc {
        font-size: 0.9rem;
        color: #95a5a6;
        text-align: center;
    }

    /* =============== PENYEWA HOME STYLES =============== */
    .hero-section {
        border-radius: var(--radius-xl); padding: 120px 80px; color: #fff;
        overflow: hidden; position: relative; background-size: cover;
        background-position: center; margin-bottom: 60px; min-height: 500px;
        display: flex; align-items: center;
        box-shadow: var(--shadow-heavy);
        transition: background-image 4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hero-section::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(15,23,42,0.7) 0%, rgba(15,23,42,0.5) 100%);
        z-index: 0;
    }
    .hero-section .row { position: relative; z-index: 1; width: 100%; }
    .hero-text { animation: slideInLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .hero-text h1 {
        font-size: 3.5rem; font-weight: 800; line-height: 1.15;
        margin-bottom: 25px; letter-spacing: -1px;
    }
    .hero-text p { font-size: 1.2rem; opacity: 0.9; margin-bottom: 30px; line-height: 1.7; max-width: 500px; }
    .hero-btn {
        display: inline-block; padding: 14px 35px;
        background: var(--gradient-brand); color: #fff;
        border-radius: 50px; font-weight: 700; text-decoration: none;
        transition: all 0.4s; box-shadow: 0 8px 25px rgba(13,150,104,0.4);
    }
    .hero-btn:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 14px 35px rgba(13,150,104,0.5); color: #fff; }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* SEARCH BAR */
    .search-wrapper {
        margin: 0 0 70px 0;
        animation: slideInUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
    }
    .search-box { max-width: 680px; margin: 0 auto; position: relative; }
    .search-input {
        border-radius: 60px; padding: 18px 30px 18px 56px;
        border: 2px solid var(--gray-200); background: #fff;
        box-shadow: var(--shadow-soft); font-size: 1rem;
        transition: all 0.4s; width: 100%;
    }
    .search-input:focus {
        box-shadow: var(--shadow-medium); outline: none;
        border-color: var(--primary);
    }
    .search-box::before {
        content: ''; position: absolute; left: 22px; top: 50%; transform: translateY(-50%);
        width: 20px; height: 20px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E");
        background-size: contain;
    }
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* SECTION TITLE */
    .section-title {
        font-weight: 800; font-size: 2rem; margin-bottom: 40px;
        position: relative; display: inline-block; color: var(--dark);
    }
    .section-title::after {
        content: ''; position: absolute; bottom: -10px; left: 0;
        width: 50px; height: 4px; background: var(--gradient-brand); border-radius: 3px;
    }

    /* PRODUCT CARDS */
    .card-alat {
        border: none; border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft); transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden; height: 100%; display: flex; flex-direction: column;
        border: 1px solid var(--gray-200); background: #fff;
    }
    .card-alat:hover {
        transform: translateY(-10px); box-shadow: var(--shadow-heavy);
        border-color: rgba(13,150,104,0.2);
    }
    .card-alat img {
        height: 240px; object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card-alat:hover img { transform: scale(1.06); }
    .card-body { padding: 24px; flex-grow: 1; display: flex; flex-direction: column; }
    .badge-kategori {
        background: linear-gradient(135deg, rgba(13,150,104,0.08), rgba(52,211,153,0.12));
        color: var(--primary); font-size: 0.75rem; font-weight: 700;
        padding: 6px 16px; border-radius: 50px; display: inline-block;
        width: fit-content; margin-bottom: 12px;
        border: 1px solid rgba(13,150,104,0.15);
    }
    .card-alat h6 { font-weight: 700; font-size: 1.1rem; color: var(--dark); margin-bottom: 8px; }
    .card-alat small { color: var(--gray-500); margin-bottom: 12px; }
    .harga { color: var(--primary); font-weight: 800; font-size: 1.3rem; margin-bottom: 15px; }
    .btn-sewa {
        background: var(--gradient-brand); color: #fff; border: none;
        border-radius: 50px; padding: 12px 24px; font-weight: 600;
        transition: all 0.4s; margin-top: auto; text-decoration: none;
        display: inline-block; text-align: center; cursor: pointer;
        box-shadow: 0 4px 15px rgba(13,150,104,0.2);
    }
    .btn-sewa:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(13,150,104,0.35); color: #fff; }
    .btn-habis {
        background: var(--gray-200); color: var(--gray-500); border: none;
        border-radius: 50px; padding: 12px 24px; font-weight: 600;
        cursor: not-allowed; margin-top: auto;
    }

    /* ABOUT SECTION */
    .about-section { margin-top: 80px; padding: 60px 0; }
    .about-left h3 {
        font-weight: 800; font-size: 2.2rem; color: var(--dark);
        margin-bottom: 25px; position: relative; display: inline-block;
    }
    .about-left h3::after {
        content: ''; position: absolute; bottom: -10px; left: 0;
        width: 50px; height: 4px; background: var(--gradient-brand); border-radius: 3px;
    }
    .about-left p { color: var(--gray-700); line-height: 1.8; margin-bottom: 25px; font-size: 1.05rem; }
    .about-list { list-style: none; padding: 0; margin-top: 30px; }
    .about-list li {
        padding: 14px 0 14px 36px; color: var(--dark); font-weight: 500;
        font-size: 1.05rem; transition: all 0.35s; position: relative;
    }
    .about-list li:hover { padding-left: 42px; }
    .about-list li::before {
        content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
        width: 24px; height: 24px; border-radius: 50%;
        background: var(--gradient-brand);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 24 24'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/%3E%3C/svg%3E");
        background-size: 14px; background-repeat: no-repeat; background-position: center;
    }

    /* ===============================
       PREMIUM LOCATION & CONTACT (REFINED)
       =============================== */
    .location-wrapper {
        position: relative;
        padding: 60px 0;
    }

    .contact-glass-card {
        background: #fff;
        border-radius: 40px;
        padding: 50px;
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--gray-100);
        position: relative;
        overflow: hidden;
    }

    .contact-info-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .contact-info-header h3 {
        font-weight: 800;
        font-size: 2.8rem;
        color: var(--dark);
        margin-bottom: 12px;
        letter-spacing: -2px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 40px;
    }

    @media (min-width: 992px) {
        .contact-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .contact-item-modern {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding: 24px;
        background: var(--gray-50);
        border-radius: 24px;
        border: 1px solid transparent;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
    }

    .contact-item-modern:hover {
        background: #fff;
        border-color: var(--primary-light);
        box-shadow: 0 10px 30px rgba(13, 150, 104, 0.08);
        transform: translateY(-4px);
    }

    .contact-icon-box {
        width: 52px;
        height: 52px;
        background: #fff;
        color: var(--primary);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        transition: all 0.4s;
    }

    .contact-item-modern:hover .contact-icon-box {
        background: var(--primary);
        color: #fff;
        transform: rotate(-10deg) scale(1.1);
    }

    .contact-details {
        flex: 1;
    }

    .contact-details h6 {
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 8px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        opacity: 0.5;
    }

    .contact-details p {
        color: var(--gray-700);
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        line-height: 1.6;
    }

    .map-container-premium {
        width: 100%;
        height: 400px;
        border-radius: 32px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        border: 1px solid var(--gray-200);
    }

    .map-container-premium iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .map-overlay-btn {
        position: absolute;
        bottom: 25px;
        right: 25px;
        background: var(--dark);
        color: #fff;
        padding: 14px 28px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .map-overlay-btn:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-3px) scale(1.02);
    }

    .bg-primary-soft { background: rgba(13, 150, 104, 0.08); }
    .text-primary { color: var(--primary) !important; }
    .btn-primary { background: var(--gradient-brand); border: none; }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }

    .about-list-premium {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* MODAL */
    .modal-content { border: none; border-radius: var(--radius-lg); box-shadow: var(--shadow-heavy); }
    .modal-header {
        background: var(--gradient-brand); color: #fff;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0; border: none; padding: 25px;
    }
    .modal-header .btn-close { filter: brightness(0) invert(1); }
    .modal-title { font-weight: 800; font-size: 1.5rem; }
    .modal-body { padding: 30px; }
    .form-label { font-weight: 600; color: var(--dark); margin-bottom: 8px; }
    .form-control {
        border-radius: 14px; border: 2px solid var(--gray-200);
        padding: 12px 16px; transition: all 0.3s;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,150,104,0.1); }
    .btn-submit-sewa {
        background: var(--gradient-brand); color: #fff; border: none;
        border-radius: 14px; padding: 12px 30px; font-weight: 600;
        transition: all 0.3s; box-shadow: 0 4px 15px rgba(13,150,104,0.2);
    }
    .btn-submit-sewa:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(13,150,104,0.35); color: #fff; }
    .info-alert {
        background: linear-gradient(135deg, rgba(13,150,104,0.05), rgba(52,211,153,0.08));
        border-left: 4px solid var(--primary); color: var(--primary-dark);
        padding: 16px; border-radius: 12px; margin-bottom: 20px;
    }

    /* =============== ENHANCED CAROUSEL STYLES =============== */
    .carousel {
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(30, 142, 90, 0.2);
        position: relative;
    }

    .carousel-item {
        position: relative;
        transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        min-height: 420px;
    }

    .carousel-item img {
        transition: transform 8s cubic-bezier(0.2, 0, 0.2, 1);
        object-fit: cover;
        width: 100%;
        height: 420px;
    }

    .carousel-item.active img {
        animation: slideZoom 8s cubic-bezier(0.2, 0, 0.2, 1) forwards;
    }

    @keyframes slideZoom {
        from {
            transform: scale(1);
        }
        to {
            transform: scale(1.05);
        }
    }

    .carousel-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.5) 100%);
        z-index: 1;
        pointer-events: none;
    }

    .carousel-caption {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        top: auto !important;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 60%, transparent 100%) !important;
        padding: 60px 40px 40px !important;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: left;
    }

    .carousel-item.active .carousel-caption {
        transform: translateY(0);
        opacity: 1;
    }

    .carousel-caption h5 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 12px 0;
        letter-spacing: -0.5px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    }

    .carousel-caption p {
        font-size: 1.1rem;
        color: #f0f0f0;
        margin: 0;
        line-height: 1.5;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        opacity: 0.95;
    }

    .carousel-indicators {
        position: absolute !important;
        bottom: 25px !important;
        z-index: 10;
        left: 50%;
        transform: translateX(-50%);
        gap: 12px;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.6);
        background: rgba(255, 255, 255, 0.3);
        padding: 0;
        margin: 0;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .carousel-indicators button:hover {
        background: rgba(255, 255, 255, 0.6);
        transform: scale(1.1);
    }

    .carousel-indicators button.active {
        width: 32px;
        height: 12px;
        border-radius: 6px;
        background: #fff;
        border-color: #fff;
        transform: scale(1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        backdrop-filter: blur(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.6);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 20px;
        height: 20px;
    }

    .carousel-control-prev {
        left: 25px;
    }

    .carousel-control-next {
        right: 25px;
    }

    @media (max-width: 768px) {
        .carousel-item {
            min-height: 300px;
        }

        .carousel-item img {
            height: 300px;
        }

        .carousel-caption {
            padding: 40px 25px 25px !important;
        }

        .carousel-caption h5 {
            font-size: 1.6rem;
        }

        .carousel-caption p {
            font-size: 0.95rem;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 576px) {
        .carousel-item {
            min-height: 250px;
        }

        .carousel-item img {
            height: 250px;
        }

        .carousel-caption {
            padding: 30px 20px 20px !important;
            display: none;
        }

        .carousel-item.active .carousel-caption {
            display: block;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 80px 40px;
            min-height: auto;
        }

        .hero-text h1 {
            font-size: 2.2rem;
        }

        .hero-text p {
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.8rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fade in animation observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Animated counter for stat numbers
                if (entry.target.classList.contains('stat-counter')) {
                    const numEl = entry.target.querySelector('.stat-num');
                    if (numEl && numEl.dataset.target) {
                        const target = parseFloat(numEl.dataset.target);
                        const isDecimal = target % 1 !== 0;
                        const duration = 2000;
                        const steps = 60;
                        const increment = target / steps;
                        let current = 0;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            numEl.textContent = isDecimal ? (current / 10).toFixed(1) : Math.round(current);
                        }, duration / steps);
                    }
                }
            }
        });
    }, observerOptions);

    // Observe all fade-in elements
    document.querySelectorAll('.fade-in-section, .feature-card, .why-card, .alat-card-animate, .testimonial-card, .stat-counter').forEach(el => {
        observer.observe(el);
    });
});
</script>

<!-- PRO HERO CAROUSEL (visible only to penyewa) -->
@if(! $isAdmin)
<style>
/* ============================================
   MODERN ENTERPRISE HERO SECTION
   Premium design inspired by top tech companies
   ============================================ */
.hero-enterprise {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    margin: -30px 0 60px 0;
    padding: 0;
    width: 100vw;
    left: 50%;
    right: 50%;
    transform: translateX(-50%);
}

/* Animated Background Grid */
.hero-bg-grid {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(60px, 60px); }
}

/* Floating Orbs */
.hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.5;
    animation: orbFloat 15s ease-in-out infinite;
}

.hero-orb-1 {
    width: 500px;
    height: 500px;
    background: linear-gradient(135deg, #0d9668, #34d399);
    top: -10%;
    right: -10%;
    animation-delay: 0s;
}

.hero-orb-2 {
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    bottom: -15%;
    left: -5%;
    animation-delay: -5s;
}

.hero-orb-3 {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #f59e0b, #f97316);
    top: 40%;
    left: 30%;
    opacity: 0.3;
    animation-delay: -10s;
}

@keyframes orbFloat {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

/* Particle Canvas */
.hero-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

/* Main Content */
.hero-content-wrapper {
    position: relative;
    z-index: 10;
    width: 100%;
    padding: 140px 0 100px;
}

.hero-left {
    padding-right: 40px;
}

/* Badge */
.hero-badge-modern {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    color: rgba(255,255,255,0.9);
    margin-bottom: 30px;
    animation: fadeInDown 0.8s ease-out;
}

.hero-badge-dot {
    width: 8px;
    height: 8px;
    background: #34d399;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.2); }
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Typography */
.hero-headline {
    font-size: 4rem;
    font-weight: 800;
    line-height: 1.1;
    color: #fff;
    margin-bottom: 24px;
    letter-spacing: -0.02em;
}

.hero-headline .gradient-text {
    background: linear-gradient(135deg, #34d399 0%, #0d9668 50%, #3b82f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    background-size: 200% auto;
    animation: gradientShift 5s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.hero-subheadline {
    font-size: 1.25rem;
    line-height: 1.8;
    color: rgba(255,255,255,0.7);
    margin-bottom: 40px;
    max-width: 540px;
}

/* CTA Buttons */
.hero-cta-group {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 50px;
}

.hero-cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #0d9668 0%, #34d399 100%);
    color: #fff;
    font-weight: 600;
    font-size: 1.05rem;
    padding: 18px 36px;
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 40px rgba(13,150,104,0.4);
    border: none;
    position: relative;
    overflow: hidden;
}

.hero-cta-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s;
}

.hero-cta-primary:hover::before {
    left: 100%;
}

.hero-cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 60px rgba(13,150,104,0.5);
    color: #fff;
}

.hero-cta-secondary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(10px);
    color: #fff;
    font-weight: 600;
    font-size: 1.05rem;
    padding: 18px 36px;
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255,255,255,0.2);
}

.hero-cta-secondary:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.4);
    transform: translateY(-3px);
    color: #fff;
}

/* Trust Indicators */
.hero-trust {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    position: relative;
    z-index: 50;
    margin-bottom: 40px;
    padding: 16px 24px;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.1);
    width: fit-content;
}

.hero-trust-avatars {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 51;
}

.hero-trust-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 3px solid #0f172a;
    background: linear-gradient(135deg, #0d9668, #34d399);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-left: -12px;
    transition: transform 0.3s;
}

.hero-trust-avatar:first-child { margin-left: 0; }

.hero-trust-text {
    color: rgba(255,255,255,0.7);
    font-size: 0.95rem;
}

.hero-trust-text strong {
    color: #fff;
    font-weight: 600;
}

/* Right Side - 3D Cards Showcase */
.hero-showcase {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-showcase-card {
    position: absolute;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    animation: cardFloat 6s ease-in-out infinite;
}

.hero-showcase-card-1 {
    width: 280px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
    z-index: 3;
}

.hero-showcase-card-2 {
    width: 260px;
    bottom: 15%;
    left: 5%;
    animation-delay: -2s;
    z-index: 2;
}

.hero-showcase-card-3 {
    width: 240px;
    top: 40%;
    right: 40%;
    animation-delay: -4s;
    z-index: 1;
}

@keyframes cardFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(2deg); }
}

.hero-card-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 16px;
}

.hero-card-title {
    color: #fff;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 8px;
}

.hero-card-price {
    color: #34d399;
    font-weight: 800;
    font-size: 1.3rem;
}

.hero-card-tag {
    display: inline-block;
    background: rgba(13,150,104,0.3);
    color: #34d399;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
    margin-top: 8px;
}

/* Stats Bar */
.hero-stats-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 30px 0;
    z-index: 20;
}

.hero-stats-content {
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.hero-stat-item {
    text-align: center;
}

.hero-stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    margin-bottom: 8px;
}

.hero-stat-number span {
    color: #34d399;
}

.hero-stat-label {
    color: rgba(255,255,255,0.6);
    font-size: 0.9rem;
    font-weight: 500;
}

/* Scroll Indicator */
.hero-scroll-modern {
    position: absolute;
    bottom: 120px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 30;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    animation: bounceModern 2s infinite;
}

.hero-scroll-text {
    color: rgba(255,255,255,0.5);
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hero-scroll-line {
    width: 1px;
    height: 60px;
    background: linear-gradient(to bottom, #34d399, transparent);
}

@keyframes bounceModern {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(-10px); }
}

/* Responsive */
@media (max-width: 991px) {
    .hero-enterprise {
        min-height: auto;
        padding: 80px 0 140px;
    }
    
    .hero-headline {
        font-size: 2.8rem;
    }
    
    .hero-subheadline {
        font-size: 1.1rem;
    }
    
    .hero-left {
        padding-right: 0;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .hero-cta-group {
        justify-content: center;
    }
    
    .hero-trust {
        justify-content: center;
    }
    
    .hero-subheadline {
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-showcase {
        height: 400px;
    }
    
    .hero-showcase-card {
        transform: scale(0.85);
    }
    
    .hero-stats-content {
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .hero-stat-number {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .hero-headline {
        font-size: 2.2rem;
    }
    
    .hero-showcase {
        display: none;
    }
    
    .hero-cta-primary,
    .hero-cta-secondary {
        padding: 14px 28px;
        font-size: 0.95rem;
    }
    
    .hero-stats-bar {
        padding: 20px 0;
    }
    
    .hero-stat-number {
        font-size: 1.5rem;
    }
    
    .hero-stat-label {
        font-size: 0.8rem;
    }
}
</style>

<!-- MODERN ENTERPRISE HERO -->
<div class="hero-enterprise" id="heroEnterprise">
    <!-- Animated Background -->
    <div class="hero-bg-grid"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    
    <div class="hero-content-wrapper">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-6 hero-left">
                    <div class="hero-badge-modern">
                        <span class="hero-badge-dot"></span>
                        Persewaan Alat Outdoor #1 di Indonesia
                    </div>
                    
                    <h1 class="hero-headline">
                        Siapkan Petualanganmu dengan <span class="gradient-text">Peralatan Terbaik</span>
                    </h1>
                    
                    <p class="hero-subheadline">
                        Temukan ribuan peralatan outdoor berkualitas premium untuk pengalaman camping, hiking, dan eksplorasi alam yang tak terlupakan.
                    </p>
                    
                    <div class="hero-cta-group">
                        <a href="{{ route('alat.index') }}" class="hero-cta-primary">
                            <i class="bi bi-compass"></i>
                            Jelajahi Katalog
                        </a>
                        <a href="#features" class="hero-cta-secondary">
                            <i class="bi bi-play-circle"></i>
                            Pelajari Lebih
                        </a>
                    </div>
                    
                    <div class="hero-trust">
                        <div class="hero-trust-avatars">
                            <div class="hero-trust-avatar">🏕️</div>
                            <div class="hero-trust-avatar">⛰️</div>
                            <div class="hero-trust-avatar">🎒</div>
                            <div class="hero-trust-avatar">🔥</div>
                        </div>
                        <div class="hero-trust-text">
                            <strong>10,000+</strong> pelanggan puas telah mempercayai kami
                        </div>
                    </div>
                </div>
                
                <!-- Right Showcase -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-showcase">
                        <div class="hero-showcase-card hero-showcase-card-1">
                            <img src="{{ asset('images/alat/tenda.jpg') }}" alt="Tenda" class="hero-card-img">
                            <div class="hero-card-title">Tenda Dome 4P</div>
                            <div class="hero-card-price">Rp 150.000/hari</div>
                            <span class="hero-card-tag">⭐ Best Seller</span>
                        </div>
                        
                        <div class="hero-showcase-card hero-showcase-card-2">
                            <img src="{{ asset('images/buthak.jpg') }}" alt="Camping" class="hero-card-img">
                            <div class="hero-card-title">Paket Camping Lengkap</div>
                            <div class="hero-card-price">Rp 350.000/hari</div>
                            <span class="hero-card-tag">🔥 Hot Deal</span>
                        </div>
                        
                        <div class="hero-showcase-card hero-showcase-card-3">
                            <div style="height: 140px; background: linear-gradient(135deg, #0d9668, #34d399); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin-bottom: 16px;">⛺</div>
                            <div class="hero-card-title">Kompor Portable</div>
                            <div class="hero-card-price">Rp 25.000/hari</div>
                            <span class="hero-card-tag">✨ New</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Bar -->
    <div class="hero-stats-bar">
        <div class="container">
            <div class="hero-stats-content">
                <div class="hero-stat-item">
                    <div class="hero-stat-number"><span>{{ \App\Models\Alat::count() }}</span>+</div>
                    <div class="hero-stat-label">Alat Tersedia</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number"><span>{{ \App\Models\Pelanggan::count() }}</span>+</div>
                    <div class="hero-stat-label">Pelanggan Aktif</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number"><span>4.9</span>/5</div>
                    <div class="hero-stat-label">Rating Kepuasan</div>
                </div>
                <div class="hero-stat-item">
                    <div class="hero-stat-number"><span>24</span>/7</div>
                    <div class="hero-stat-label">Layanan Support</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="hero-scroll-modern" onclick="document.getElementById('features')?.scrollIntoView({behavior: 'smooth'})">
        <span class="hero-scroll-text">Scroll</span>
        <div class="hero-scroll-line"></div>
    </div>
</div>

<script>
// Add animation on scroll
document.addEventListener('DOMContentLoaded', function() {
    const heroElements = document.querySelectorAll('.hero-headline, .hero-subheadline, .hero-cta-group, .hero-trust');
    
    heroElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 300 + (index * 150));
    });
    
    // Stats counter animation
    const statNumbers = document.querySelectorAll('.hero-stat-number span');
    const animateStats = () => {
        statNumbers.forEach(num => {
            const target = parseInt(num.textContent) || 0;
            if (target === 0) return;
            
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                num.textContent = Math.floor(current);
            }, 30);
        });
    };
    
    // Trigger stats animation after hero loads
    setTimeout(animateStats, 1000);
});
</script>
@endif

@if($isAdmin)
    {{-- ==================== DASHBOARD ADMIN ==================== --}}
    <div class="dashboard-welcome">
        <h2>👋 Selamat Datang, {{ Auth::user()?->name ?? 'Admin' }}</h2>
        <p>Kelola semua aspek persewaan alat outdoor Anda dari sini</p>
    </div>

    <div class="row g-4 mb-5">
        {{-- STAT PELANGGAN --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-label">Total Pelanggan</div>
                <div class="stat-number">
                    {{ \App\Models\Pelanggan::count() ?? 0 }}
                </div>
            </div>
        </div>

        {{-- STAT ALAT --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">🏕️</div>
                <div class="stat-label">Total Alat</div>
                <div class="stat-number">
                    {{ \App\Models\Alat::count() ?? 0 }}
                </div>
            </div>
        </div>

        {{-- STAT TRANSAKSI --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-label">Transaksi Bulan Ini</div>
                <div class="stat-number">
                    {{ \App\Models\TransaksiSewa::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count() ?? 0 }}
                </div>
            </div>
        </div>

        {{-- STAT DENDA --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">⚠️</div>
                <div class="stat-label">Total Denda</div>
                <div class="stat-number">
                    {{ \App\Models\Denda::count() ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== TRANSAKSI TERBARU (ADMIN) ==================== --}}
    <h3 class="section-title mt-5">📌 Transaksi Terbaru</h3>
    <div class="table-responsive mb-5">
        @php
            $recent = \App\Models\TransaksiSewa::with(['pelanggan','alat'])
                ->orderBy('id_sewa','desc')
                ->take(6)
                ->get();
        @endphp

        @if($recent->count())
            <table class="table table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Alat</th>
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($recent as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $r->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td>{{ $r->alat->nama_alat ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tanggal_sewa)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tanggal_kembali)->format('d-m-Y') }}</td>
                            <td>
                                @if($r->status === 'disewa')
                                    <span class="badge bg-warning text-dark">Disewa</span>
                                @elseif($r->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($r->status === 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td class="fw-bold text-primary">Rp {{ number_format((($r->total_harga ?? 0) + ($r->denda ?? 0)),0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">Belum ada transaksi.</div>
        @endif
    </div>

    <h3 class="section-title mb-4">⚙️ Menu Kelola</h3>
    <div class="row g-4">
        {{-- MENU KELOLA PELANGGAN --}}
        <div class="col-md-3">
            <a href="{{ route('pelanggan.index') }}" class="menu-card customers" style="position: relative;">
                <div class="menu-icon">👥</div>
                <div class="menu-title">Kelola Pelanggan</div>
                <div class="menu-desc">Tambah, edit, atau hapus data pelanggan</div>
            </a>
        </div>

        {{-- MENU KELOLA ALAT --}}
        <div class="col-md-3">
            <a href="{{ route('alat.index') }}" class="menu-card equipment" style="position: relative;">
                <div class="menu-icon">🏕️</div>
                <div class="menu-title">Kelola Alat</div>
                <div class="menu-desc">Atur stok dan detail peralatan</div>
            </a>
        </div>

        {{-- MENU KELOLA TRANSAKSI --}}
        <div class="col-md-3">
            <a href="{{ route('transaksi_sewa.index') }}" class="menu-card transactions" style="position: relative;">
                <div class="menu-icon">📋</div>
                <div class="menu-title">Kelola Transaksi</div>
                <div class="menu-desc">Pantau semua transaksi sewa</div>
            </a>
        </div>

        {{-- MENU PENGATURAN LOKASI --}}
        <div class="col-md-3">
            <a href="{{ route('settings.edit') }}" class="menu-card fines" style="position: relative;">
                <span class="alert-dot" title="Perlu diperhatikan"></span>
                <div class="menu-icon">📍</div>
                <div class="menu-title">Pengaturan Lokasi</div>
                <div class="menu-desc">Kelola alamat & koordinat maps</div>
            </a>
        </div>
    </div>

@else
    {{-- ==================== HOME PENYEWA ==================== --}}
    <div class="dashboard-welcome" style="background: var(--gradient-dark); box-shadow: var(--shadow-heavy);">
        <h2>👋 Selamat Datang, {{ Auth::user()?->name ?? 'Guest' }}</h2>
        <p style="opacity: 0.8;">Kelola transaksi sewa Anda dari sini — temukan peralatan outdoor terbaik dengan mudah</p>
    </div>

    {{-- ==================== FEATURES SECTION (PREMIUM) ==================== --}}
    <div class="mb-5">
        <div class="section-header">
            <div class="section-badge">✨ Layanan Kami</div>
            <h2>Mengapa Memilih Kami?</h2>
            <p>Nikmati pengalaman sewa alat outdoor yang mudah, terpercaya, dan berkualitas tinggi</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon-wrap mx-auto"><span>🏕️</span></div>
                    <h5>Alat Berkualitas</h5>
                    <p>Peralatan outdoor premium dari brand ternama, terawat dan selalu siap pakai</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon-wrap mx-auto"><span>💰</span></div>
                    <h5>Harga Terjangkau</h5>
                    <p>Harga sewa paling kompetitif dengan berbagai pilihan paket hemat untuk Anda</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon-wrap mx-auto"><span>🚚</span></div>
                    <h5>Pengantaran</h5>
                    <p>Layanan antar-jemput peralatan langsung ke lokasi Anda dengan cepat</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon-wrap mx-auto"><span>⭐</span></div>
                    <h5>Pelayanan Prima</h5>
                    <p>Tim profesional kami siap membantu Anda 24/7 untuk pengalaman terbaik</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== WHY CHOOSE US (DARK PREMIUM) ==================== --}}
    <div class="why-section mb-5">
        <div class="section-header light">
            <div class="section-badge" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9);">🏆 Keunggulan Kami</div>
            <h2>Keuntungan Bersama Kami</h2>
            <p>Nikmati berbagai keunggulan eksklusif yang kami tawarkan untuk setiap pelanggan</p>
        </div>

        <div class="row g-4" style="position: relative; z-index: 1;">
            <div class="col-md-4">
                <div class="why-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="why-icon">🧹</div>
                        <div>
                            <h6>Alat Bersih & Terawat</h6>
                            <p>Setiap alat dibersihkan dan diperiksa menyeluruh sebelum disewakan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="why-icon">⚡</div>
                        <div>
                            <h6>Proses Sewa Mudah</h6>
                            <p>Cepat dan praktis hanya dalam beberapa klik saja</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="why-icon">🛡️</div>
                        <div>
                            <h6>Garansi 100%</h6>
                            <p>Garansi kepuasan pelanggan untuk setiap transaksi tanpa terkecuali</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="why-icon">📦</div>
                        <div>
                            <h6>Stok Selalu Tersedia</h6>
                            <p>Update stok real-time agar Anda tidak pernah kecewa</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="why-icon">🎧</div>
                        <div>
                            <h6>Bantuan 24/7</h6>
                            <p>Tim support responsif siap membantu kapan saja Anda butuhkan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="why-icon">🔄</div>
                        <div>
                            <h6>Fleksibel</h6>
                            <p>Pengembalian mudah dan fleksibel sesuai kesepakatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== STATISTICS SECTION (PREMIUM) ==================== --}}
    <div class="stats-section mb-5">
        <div class="d-flex justify-content-around align-items-center flex-wrap gap-4">
            <div class="stat-counter">
                <div class="stat-num" data-target="{{ \App\Models\Alat::count() }}">0</div>
                <div class="stat-label">Alat Tersedia</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="stat-counter">
                <div class="stat-num" data-target="{{ \App\Models\Pelanggan::count() }}">0</div>
                <div class="stat-label">Pelanggan Happy</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="stat-counter">
                <div class="stat-num" data-target="{{ \App\Models\TransaksiSewa::count() }}">0</div>
                <div class="stat-label">Transaksi Sukses</div>
            </div>
            <div class="stat-divider d-none d-md-block"></div>
            <div class="stat-counter">
                <div class="stat-num" data-target="49">0</div>
                <div class="stat-label">Rating ★</div>
            </div>
        </div>
    </div>

    {{-- ==================== TESTIMONIALS (PREMIUM) ==================== --}}
    <div class="mb-5">
        <div class="section-header">
            <div class="section-badge">💬 Testimoni</div>
            <h2>Apa Kata Pelanggan Kami?</h2>
            <p>Testimoni dari pelanggan yang telah mempercayai layanan kami</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card h-100">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testi-text">"Alat yang disewa kualitasnya luar biasa! Tim sangat helpful dan responsif. Pasti akan sewa lagi untuk camping berikutnya!"</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="testi-avatar">A</div>
                        <div>
                            <div class="testi-name">Adi Pratama</div>
                            <div class="testi-role">Pelanggan Setia</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card h-100">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testi-text">"Sangat recommend! Proses sewa cepat, alat lengkap, dan harga sangat terjangkau. Mendaki bersama keluarga jadi lebih mudah."</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="testi-avatar" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">S</div>
                        <div>
                            <div class="testi-name">Siti Rahayu</div>
                            <div class="testi-role">Pelanggan Baru</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card h-100">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testi-text">"Pertama kali sewa tenda, hasilnya luar biasa. Alat bersih, berfungsi normal, dan pelayanan sangat memuaskan!"</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="testi-avatar" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">B</div>
                        <div>
                            <div class="testi-name">Budi Santoso</div>
                            <div class="testi-role">Pelanggan Regular</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== CTA SECTION (PREMIUM) ==================== --}}
    <div class="cta-section mb-5 text-center">
        <h2 class="fw-bold mb-3">Siap Untuk Petualangan Anda?</h2>
        <p class="mb-4 mx-auto" style="max-width: 550px;">Sewa peralatan outdoor terbaik sekarang dan nikmati pengalaman tak terlupakan di alam bebas!</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('alat.index') }}" class="cta-btn-primary">
                <i class="bi bi-compass"></i> Lihat Katalog
            </a>
            <a href="{{ route('login') }}" class="cta-btn-outline">
                <i class="bi bi-person-plus"></i> Daftar Sekarang
            </a>
        </div>
    </div>

    {{-- ==================== SEARCH BAR ==================== --}}
    <div class="search-wrapper" style="margin: 40px 0;">
        <form method="GET" action="{{ route('home') }}" class="search-box mx-auto">
            <input type="text" name="q" class="form-control search-input" placeholder="Cari alat (nama atau kategori)..." value="{{ request('q') }}">
        </form>
    </div>

    {{-- ==================== ALAT FEATURED (JIKA TIDAK ADA SEARCH) ==================== --}}
    @if(!request('q'))
        <div class="section-header" style="text-align: left; margin-bottom: 40px;">
            <div class="section-badge">🎒 Katalog</div>
            <h2 style="font-size: 2rem;">Alat Sewa Tersedia</h2>
        </div>
        @if($alats->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($alats as $alat)
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-alat h-100 border-0 shadow-sm rounded-4 btn-detail-alat cursor-pointer"
                             data-id="{{ $alat->id_alat }}"
                             data-nama="{{ $alat->nama_alat }}"
                             data-harga="{{ $alat->harga_sewa }}"
                             data-kategori="{{ $alat->kategori }}"
                             data-merk="{{ $alat->merk }}"
                             data-deskripsi="{{ $alat->deskripsi }}"
                             data-kegunaan="{{ $alat->kegunaan }}"
                             data-stok="{{ $alat->stok }}"
                             data-gambar="{{ asset('images/alat/'.$alat->gambar) }}"
                             style="cursor: pointer; transition: transform 0.2s;">
                            @if($alat->gambar)
                                <img src="{{ asset('images/alat/'.$alat->gambar) }}"
                                    alt="{{ $alat->nama_alat }}"
                                    class="w-100"
                                    style="height:250px;object-fit:cover">
                            @else
                                <img src="{{ asset('images/no-image.png') }}"
                                    alt="No Image"
                                    class="w-100"
                                    style="height:250px;object-fit:cover">
                            @endif

                            {{-- STOK --}}
                            <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2">
                                Stok {{ $alat->stok }}
                            </span>

                            {{-- BODY --}}
                            <div class="card-body">
                                <h6 class="fw-bold mb-1">{{ $alat->nama_alat }}</h6>
                                <small class="text-muted d-block mb-2">{{ $alat->kategori }}</small>

                                <div class="fw-bold text-success fs-5 mb-3">
                                    Rp {{ number_format($alat->harga_sewa,0,',','.') }}/hari
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mb-5">
                <a href="{{ route('alat.index') }}" class="btn btn-lg" style="background: var(--gradient-brand); color: #fff; padding: 14px 45px; font-weight: 700; border-radius: 50px; box-shadow: 0 8px 30px rgba(13,150,104,0.3); transition: all 0.4s;">
                    <i class="bi bi-arrow-right-circle me-2"></i>Lihat Semua Alat
                </a>
            </div>
        @else
            <div class="alert alert-warning text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Belum ada alat yang tersedia</h5>
                <p class="text-muted">Silahkan kembali nanti atau hubungi kami untuk informasi lebih lanjut</p>
            </div>
        @endif
    @endif

    {{-- ==================== SEARCH RESULTS ==================== --}}
    @if(request('q'))
        <div class="alert alert-info mb-4">
            Hasil pencarian untuk: <strong>{{ request('q') }}</strong>
            <a href="{{ route('home') }}" class="ms-3">Reset</a>
        </div>

        @if($alats->count() > 0)
            <h3 class="section-title mb-4">🔍 Hasil Pencarian ({{ $alats->count() }} alat ditemukan)</h3>
            <div class="row g-4 mb-5">
                @foreach($alats as $alat)
                    <div class="col-md-6 col-lg-3">
                        <div class="card-alat btn-detail-alat cursor-pointer"
                             data-id="{{ $alat->id_alat }}"
                             data-nama="{{ $alat->nama_alat }}"
                             data-harga="{{ $alat->harga_sewa }}"
                             data-kategori="{{ $alat->kategori }}"
                             data-merk="{{ $alat->merk }}"
                             data-deskripsi="{{ $alat->deskripsi }}"
                             data-kegunaan="{{ $alat->kegunaan }}"
                             data-stok="{{ $alat->stok }}"
                             data-gambar="{{ asset('images/alat/'.$alat->gambar) }}"
                             style="cursor: pointer; transition: transform 0.2s;">
                            @if($alat->gambar)
                                <img src="{{ asset('images/alat/'.$alat->gambar) }}" alt="{{ $alat->nama_alat }}">
                            @else
                                <div style="height:240px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-image" style="font-size:3rem; color:#ccc;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <span class="badge-kategori">{{ $alat->kategori }}</span>
                                <h6>{{ $alat->nama_alat }}</h6>
                                <small>Stok: {{ $alat->stok }} unit</small>
                                <div class="harga">Rp {{ number_format($alat->harga_sewa,0,',','.') }}/hari</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center py-5">
                <i class="bi bi-search" style="font-size:3rem;"></i>
                <h5 class="mt-3">Alat tidak ditemukan</h5>
                <p class="text-muted">Tidak ada alat yang sesuai dengan pencarian "{{ request('q') }}"</p>
            </div>
        @endif
    @endif

    {{-- ==================== ABOUT & LOCATION SECTION (PREMIUM) ==================== --}}
    <div class="location-wrapper mb-5" style="margin-top: 120px;">
        <div class="container-fluid">
            <div class="row g-5 align-items-center">
                {{-- LEFT: BRAND STORY --}}
                <div class="col-lg-5">
                    <div class="fade-in-section fade-left">
                        <div class="section-badge mb-4">✨ Discovery</div>
                        <h2 class="display-5 fw-bold mb-4" style="letter-spacing: -1.5px;">Petualangan Dimulai <span class="text-primary">Dari Sini.</span></h2>
                        <p class="lead text-muted mb-5" style="line-height: 1.8;">
                            Kami bukan sekadar penyedia alat, kami adalah mitra perjalanan Anda. Setiap peralatan kami kurasi dengan standar keamanan tertinggi untuk menjamin momen petualangan Anda tetap aman dan menyenangkan.
                        </p>
                        
                        <div class="about-list-premium">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="bg-primary-soft p-3 rounded-circle text-primary">
                                    <i class="bi bi-shield-check fs-4"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Peralatan Teruji & Bersertifikasi</h5>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="bg-primary-soft p-3 rounded-circle text-primary">
                                    <i class="bi bi-star fs-4"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Rating Pelanggan 4.9/5.0 Bintang</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: CONTACT GLASS CARD --}}
                <div class="col-lg-7">
                    <div class="contact-glass-card fade-in-section fade-up">
                        <div class="contact-info-header">
                            <h3>Kunjungi Store Kami</h3>
                            <p class="text-muted">Tim kami siap membantu Anda memilih perlengkapan terbaik untuk destinasi tujuan Anda.</p>
                        </div>

                        <div class="contact-grid">
                            <div class="contact-item-modern">
                                <div class="contact-icon-box">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h6>Lokasi Utama</h6>
                                    <p>{{ $alamat }}</p>
                                </div>
                            </div>
                            <div class="contact-item-modern">
                                <div class="contact-icon-box">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="contact-details">
                                    <h6>Hubungi Kami</h6>
                                    <p>{{ $telepon }}</p>
                                </div>
                            </div>
                            <div class="contact-item-modern">
                                <div class="contact-icon-box">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="contact-details">
                                    <h6>Jam Operasional</h6>
                                    <p>08:00 - 18:00 WIB (Sen-Min)</p>
                                </div>
                            </div>
                            <div class="contact-item-modern">
                                <div class="contact-icon-box">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h6>Email Support</h6>
                                    <p>support@outdoorview.com</p>
                                </div>
                            </div>
                        </div>

                        @php
                            $mapUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.9186629506337!2d{$longitude}!3d{$latitude}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{$latitude},{$longitude}!5e0!3m2!1sid!2sid!4v1700000000000";
                        @endphp
                        <div class="map-container-premium">
                            <iframe 
                                src="{{ $mapUrl }}" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $latitude }},{{ $longitude }}" target="_blank" class="map-overlay-btn">
                                <i class="bi bi-cursor-fill"></i> Get Directions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL FORM SEWA (UNTUK MEMBUAT TRANSAKSI BARU) --}}
    <div class="modal fade" id="modalSewa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        🎒 Sewa Alat: <span id="namaAlatModal"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="info-alert">
                        <i class="bi bi-info-circle"></i> <strong>Informasi Penting:</strong> 
                        Pilih tanggal sewa dan kembali untuk melanjutkan.
                    </div>

                    <form id="formSewa">
                        @csrf
                        
                        <input type="hidden" id="idAlatHidden" name="id_alat">
                        <input type="hidden" id="modeHidden" name="mode" value="cart">

                        {{-- NAMA ALAT (READONLY) --}}
                        <div class="mb-3">
                            <label class="form-label">📦 Nama Alat</label>
                            <input type="text" class="form-control" id="namaAlatInput" disabled>
                        </div>

                        {{-- HARGA PER HARI --}}
                        <div class="mb-3">
                            <label class="form-label">💰 Harga Per Hari</label>
                            <input type="text" class="form-control" id="hargaAlatInput" disabled>
                        </div>

                        {{-- TANGGAL SEWA --}}
                        <div class="mb-3">
                            <label class="form-label" for="tglSewa">📅 Tanggal Sewa</label>
                            <input type="date" class="form-control" id="tglSewa" name="tgl_sewa" required>
                        </div>

                        {{-- TANGGAL KEMBALI --}}
                        <div class="mb-3">
                            <label class="form-label" for="tglKembali">📅 Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tglKembali" name="tgl_kembali" required>
                        </div>

                        {{-- QUANTITY --}}
                        <div class="mb-3">
                            <label class="form-label">📦 Jumlah Alat</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" id="btnQtyMinus">−</button>
                                <input type="number" class="form-control text-center" id="quantityInput" name="quantity" value="1" min="1" style="max-width: 80px;">
                                <button type="button" class="btn btn-outline-secondary" id="btnQtyPlus">+</button>
                            </div>
                        </div>

                        {{-- JUMLAH HARI DAN TOTAL HARGA --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">📊 Jumlah Hari</label>
                                <input type="number" class="form-control" id="jumlahHari" disabled value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">💵 Subtotal</label>
                                <input type="text" class="form-control fw-bold text-success" id="totalHarga" disabled value="Rp 0">
                            </div>
                        </div>

                        <div class="modal-footer border-top pt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="btnAksi" class="btn btn-submit-sewa">
                                ✅ Masukkan ke Keranjang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM SEWA SCRIPT --}}
    <script>
document.addEventListener('DOMContentLoaded', function () {

    let currentMode = 'cart'; // Default mode
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }}; // Cek user login

    // Event untuk membuka modal (cart atau checkout)
    document.querySelectorAll('.btn-cart-icon, .btn-sewa-sekarang').forEach(btn => {
        btn.addEventListener('click', function () {
            // Cek auth terlebih dahulu
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            const idAlat   = this.dataset.id;
            const namaAlat = this.dataset.nama;
            const harga    = this.dataset.harga;
            currentMode    = this.dataset.mode || 'cart'; // Set mode dari tombol

            document.getElementById('idAlatHidden').value = idAlat;
            document.getElementById('modeHidden').value = currentMode;
            document.getElementById('namaAlatModal').textContent = namaAlat;
            document.getElementById('namaAlatInput').value = namaAlat;
            document.getElementById('hargaAlatInput').value =
                'Rp ' + Number(harga).toLocaleString('id-ID');

            // Ubah text button berdasarkan mode
            const btnAksi = document.getElementById('btnAksi');
            if (currentMode === 'cart') {
                btnAksi.innerHTML = '✅ Masukkan ke Keranjang';
            } else {
                btnAksi.innerHTML = '✅ Lanjut ke Checkout';
            }

            // Reset form
            document.getElementById('tglSewa').value = '';
            document.getElementById('tglKembali').value = '';
            document.getElementById('quantityInput').value = 1;
            document.getElementById('jumlahHari').value = 0;
            document.getElementById('totalHarga').value = 'Rp 0';
        });
    });

    // Fungsi menghitung total hari dan subtotal (dengan quantity)
    function hitungTotal() {
        const tglSewa = document.getElementById('tglSewa').value;
        const tglKembali = document.getElementById('tglKembali').value;
        const quantity = parseInt(document.getElementById('quantityInput').value) || 1;
        
        if (!tglSewa || !tglKembali) return;

        const start = new Date(tglSewa);
        const end = new Date(tglKembali);
        
        if (end < start) {
            alert('Tanggal kembali tidak valid (harus setelah tanggal sewa)');
            return;
        }

        const hari = Math.ceil((end - start) / (1000*60*60*24)) + 1;
        const harga = parseInt(
            document.getElementById('hargaAlatInput').value.replace(/\D/g,'')
        );

        // Total = (Harga per hari × Jumlah hari) × Quantity
        const total = (harga * hari) * quantity;

        document.getElementById('jumlahHari').value = hari;
        document.getElementById('totalHarga').value =
            'Rp ' + total.toLocaleString('id-ID');
    }

    // Event listener untuk tanggal
    document.getElementById('tglSewa').addEventListener('change', hitungTotal);
    document.getElementById('tglKembali').addEventListener('change', hitungTotal);
    
    // Event listener untuk quantity +/-
    document.getElementById('quantityInput').addEventListener('change', hitungTotal);
    
    document.getElementById('btnQtyMinus').addEventListener('click', function(e) {
        e.preventDefault();
        const qtyInput = document.getElementById('quantityInput');
        const current = parseInt(qtyInput.value) || 1;
        if (current > 1) {
            qtyInput.value = current - 1;
            hitungTotal();
        }
    });

    document.getElementById('btnQtyPlus').addEventListener('click', function(e) {
        e.preventDefault();
        const qtyInput = document.getElementById('quantityInput');
        const current = parseInt(qtyInput.value) || 1;
        qtyInput.value = current + 1;
        hitungTotal();
    });

    // Event untuk tombol Aksi (Masukkan ke Keranjang atau Lanjut Checkout)
    document.getElementById('btnAksi').addEventListener('click', function () {
        const idAlat = document.getElementById('idAlatHidden').value;
        const tglSewa = document.getElementById('tglSewa').value;
        const tglKembali = document.getElementById('tglKembali').value;
        const mode = document.getElementById('modeHidden').value;

        // Validasi
        if (!idAlat || !tglSewa || !tglKembali) {
            alert('Silakan isi semua field');
            return;
        }

        const start = new Date(tglSewa);
        const end = new Date(tglKembali);
        
        if (end < start) {
            alert('Tanggal kembali tidak valid');
            return;
        }

        if (mode === 'cart') {
            // Mode: Masukkan ke Keranjang - POST ke route('cart.add')
            const quantity = parseInt(document.getElementById('quantityInput').value) || 1;
            const jumlahHari = parseInt(document.getElementById('jumlahHari').value) || 1;
            
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id_alat: idAlat,
                    tgl_sewa: tglSewa,
                    tgl_kembali: tglKembali,
                    quantity: quantity,
                    jumlah_hari: jumlahHari
                })
            })
            .then(res => {
                if (res.status === 401) {
                    // Belum login
                    alert('❌ Silakan login terlebih dahulu untuk menyewa alat');
                    window.location.href = "{{ route('login') }}";
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (data && data.success) {
                    alert('✅ ' + data.message);
                    
                    // ✅ UPDATE BADGE CART DI NAVBAR
                    const cartBadge = document.getElementById('cartBadge');
                    if (cartBadge && data.cart_count !== undefined) {
                        cartBadge.textContent = data.cart_count;
                        cartBadge.style.display = 'inline-block';
                    }
                    
                    // Tutup modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalSewa'));
                    if (modal) modal.hide();
                } else if (data) {
                    alert('❌ ' + (data.message || 'Gagal menambahkan ke keranjang'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('❌ Gagal menambahkan ke keranjang');
            });
        } else {
            // Mode: Checkout - Redirect ke checkout dengan parameter
            const jumlahHari = parseInt(document.getElementById('jumlahHari').value) || 1;
            const checkoutUrl = "{{ route('cart.checkout') }}" + 
                "?id_alat=" + idAlat + 
                "&tgl_sewa=" + tglSewa + 
                "&tgl_kembali=" + tglKembali +
                "&jumlah_hari=" + jumlahHari;
            
            window.location.href = checkoutUrl;
        }
    });

});
    </script>

    <script>
    // ========== DETAIL MODAL (SHOPEE-STYLE) ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Click pada card untuk membuka detail modal
        document.querySelectorAll('.btn-detail-alat').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON') return; // Skip jika click tombol
                
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const harga = parseInt(this.dataset.harga);
                const kategori = this.dataset.kategori;
                const merk = this.dataset.merk || '-';
                const deskripsi = this.dataset.deskripsi || 'Tidak ada deskripsi';
                const kegunaan = this.dataset.kegunaan || 'Tidak ada informasi';
                const stok = parseInt(this.dataset.stok);
                const gambar = this.dataset.gambar;

                // Populate modal
                document.getElementById('detailAlatNama').textContent = nama;
                document.getElementById('detailAlatKategori').textContent = kategori;
                document.getElementById('detailAlatKat2').textContent = kategori;
                document.getElementById('detailAlatMerk').textContent = merk;
                document.getElementById('detailAlatHarga').textContent = 'Rp ' + harga.toLocaleString('id-ID');
                document.getElementById('detailAlatDeskripsi').textContent = deskripsi;
                document.getElementById('detailAlatKegunaan').textContent = kegunaan;
                document.getElementById('detailAlatGambar').src = gambar;
                document.getElementById('detailStokBadge').textContent = '📦 Stok: ' + stok + ' unit';
                
                // Reset quantity
                document.getElementById('detailQuantity').value = 1;
                
                // 🔒 DISABLE BUTTONS KALAU STOK 0
                const btnCart = document.getElementById('detailBtnCart');
                const btnCheckout = document.getElementById('detailBtnCheckout');
                
                if (stok <= 0) {
                    btnCart.disabled = true;
                    btnCheckout.disabled = true;
                    btnCart.classList.add('disabled');
                    btnCheckout.classList.add('disabled');
                    document.getElementById('detailStokBadge').classList.remove('bg-success');
                    document.getElementById('detailStokBadge').classList.add('bg-danger');
                } else {
                    btnCart.disabled = false;
                    btnCheckout.disabled = false;
                    btnCart.classList.remove('disabled');
                    btnCheckout.classList.remove('disabled');
                    document.getElementById('detailStokBadge').classList.remove('bg-danger');
                    document.getElementById('detailStokBadge').classList.add('bg-success');
                }
                
                // Store current alat data untuk digunakan di buttons
                window.currentAlatData = {
                    id: id,
                    nama: nama,
                    harga: harga,
                    quantity: 1,
                    stok: stok
                };
                
                // Buka modal
                const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
                modal.show();
            });
        });

        // Quantity buttons di detail modal
        const detailQtyInput = document.getElementById('detailQuantity');
        if (detailQtyInput) {
            document.getElementById('detailQtyMinus').addEventListener('click', function() {
                const val = parseInt(detailQtyInput.value) - 1;
                if (val >= 1) {
                    detailQtyInput.value = val;
                    if (window.currentAlatData) {
                        window.currentAlatData.quantity = val;
                    }
                }
            });

            document.getElementById('detailQtyPlus').addEventListener('click', function() {
                const val = parseInt(detailQtyInput.value) + 1;
                detailQtyInput.value = val;
                if (window.currentAlatData) {
                    window.currentAlatData.quantity = val;
                }
            });

            // Track manual input
            detailQtyInput.addEventListener('change', function() {
                const val = parseInt(this.value) || 1;
                if (val < 1) this.value = 1;
                if (window.currentAlatData) {
                    window.currentAlatData.quantity = parseInt(this.value);
                }
            });
        }

        // Tombol Masukkan Keranjang di detail modal
        document.getElementById('detailBtnCart')?.addEventListener('click', function() {
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            openModalSewa('cart');
        });

        // Tombol Sewa Sekarang di detail modal
        document.getElementById('detailBtnCheckout')?.addEventListener('click', function() {
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            openModalSewa('checkout');
        });

        function openModalSewa(mode) {
            const detailModal = bootstrap.Modal.getInstance(document.getElementById('modalDetail'));
            if (detailModal) detailModal.hide();

            // Get data dari global window.currentAlatData
            if (!window.currentAlatData) return;
            
            const idAlat = window.currentAlatData.id;
            const namaAlat = window.currentAlatData.nama;
            const harga = window.currentAlatData.harga;
            const quantity = window.currentAlatData.quantity;

            // Populate modal sewa
            document.getElementById('idAlatHidden').value = idAlat;
            document.getElementById('modeHidden').value = mode;
            document.getElementById('namaAlatModal').textContent = namaAlat;
            document.getElementById('namaAlatInput').value = namaAlat;
            document.getElementById('hargaAlatInput').value = 'Rp ' + Number(harga).toLocaleString('id-ID');

            // Update button text
            const btnAksi = document.getElementById('btnAksi');
            if (mode === 'cart') {
                btnAksi.innerHTML = '✅ Masukkan ke Keranjang';
            } else {
                btnAksi.innerHTML = '✅ Lanjut ke Checkout';
            }

            // Reset form
            document.getElementById('tglSewa').value = '';
            document.getElementById('tglKembali').value = '';
            document.getElementById('quantityInput').value = quantity;
            document.getElementById('jumlahHari').value = 0;
            document.getElementById('totalHarga').value = 'Rp 0';

            // Buka modal sewa
            setTimeout(() => {
                const sewaModal = new bootstrap.Modal(document.getElementById('modalSewa'));
                sewaModal.show();
            }, 300);
        }
    });
    </script>




    {{-- MODAL DETAIL ALAT (SHOPEE-STYLE) --}}
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0">
                <input type="hidden" id="detailAlatId" value="">
                <div class="modal-header bg-light border-bottom">
                    <div>
                        <h5 class="modal-title" id="detailAlatNama"></h5>
                        <small class="text-muted d-block" id="detailAlatKategori"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4">
                        {{-- LEFT: GAMBAR --}}
                        <div class="col-md-5">
                            <div class="position-relative">
                                <img id="detailAlatGambar" 
                                     src="" 
                                     class="img-fluid rounded-3 shadow-sm w-100" 
                                     style="height: 400px; object-fit: cover;"
                                     alt="Gambar Alat">
                                <div class="mt-3">
                                    <span class="badge bg-success" id="detailStokBadge"></span>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: INFO --}}
                        <div class="col-md-7">
                            {{-- HARGA --}}
                            <div class="mb-4">
                                <div class="display-5 fw-bold text-success" id="detailAlatHarga"></div>
                                <small class="text-muted">/hari</small>
                            </div>

                            {{-- INFO ALAT --}}
                            <div class="mb-4">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">📦 Kategori</small>
                                        <strong id="detailAlatKat2"></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">🏭 Merk</small>
                                        <strong id="detailAlatMerk"></strong>
                                    </div>
                                </div>
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="mb-4">
                                <small class="text-muted d-block mb-2">📝 Deskripsi</small>
                                <p id="detailAlatDeskripsi" class="text-justify"></p>
                            </div>

                            {{-- KEGUNAAN --}}
                            <div class="mb-4">
                                <small class="text-muted d-block mb-2">⚙️ Kegunaan</small>
                                <p id="detailAlatKegunaan"></p>
                            </div>

                            {{-- QUANTITY SELECTOR --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">📦 Jumlah Unit</label>
                                <div class="input-group" style="max-width: 150px;">
                                    <button type="button" class="btn btn-outline-secondary" id="detailQtyMinus">−</button>
                                    <input type="number" class="form-control text-center" id="detailQuantity" value="1" min="1">
                                    <button type="button" class="btn btn-outline-secondary" id="detailQtyPlus">+</button>
                                </div>
                            </div>

                            {{-- ACTION BUTTONS --}}
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-outline-success btn-lg flex-grow-1" id="detailBtnCart">
                                    <i class="bi bi-cart-plus"></i> Masukkan Keranjang
                                </button>
                                <button type="button" class="btn btn-success btn-lg flex-grow-1" id="detailBtnCheckout">
                                    <i class="bi bi-credit-card"></i> Sewa Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL FORM SEWA --}}

@endif

@endsection
