@extends('layouts.app')

@section('title', 'Register - Persewaan Alat Outdoor')

@section('content')
<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        position: relative;
        overflow: hidden;
        padding: 40px 20px;
    }

    .register-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        animation: float 20s ease-in-out infinite;
    }

    .register-container::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
        animation: float 25s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(20px, -20px) rotate(5deg); }
        50% { transform: translate(-10px, 20px) rotate(-5deg); }
        75% { transform: translate(-20px, -30px) rotate(3deg); }
    }

    .register-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 500px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        overflow: hidden;
        animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .register-header {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        padding: 40px 30px;
        text-align: center;
        color: #fff;
    }

    .register-header .header-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .register-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .register-header p {
        font-size: 0.95rem;
        opacity: 0.95;
        margin-top: 8px;
        margin-bottom: 0;
    }

    .register-body {
        padding: 40px;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fadbd8 0%, #f5b7b1 100%);
        border: none;
        border-left: 4px solid #e74c3c;
        color: #c0392b;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
        animation: slideIn 0.5s ease;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger li {
        font-weight: 500;
        margin-bottom: 6px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-group {
        margin-bottom: 22px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
    }

    .form-group .form-icon {
        position: absolute;
        left: 18px;
        top: 39px;
        font-size: 1.2rem;
        color: #1e8e5a;
        z-index: 2;
    }

    .form-control {
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        padding: 14px 18px 14px 45px;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8fafb;
        font-weight: 500;
        color: #2c3e50;
        width: 100%;
    }

    .form-control::placeholder {
        color: #a0a0a0;
    }

    .form-control:focus {
        border-color: #1e8e5a;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(30, 142, 90, 0.1);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #e74c3c;
        background-color: rgba(231, 76, 60, 0.05);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
    }

    .invalid-feedback {
        display: block;
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 6px;
        font-weight: 500;
    }

    .btn-register {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        cursor: pointer;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 8px 25px rgba(30, 142, 90, 0.25);
        margin-top: 10px;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(30, 142, 90, 0.35);
        color: #fff;
        background: linear-gradient(135deg, #28c76f 0%, #1e8e5a 100%);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .register-footer {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #e0e0e0;
        margin-top: 25px;
    }

    .register-footer p {
        color: #555;
        font-size: 0.95rem;
        margin: 0;
    }

    .register-footer a {
        color: #1e8e5a;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        position: relative;
    }

    .register-footer a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #1e8e5a, #28c76f);
        transition: width 0.3s ease;
    }

    .register-footer a:hover {
        color: #28c76f;
    }

    .register-footer a:hover::after {
        width: 100%;
    }

    .password-info {
        background: linear-gradient(135deg, #e8f8f1 0%, #d4f4e5 100%);
        border-left: 4px solid #1e8e5a;
        color: #1e8e5a;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        margin-top: 8px;
        font-weight: 500;
        display: none;
    }

    .password-info.show {
        display: block;
        animation: slideIn 0.3s ease;
    }

    @media (max-width: 768px) {
        .register-card {
            max-width: 95%;
        }

        .register-header {
            padding: 30px 25px;
        }

        .register-header h1 {
            font-size: 1.7rem;
        }

        .register-body {
            padding: 30px 25px;
        }

        .form-control {
            font-size: 16px;
            padding: 12px 15px 12px 40px;
        }

        .btn-register {
            padding: 12px 25px;
            font-size: 1rem;
        }
    }
</style>

<div class="register-container">
    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <div class="header-icon">⛰️</div>
            <h1>Daftar Akun</h1>
            <p>Mulai petualangan Anda sekarang</p>
        </div>

        <!-- Body -->
        <div class="register-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>⚠️ Terjadi kesalahan!</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name Input -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="form-icon">👤</div>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Masukkan nama lengkap Anda" 
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="form-icon">📧</div>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="nama@email.com" 
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="form-icon">🔐</div>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Buat password yang kuat" 
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="password-info" id="passwordInfo">
                        💡 Password minimal 8 karakter
                    </div>
                </div>

                <!-- Password Confirmation Input -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="form-icon">✓</div>
                    <input 
                        type="password" 
                        id="password_confirmation"
                        name="password_confirmation" 
                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                        placeholder="Ulangi password Anda" 
                        required
                    >
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn-register">
                    🚀 Daftar Sekarang
                </button>
            </form>

            <!-- Footer -->
            <div class="register-footer">
                <p>Sudah punya akun? 
                    <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Show password info when user focuses on password field
    document.getElementById('password').addEventListener('focus', function() {
        document.getElementById('passwordInfo').classList.add('show');
    });

    document.getElementById('password').addEventListener('blur', function() {
        if (this.value.length === 0) {
            document.getElementById('passwordInfo').classList.remove('show');
        }
    });

    // Real-time password match validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmation = this.value;
        
        if (confirmation && password !== confirmation) {
            this.classList.add('is-invalid');
        } else if (password === confirmation) {
            this.classList.remove('is-invalid');
        }
    });
</script>
@endsection
