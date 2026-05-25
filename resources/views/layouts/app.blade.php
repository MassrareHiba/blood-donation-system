<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ar' ? 'ar' : 'fr' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blood Donation System')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-light: #f5f7fa;
            --bg-card: #ffffff;
            --sidebar-bg: #1e293b;
            --sidebar-text: #cbd5e1;
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --primary-light: #fef2f2;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #475569;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 4px 20px rgba(0,0,0,0.05);
            --shadow-card: 0 8px 30px rgba(0,0,0,0.08);
            --gradient: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
        }

        .dashboard-wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(220,38,38,0.3);
        }

        .sidebar-title h3 {
            font-size: 18px;
            font-weight: 700;
            color: white;
        }

        .sidebar-title p {
            font-size: 12px;
            color: #94a3b8;
        }

        .sidebar-menu {
            padding: 20px 12px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin: 4px 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .menu-item:hover,
        .menu-item.active {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(220,38,38,0.3);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #334155;
            margin-top: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .logout-btn {
            width: 100%;
            padding: 10px;
            background: rgba(220,38,38,0.1);
            border: 1px solid rgba(220,38,38,0.3);
            border-radius: 30px;
            color: #ef4444;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: rgba(220,38,38,0.2);
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 32px;
            background: var(--bg-light);
            min-height: 100vh;
        }

        .main-content-full {
            flex: 1;
            width: 100%;
            min-height: 100vh;
        }

        [dir="rtl"] .sidebar {
            right: 0;
            left: auto;
        }

        [dir="rtl"] .main-content {
            margin-left: 0;
            margin-right: 280px;
        }

        [dir="rtl"] .menu-item {
            flex-direction: row-reverse;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 14px 24px;
            border-radius: 16px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
            font-weight: 500;
        }

        .alert-success {
            background: var(--success);
            color: white;
        }

        .alert-danger {
            background: var(--danger);
            color: white;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        [dir="rtl"] .alert {
            right: auto;
            left: 20px;
            animation: slideInRTL 0.3s ease;
        }

        @keyframes slideInRTL {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
            [dir="rtl"] .main-content {
                margin-right: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    {{-- CACHER SIDEBAR sur login, register, password reset --}}
    @if(!Request::is('login') && !Request::is('register') && !Request::is('password/*') && !Request::is('forgot-password'))
        <div class="dashboard-wrapper">
            <aside class="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-logo">🩸</div>
                    <div class="sidebar-title">
                        <h3>BloodBank</h3>
                        <p>@if(app()->getLocale() == 'ar') بوابة المتبرع @else Portail Donneur @endif</p>
                    </div>
                </div>

                <nav class="sidebar-menu">
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            👑 @if(app()->getLocale() == 'ar') لوحة تحكم المدير @else Tableau de bord Admin @endif
                        </a>
                        <a href="{{ route('admin.donors') }}" class="menu-item {{ request()->routeIs('admin.donors') ? 'active' : '' }}">
                            🩸 @if(app()->getLocale() == 'ar') المتبرعين @else Donneurs @endif
                        </a>
                        <a href="{{ route('admin.appointments') }}" class="menu-item {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
                            📅 @if(app()->getLocale() == 'ar') المواعيد @else Rendez-vous @endif
                        </a>
                        <a href="{{ route('admin.blood-stock') }}" class="menu-item {{ request()->routeIs('admin.blood-stock') ? 'active' : '' }}">
                            💉 @if(app()->getLocale() == 'ar') مخزون الدم @else Stock de sang @endif
                        </a>
                        <a href="{{ route('reports.index') }}" class="menu-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                            📊 @if(app()->getLocale() == 'ar') التقارير @else Rapports @endif
                        </a>
                        <a href="{{ route('charts.index') }}" class="menu-item {{ request()->routeIs('charts.index') ? 'active' : '' }}">
                            📈 @if(app()->getLocale() == 'ar') الرسوم البيانية @else Graphiques @endif
                        </a>
                    @else
                        <a href="{{ route('donor.dashboard') }}" class="menu-item {{ request()->routeIs('donor.dashboard') ? 'active' : '' }}">
                            📊 @if(app()->getLocale() == 'ar') لوحة التحكم @else Tableau de bord @endif
                        </a>
                        <a href="{{ route('donor.search') }}" class="menu-item {{ request()->routeIs('donor.search') ? 'active' : '' }}">
                            🔍 @if(app()->getLocale() == 'ar') البحث عن الدم @else Rechercher du sang @endif
                        </a>
                        <a href="{{ route('donor.appointments') }}" class="menu-item {{ request()->routeIs('donor.appointments') ? 'active' : '' }}">
                            📅 @if(app()->getLocale() == 'ar') مواعيدي @else Mes rendez-vous @endif
                        </a>
                        <a href="{{ route('donor.history') }}" class="menu-item {{ request()->routeIs('donor.history') ? 'active' : '' }}">
                            📜 @if(app()->getLocale() == 'ar') تاريخ التبرعات @else Historique des dons @endif
                        </a>
                        <a href="{{ route('donor.settings') }}" class="menu-item {{ request()->routeIs('donor.settings') ? 'active' : '' }}">
                            ⚙️ @if(app()->getLocale() == 'ar') الإعدادات @else Paramètres @endif
                        </a>
                    @endif
                </nav>

                <div class="sidebar-footer">
                    <div class="user-info">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <div>
                            <h4>{{ auth()->user()->name }}</h4>
                            <span style="font-size:12px; color:#94a3b8;">{{ auth()->user()->email }}</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                        <a href="{{ url('/language/fr') }}" style="flex:1; text-align:center; padding:6px; background: {{ app()->getLocale() == 'fr' ? '#dc2626' : 'rgba(255,255,255,0.1)' }}; color:white; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600;">
                            🇫🇷 FR
                        </a>
                        <a href="{{ url('/language/ar') }}" style="flex:1; text-align:center; padding:6px; background: {{ app()->getLocale() == 'ar' ? '#dc2626' : 'rgba(255,255,255,0.1)' }}; color:white; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600;">
                            🇸🇦 AR
                        </a>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            🚪 @if(app()->getLocale() == 'ar') تسجيل الخروج @else Se déconnecter @endif
                        </button>
                    </form>
                </div>
            </aside>

            <main class="main-content">
                @yield('content')
            </main>
        </div>
    @else
        {{-- PAS DE SIDEBAR sur login/register --}}
        <main class="main-content-full">
            @yield('content')
        </main>
    @endif

    <script>setTimeout(()=>{document.querySelectorAll('.alert').forEach(a=>a.remove());},4000);</script>
    @stack('scripts')
</body>
</html>