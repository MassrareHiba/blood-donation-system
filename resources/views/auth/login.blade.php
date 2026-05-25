@extends('layouts.app')

@section('content')
<style>
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 50%, #7f1d1d 100%);
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        position: relative;
        padding: 20px;
    }

    .login-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .lang-switcher {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .lang-btn {
        padding: 8px 16px;
        border-radius: 20px;
        border: 2px solid rgba(255,255,255,0.5);
        background: rgba(255,255,255,0.1);
        color: white;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        backdrop-filter: blur(10px);
    }

    .lang-btn:hover, .lang-btn.active {
        background: white;
        color: #dc2626;
        border-color: white;
    }

    .login-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 25px 80px rgba(0,0,0,0.3);
        width: 100%;
        max-width: 440px;
        padding: 48px 40px;
        position: relative;
        z-index: 1;
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .logo-section {
        text-align: center;
        margin-bottom: 32px;
    }

    .blood-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #dc2626, #991b1b);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 40px;
        box-shadow: 0 10px 30px rgba(220, 38, 38, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .logo-section h1 {
        color: #1e293b;
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .logo-section p {
        color: #64748b;
        font-size: 14px;
    }

    .form-group { margin-bottom: 20px; }

    .form-label {
        display: block;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #1e293b;
    }

    .form-input:focus {
        outline: none;
        border-color: #dc2626;
        background: white;
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
    }

    .form-input.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: block;
        font-weight: 500;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-size: 13px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        cursor: pointer;
        font-weight: 500;
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #dc2626;
        cursor: pointer;
    }

    .forgot-password {
        color: #dc2626;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .forgot-password:hover {
        color: #991b1b;
        text-decoration: underline;
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #dc2626, #991b1b);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    }

    .register-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 14px;
    }

    .register-link a {
        color: #dc2626;
        text-decoration: none;
        font-weight: 700;
        margin-left: 5px;
        transition: color 0.3s;
    }

    .register-link a:hover { 
        color: #991b1b;
        text-decoration: underline; 
    }

    [dir="rtl"] .lang-switcher { right: auto; left: 20px; }
    [dir="rtl"] .register-link a { margin-left: 0; margin-right: 5px; }

    @media (max-width: 480px) {
        .login-card { padding: 32px 24px; }
        .lang-switcher { top: 10px; right: 10px; }
        [dir="rtl"] .lang-switcher { left: 10px; }
    }
</style>

<div class="login-page">
    <div class="lang-switcher">
        <a href="{{ url('/language/fr') }}" class="lang-btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">FR 🇫🇷</a>
        <a href="{{ url('/language/ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR 🇸🇦</a>
    </div>

    <div class="login-card">
        <div class="logo-section">
            <div class="blood-icon">🩸</div>
            <h1>{{ app()->getLocale() == 'ar' ? 'نظام التبرع بالدم' : 'Système de Don de Sang' }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'سجل الدخول إلى حسابك' : 'Connectez-vous à votre compte' }}</p>
        </div>

        <form method="POST" action="{{ route('login.submit') }}" id="loginForm" novalidate>
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">
                    {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Adresse Email' }}
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input @error('email') error @enderror"
                    value="{{ old('email') }}"
                    placeholder="exemple@email.com"
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    {{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Mot de Passe' }}
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input @error('password') error @enderror"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    {{ app()->getLocale() == 'ar' ? 'تذكرني' : 'Se souvenir de moi' }}
                </label>
                <a href="#" class="forgot-password">
                    {{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور؟' : 'Mot de passe oublié ?' }}
                </a>
            </div>

            <button type="submit" class="btn-login">
                {{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Connexion' }}
            </button>

            <div class="register-link">
                {{ app()->getLocale() == 'ar' ? 'ليس لديك حساب؟' : "Pas encore de compte ?" }}
                <a href="{{ route('register') }}">
                    {{ app()->getLocale() == 'ar' ? 'إنشاء حساب' : "S'inscrire" }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection