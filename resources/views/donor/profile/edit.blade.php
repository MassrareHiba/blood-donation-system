@extends('layouts.app')

@section('content')
<style>
    .edit-container { max-width: 600px; margin: 0 auto; padding: 20px; }
    .edit-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50; }
    .form-group input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; }
    .btn-save { background: #e74c3c; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; }
    .btn-cancel { margin-left: 10px; color: #666; text-decoration: none; }
    .page-title { margin-bottom: 20px; }
</style>

<div class="edit-container">
    @if(app()->getLocale() == 'ar')
        <h1 class="page-title">✏️ تعديل الملف الشخصي</h1>
    @else
        <h1 class="page-title">✏️ Modifier le Profil</h1>
    @endif
    
    <div class="edit-card">
        <form action="{{ route('donor.profile.update') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Nom' }}</label>
                <input type="text" value="{{ auth()->user()->name }}" disabled style="background: #f5f5f5;">
            </div>
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }}</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled style="background: #f5f5f5;">
            </div>
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Téléphone' }}</label>
                <input type="text" name="phone" value="{{ old('phone', $donor->phone) }}">
            </div>
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</label>
                <input type="text" name="city" value="{{ old('city', $donor->city) }}">
            </div>
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Date de Naissance' }}</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $donor->date_of_birth ? $donor->date_of_birth->format('Y-m-d') : '') }}">
            </div>
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Adresse' }}</label>
                <input type="text" name="address" value="{{ old('address', $donor->address ?? '') }}">
            </div>
            
            <button type="submit" class="btn-save">{{ app()->getLocale() == 'ar' ? 'حفظ' : 'Enregistrer' }}</button>
            <a href="{{ route('donor.dashboard') }}" class="btn-cancel">{{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Annuler' }}</a>
        </form>
    </div>
</div>
@endsection