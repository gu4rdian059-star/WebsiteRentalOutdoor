@extends('layouts.app')

@section('title', 'Login - Persewaan Alat Outdoor')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        position: relative;
        overflow: hidden;
    }

    .login-container::before {
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

    .login-container::after {
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

    .login-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 450px;
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

    .login-header {
        background: linear-gradient(135deg, #1e8e5a 0%, #28c76f 100%);
        padding: 40px 30px;
        text-align: center;
        color: #fff;
    }

    .login-header .header-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .login-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .login-header p {
        font-size: 0.95rem;
        opacity: 0.95;
        margin-top: 8px;
        margin-bottom: 0;
    }

    .login-body {
        padding: 40px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4f4e5 0%, #c4f0d8 100%);
        border: none;
        border-left: 4px solid #1e8e5a;
        color: #1e8e5a;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
        font-weight: 500;
        animation: slideIn 0.5s ease;
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

    .btn-login {
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

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(30, 142, 90, 0.35);
        color: #fff;
        background: linear-gradient(135deg, #28c76f 0%, #1e8e5a 100%);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .login-divider {
        position: relative;
        text-align: center;
        margin: 30px 0;
        color: #999;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .login-divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, #ddd, transparent);
    }

    .login-divider span {
        background: #fff;
        padding: 0 12px;
        position: relative;
        z-index: 1;
    }

    .login-footer {
        text-align: center;
        padding-top: 10px;
        border-top: 1px solid #e0e0e0;
        margin-top: 20px;
    }

    .login-footer p {
        color: #555;
        font-size: 0.95rem;
        margin: 0;
    }

    .login-footer a {
        color: #1e8e5a;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        position: relative;
    }

    .login-footer a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #1e8e5a, #28c76f);
        transition: width 0.3s ease;
    }

    .login-footer a:hover {
        color: #28c76f;
    }

    .login-footer a:hover::after {
        width: 100%;
    }

    @media (max-width: 768px) {
        .login-card {
            max-width: 95%;
            margin: 20px auto;
        }

        .login-header {
            padding: 30px 25px;
        }

        .login-header h1 {
            font-size: 1.7rem;
        }

        .login-body {
            padding: 30px 25px;
        }

        .form-control {
            font-size: 16px;
            padding: 12px 15px 12px 40px;
        }

        .btn-login {
            padding: 12px 25px;
            font-size: 1rem;
        }
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
</style>

<div class="login-container">
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="header-icon">🏕️</div>
            <h1>Masuk</h1>
            <p>Kelola petualangan outdoor Anda</p>
        </div>

        <!-- Body -->
        <div class="login-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <strong>✓ Berhasil!</strong> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

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
                        placeholder="Masukkan password Anda" 
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    🚀 Login Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="login-divider">
                <span>atau</span>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>Belum punya akun? 
                    <a href="{{ route('register') }}">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
