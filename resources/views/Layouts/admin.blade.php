<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Admin - OutdoorRent')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed: 70px;
            --green-primary: #1e8e5a;
            --green-secondary: #28c76f;
            --green-light: #e8f5e9;
            --green-dark: #15633e;
            --dark-bg: #1a1d23;
            --dark-sidebar: #212529;
            --dark-card: #2a2d35;
            --dark-hover: #32363e;
            --text-primary: #e8eaed;
            --text-secondary: #9aa0a6;
            --border-color: #32363e;
        }

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f2f5;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1a2332 0%, #0f1923 100%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 25px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--green-primary), var(--green-secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(30, 142, 90, 0.3);
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand-text h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar-brand-text small {
            color: var(--text-secondary);
            font-size: 0.7rem;
            font-weight: 400;
        }

        .sidebar-section-title {
            padding: 20px 20px 8px;
            font-size: 0.7rem;
            font-weight: 600;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            margin: 2px 12px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.25s ease;
            font-size: 0.88rem;
            font-weight: 500;
            position: relative;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }

        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(135deg, var(--green-primary), var(--green-secondary));
            box-shadow: 0 4px 15px rgba(30, 142, 90, 0.3);
        }

        .sidebar-link.active i {
            color: #fff;
        }

        .sidebar-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-link .badge-count {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            color: #fff;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .sidebar-link.active .badge-count {
            background: rgba(255,255,255,0.25);
        }

        .sidebar-footer {
            padding: 15px 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.25s ease;
            font-size: 0.88rem;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .sidebar-logout:hover {
            color: #ff6b6b;
            background: rgba(255,107,107,0.1);
        }

        .sidebar-logout i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        /* ========== MAIN CONTENT ========== */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========== TOP BAR ========== */
        .admin-topbar {
            background: #fff;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e8eaed;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: #333;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .topbar-toggle:hover {
            background: #f0f2f5;
        }

        .topbar-title h4 {
            font-weight: 700;
            font-size: 1.15rem;
            color: #1a1d23;
            margin: 0;
        }

        .topbar-title p {
            font-size: 0.8rem;
            color: #9aa0a6;
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-notification {
            position: relative;
            width: 40px;
            height: 40px;
            background: #f0f2f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            text-decoration: none;
            transition: all 0.2s;
        }

        .topbar-notification:hover {
            background: var(--green-light);
            color: var(--green-primary);
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ff6b6b;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }

        .topbar-profile:hover {
            background: #f0f2f5;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--green-primary), var(--green-secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .topbar-user-info {
            display: flex;
            flex-direction: column;
        }

        .topbar-user-info .name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1a1d23;
        }

        .topbar-user-info .role {
            font-size: 0.7rem;
            color: #9aa0a6;
            text-transform: capitalize;
        }

        /* ========== CONTENT AREA ========== */
        .admin-content {
            padding: 25px 30px;
        }

        /* ========== RESPONSIVE ========== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .topbar-toggle {
                display: block;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* ========== SHARED ADMIN STYLES ========== */
        .admin-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #e8eaed;
            overflow: hidden;
        }

        .admin-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e8eaed;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-card-header h5 {
            font-weight: 700;
            font-size: 1.05rem;
            color: #1a1d23;
            margin: 0;
        }

        .admin-card-body {
            padding: 24px;
        }

        /* Buttons */
        .btn-green {
            background: linear-gradient(135deg, var(--green-primary), var(--green-secondary));
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 142, 90, 0.35);
            color: #fff;
        }

        .btn-outline-green {
            background: transparent;
            color: var(--green-primary);
            border: 2px solid var(--green-primary);
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-outline-green:hover {
            background: var(--green-primary);
            color: #fff;
        }

        .btn-danger-soft {
            background: #fef2f2;
            color: #dc2626;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-danger-soft:hover {
            background: #dc2626;
            color: #fff;
        }

        .btn-warning-soft {
            background: #fffbeb;
            color: #d97706;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-warning-soft:hover {
            background: #d97706;
            color: #fff;
        }

        /* Table Styles */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table thead {
            background: linear-gradient(135deg, #f8fafb, #f0f2f5);
        }

        .admin-table th {
            padding: 14px 16px;
            font-weight: 600;
            color: #555;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--green-primary);
            text-align: left;
        }

        .admin-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: middle;
            font-size: 0.9rem;
            color: #333;
        }

        .admin-table tbody tr {
            transition: background 0.2s;
        }

        .admin-table tbody tr:hover {
            background: #f8fafb;
        }

        .admin-table .actions-cell {
            display: flex;
            gap: 6px;
        }

        .admin-table .actions-cell a,
        .admin-table .actions-cell button {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .action-edit {
            background: #fffbeb;
            color: #d97706;
        }

        .action-edit:hover {
            background: #d97706;
            color: #fff;
        }

        .action-delete {
            background: #fef2f2;
            color: #dc2626;
        }

        .action-delete:hover {
            background: #dc2626;
            color: #fff;
        }

        .action-view {
            background: var(--green-light);
            color: var(--green-primary);
        }

        .action-view:hover {
            background: var(--green-primary);
            color: #fff;
        }

        /* Page header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-header h3 {
            font-weight: 700;
            color: #1a1d23;
            margin: 0;
            font-size: 1.5rem;
        }

        .page-header p {
            color: #9aa0a6;
            margin: 4px 0 0 0;
            font-size: 0.88rem;
        }

        .page-header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Alert */
        .admin-alert {
            position: relative;
            border-radius: 12px;
            border: none;
            padding: 16px 50px 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .admin-alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid var(--green-primary);
        }

        .admin-alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        .admin-alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        /* Hide the footer for admin layout */
        .admin-content footer {
            display: none;
        }

        /* Form styles */
        .admin-content .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: #333;
            margin-bottom: 6px;
        }

        .admin-content .form-control,
        .admin-content .form-select {
            border-radius: 10px;
            border: 2px solid #e8eaed;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .admin-content .form-control:focus,
        .admin-content .form-select:focus {
            border-color: var(--green-primary);
            box-shadow: 0 0 0 3px rgba(30, 142, 90, 0.1);
        }

        /* Badge styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d4f4e5;
            color: #0d9668;
        }

        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-danger {
            background: #fecaca;
            color: #dc2626;
        }

        .badge-info {
            background: #e0f2fe;
            color: #0284c7;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: #f0f2f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: #9aa0a6;
        }

        .empty-state h5 {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #9aa0a6;
            margin-bottom: 20px;
        }

        /* Transition animations */
        .fade-in {
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('admin-styles')
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ========== SIDEBAR ========== -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-tree-fill"></i>
            </div>
            <div class="sidebar-brand-text">
                <h5>OUTDOOR RENT</h5>
                <small>Admin Panel</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-title">UTAMA</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-section-title">KELOLA DATA</div>
            <a href="{{ route('alat.index') }}" class="sidebar-link {{ request()->routeIs('alat.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Data Alat</span>
            </a>
            <a href="{{ route('pelanggan.index') }}" class="sidebar-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Pelanggan</span>
            </a>

            <div class="sidebar-section-title">TRANSAKSI</div>
            <a href="{{ route('transaksi_sewa.index') }}" class="sidebar-link {{ request()->routeIs('transaksi_sewa.*') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Transaksi Sewa</span>
            </a>
            <a href="{{ route('denda.index') }}" class="sidebar-link {{ request()->routeIs('denda.*') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>Data Denda</span>
            </a>

            <div class="sidebar-section-title">PENGATURAN</div>
            <a href="{{ route('settings.edit') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Pengaturan</span>
            </a>
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="bi bi-globe2"></i>
                <span>Lihat Website</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ========== MAIN ========== -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-title">
                    <h4>@yield('page-title', 'Dashboard')</h4>
                    <p>@yield('page-description', 'Overview admin panel')</p>
                </div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('admin.dashboard') }}" class="topbar-notification">
                    <i class="bi bi-bell"></i>
                    @if(isset($stokKosongCount) && $stokKosongCount > 0)
                        <span class="notification-dot"></span>
                    @endif
                </a>
                <div class="topbar-profile dropdown">
                    <a href="#" class="topbar-profile d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                        <div class="topbar-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="topbar-user-info d-none d-md-flex">
                            <span class="name">{{ Auth::user()->name }}</span>
                            <span class="role">Admin</span>
                        </div>
                        <i class="bi bi-chevron-down" style="color:#9aa0a6; font-size:0.8rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="border:none; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.12); margin-top:10px;">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile') }}">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item py-2 text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="admin-content fade-in">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="admin-alert admin-alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); font-size: 0.75rem;"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="admin-alert admin-alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); font-size: 0.75rem;"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="admin-alert admin-alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); font-size: 0.75rem;"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    </script>
    @yield('admin-scripts')
</body>
</html>
