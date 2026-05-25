@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
        <div>
            <h1 style="font-size:28px; font-weight:800;">⚙️ {{ app()->getLocale() == 'ar' ? 'الإعدادات' : 'Paramètres' }}</h1>
            <p style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'إدارة إعدادات حسابك' : 'Gérez les paramètres de votre compte' }}</p>
        </div>
        <div>
            <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
            <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#d1fae5; color:#059669; padding:12px; border-radius:8px; margin-bottom:20px;">✓ {{ session('success') }}</div>
    @endif

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:25px;">
        <!-- Profile Settings -->
        <div style="background:white; border-radius:16px; padding:25px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom:20px;">👤 {{ app()->getLocale() == 'ar' ? 'معلومات شخصية' : 'Informations personnelles' }}</h3>
            <form action="{{ route('donor.profile.update') }}" method="POST">
                @csrf
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Nom' }}</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px; background:#f1f5f9;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px; background:#f1f5f9;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Téléphone' }}</label>
                    <input type="text" name="phone" value="{{ auth()->user()->donor->phone ?? '' }}" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</label>
                    <input type="text" name="city" value="{{ auth()->user()->donor->city ?? '' }}" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Date de naissance' }}</label>
                    <input type="date" name="date_of_birth" value="{{ auth()->user()->donor->date_of_birth ? auth()->user()->donor->date_of_birth->format('Y-m-d') : '' }}" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Adresse' }}</label>
                    <input type="text" name="address" value="{{ auth()->user()->donor->address ?? '' }}" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                </div>
                <button type="submit" style="background:#dc2626; color:white; border:none; padding:12px 20px; border-radius:8px; cursor:pointer; width:100%;">{{ app()->getLocale() == 'ar' ? 'حفظ التغييرات' : 'Enregistrer' }}</button>
            </form>
        </div>

        <!-- Language Settings -->
        <div style="background:white; border-radius:16px; padding:25px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom:20px;">🌐 {{ app()->getLocale() == 'ar' ? 'اللغة' : 'Langue' }}</h3>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'اختر لغتك' : 'Choisissez votre langue' }}</label>
                <select onchange="window.location.href = '/language/' + this.value" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
                    <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
                </select>
            </div>
            <div style="margin-top:20px; padding-top:20px; border-top:1px solid #e2e8f0;">
                <p style="font-size:13px; color:#64748b;">{{ app()->getLocale() == 'ar' ? 'يمكنك تغيير اللغة في أي وقت من القائمة الجانبية أو من هنا.' : 'Vous pouvez changer la langue à tout moment depuis le menu latéral ou ici.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection