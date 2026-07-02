<nav style="background:#ffffff; border-bottom:1px solid #e5e7eb;">
    <div style="max-width:1200px; margin:auto; padding:15px 30px; display:flex; justify-content:space-between; align-items:center;">
        
        <!-- Logo / Brand -->
        <div>
            <a href="{{ url('/') }}" style="font-size:20px; font-weight:bold; color:#2563eb;">
                Persewaan Alat
            </a>
        </div>

        <!-- Menu -->
        <div style="display:flex; gap:20px; align-items:center;">
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            <a href="{{ url('/pelanggan') }}">Pelanggan</a>
            <a href="{{ url('/alat') }}">Alat</a>
            <a href="{{ url('/transaksi') }}">Transaksi</a>
            <a href="{{ url('/denda') }}">Denda</a>

            @auth
                <span style="color:#555;">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

    </div>
</nav>
