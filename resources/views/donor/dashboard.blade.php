@extends('layouts.app')

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .dashboard-card {
        background: white;
        border-radius: 20px;
        padding: 28px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .dashboard-card .icon {
        font-size: 48px;
        margin-bottom: 16px;
    }
    
    .dashboard-card .value {
        font-size: 32px;
        font-weight: 800;
        color: #dc2626;
        margin-bottom: 8px;
    }
    
    .dashboard-card .label {
        color: #64748b;
        font-size: 14px;
    }
    
    .profile-card {
        background: white;
        border-radius: 20px;
        margin-bottom: 32px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .profile-header {
        padding: 20px 28px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .profile-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        padding: 28px;
    }
    
    .profile-item label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
        display: block;
    }
    
    .profile-item p {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .btn-edit {
        background: #dc2626;
        padding: 8px 20px;
        border-radius: 30px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-edit:hover {
        background: #991b1b;
        transform: translateY(-2px);
    }
    
    .history-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .history-card .card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        font-weight: 700;
        font-size: 18px;
    }
    
    .history-table {
        width: 100%;
    }
    
    .history-table th {
        padding: 16px 20px;
        text-align: left;
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #f8fafc;
    }
    
    .history-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
    }
    
    .blood-badge {
        background: #fef2f2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .lang-switch {
        padding: 8px 20px;
        border-radius: 30px;
        border: 2px solid #dc2626;
        background: white;
        color: #dc2626;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
    }
    
    .lang-switch:hover {
        background: #dc2626;
        color: white;
    }
    
    .lang-switch.active {
        background: #dc2626;
        color: white;
    }
</style>

<div style="margin-bottom: 24px; display: flex; justify-content: flex-end; gap: 12px;">
    <a href="{{ url('/language/fr') }}" class="lang-switch {{ app()->getLocale() == 'fr' ? 'active' : '' }}">🇫🇷 FR</a>
    <a href="{{ url('/language/ar') }}" class="lang-switch {{ app()->getLocale() == 'ar' ? 'active' : '' }}">🇸🇦 AR</a>
</div>

<h1 style="font-size: 32px; font-weight: 800; margin-bottom: 8px; color: #1e293b;">
    {{ app()->getLocale() == 'ar' ? 'لوحة التحكم' : 'Tableau de bord' }}
</h1>
<p style="color: #64748b; margin-bottom: 32px;">{{ app()->getLocale() == 'ar' ? 'مرحباً بعودتك!' : 'Bon retour !' }}</p>

@php
    $donor = auth()->user()->donor;
    $totalAppointments = $donor->appointments->count();
    $pendingAppointments = $donor->appointments->where('status', 'pending')->count();
    $completedAppointments = $donor->appointments->where('status', 'completed')->count();
    $bloodType = $donor->blood_type ?? 'N/A';
    $isAvailable = $donor->is_available;
@endphp

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="icon">🩸</div>
        <div class="value">{{ $bloodType }}</div>
        <div class="label">{{ app()->getLocale() == 'ar' ? 'فصيلة دمك' : 'Votre groupe sanguin' }}</div>
    </div>
    <div class="dashboard-card">
        <div class="icon">📅</div>
        <div class="value">{{ $totalAppointments }}</div>
        <div class="label">{{ app()->getLocale() == 'ar' ? 'إجمالي المواعيد' : 'Total rendez-vous' }}</div>
    </div>
    <div class="dashboard-card">
        <div class="icon">✅</div>
        <div class="value">{{ $isAvailable ? (app()->getLocale() == 'ar' ? 'نعم' : 'Oui') : (app()->getLocale() == 'ar' ? 'لا' : 'Non') }}</div>
        <div class="label">{{ app()->getLocale() == 'ar' ? 'مؤهل للتبرع' : 'Éligible à donner' }}</div>
    </div>
</div>

<div class="profile-card">
    <div class="profile-header">
        <h3>👤 {{ app()->getLocale() == 'ar' ? 'ملفك الشخصي' : 'Votre profil' }}</h3>
        <a href="{{ route('donor.profile.edit') }}" class="btn-edit">✏️ {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Modifier' }}</a>
    </div>
    <div class="profile-grid">
        <div class="profile-item">
            <label>{{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Nom complet' }}</label>
            <p>{{ auth()->user()->name }}</p>
        </div>
        <div class="profile-item">
            <label>Email</label>
            <p>{{ auth()->user()->email }}</p>
        </div>
        <div class="profile-item">
            <label>{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Téléphone' }}</label>
            <p>{{ $donor->phone ?? 'N/A' }}</p>
        </div>
        <div class="profile-item">
            <label>{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</label>
            <p>{{ $donor->city ?? 'N/A' }}</p>
        </div>
        <div class="profile-item">
            <label>{{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Date de naissance' }}</label>
            <p>{{ $donor->date_of_birth ? $donor->date_of_birth->format('d/m/Y') : 'N/A' }}</p>
        </div>
        <div class="profile-item">
            <label>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</label>
            <p>
                @if($isAvailable)
                    <span style="background: #d1fae5; color: #059669; padding: 4px 12px; border-radius: 20px; font-size: 12px;">✓ {{ app()->getLocale() == 'ar' ? 'متاح للتبرع' : 'Éligible pour donner' }}</span>
                @else
                    <span style="background: #fee2e2; color: #dc2626; padding: 4px 12px; border-radius: 20px; font-size: 12px;">✗ {{ app()->getLocale() == 'ar' ? 'غير متاح حالياً' : 'Non disponible actuellement' }}</span>
                @endif
            </p>
        </div>
    </div>
</div>

<div class="history-card">
    <div class="card-header">
        📜 {{ app()->getLocale() == 'ar' ? 'آخر التبرعات' : 'Derniers dons' }}
    </div>
    @php
        $history = $donor->appointments()->where('status', 'completed')->orderBy('appointment_date', 'desc')->take(5)->get();
    @endphp
    
    @if($history->count() > 0)
        <table class="history-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم' : 'Groupe' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $index => $donation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $donation->appointment_date->format('d/m/Y') }}</td>
                    <td><span class="blood-badge">🩸 {{ $donation->blood_type_donated ?? $donor->blood_type }}</span></td>
                    <td><span style="color: #059669;">✓ {{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 60px; color: #94a3b8;">
            <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
            <p>{{ app()->getLocale() == 'ar' ? 'لا توجد تبرعات مسجلة' : 'Aucun don enregistré' }}</p>
            <a href="{{ route('donor.appointments.create') }}" style="display: inline-block; margin-top: 15px; background: #dc2626; color: white; padding: 10px 20px; border-radius: 30px; text-decoration: none;">➕ {{ app()->getLocale() == 'ar' ? 'موعد جديد' : 'Nouveau rendez-vous' }}</a>
        </div>
    @endif
</div>
@endsection