<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ app()->getLocale() == 'ar' ? 'التسجيل' : 'Inscription' }} - Blood Donation System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            min-height: 100vh;
        }
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 520px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc2626, #991b1b);
        }
        .auth-header { text-align: center; margin-bottom: 32px; }
        .blood-drop {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dc2626, #991b1b);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
        }
        .auth-header h1 { font-size: 28px; font-weight: 800; color: #1f2937; }
        .auth-header p { color: #6b7280; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220,38,38,0.1);
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #dc2626, #991b1b);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220,38,38,0.4);
        }
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }
        .auth-footer a {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
        }
        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }
        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="blood-drop">🩸</div>
                <h1>{{ app()->getLocale() == 'ar' ? 'إنشاء حساب جديد' : 'Créer un compte' }}</h1>
                <p>{{ app()->getLocale() == 'ar' ? 'سجل كمتبرع بالدم' : 'Inscrivez-vous comme donneur de sang' }}</p>
            </div>

            @if($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Nom complet' }}</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Mot de passe' }}</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirmer mot de passe' }}</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Téléphone' }}</label>
                        <input type="tel" name="phone" class="form-input" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'فصيلة الدم' : 'Groupe sanguin' }}</label>
                        <select name="blood_type" class="form-select">
                            <option value="">{{ app()->getLocale() == 'ar' ? 'اختر' : 'Sélectionner' }}</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</label>
                    <input type="text" name="city" class="form-input" value="{{ old('city') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'التاريخ الطبي (اختياري)' : 'Historique médical (optionnel)' }}</label>
                    <textarea name="medical_history" class="form-textarea" rows="3">{{ old('medical_history') }}</textarea>
                </div>

                <button type="submit" class="btn-primary">
                    {{ app()->getLocale() == 'ar' ? 'تسجيل كمتبرع' : "S'inscrire comme donneur" }}
                </button>
            </form>

            <div class="auth-footer">
                <p>
                    {{ app()->getLocale() == 'ar' ? 'لديك حساب بالفعل؟' : 'Déjà un compte ?' }}
                    <a href="{{ route('login') }}">{{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Se connecter' }}</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>