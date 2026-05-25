@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
        <h1 style="font-size:28px; font-weight:800;">📅 {{ app()->getLocale() == 'ar' ? 'مواعيدي' : 'Mes rendez-vous' }}</h1>
        <p style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'إدارة مواعيد التبرع بالدم' : 'Gérez vos rendez-vous de don de sang' }}</p>
    </div>
    <div>
        <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
        <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
    </div>
</div>

@php
    $appointments = auth()->user()->donor->appointments()->orderBy('appointment_date', 'desc')->get();
    $pendingCount = $appointments->where('status', 'pending')->count();
    $confirmedCount = $appointments->where('status', 'confirmed')->count();
    $completedCount = $appointments->where('status', 'completed')->count();
@endphp

<!-- Stats -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:30px;">
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:32px; font-weight:800;">{{ $appointments->count() }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'الكل' : 'Total' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:32px; font-weight:800; color:#f59e0b;">{{ $pendingCount }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:32px; font-weight:800; color:#3b82f6;">{{ $confirmedCount }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:32px; font-weight:800; color:#10b981;">{{ $completedCount }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé' }}</div>
    </div>
</div>

<!-- Appointments Table -->
<div style="background:white; border-radius:16px; overflow:auto;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <th style="padding:15px 20px;">#</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'الوقت' : 'Heure' }}</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'الإجراء' : 'Action' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $index => $appointment)
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:15px 20px;">{{ $index + 1 }}</td>
                <td style="padding:15px 20px;">{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                <td style="padding:15px 20px;">{{ $appointment->appointment_date->format('H:i') }}</td>
                <td style="padding:15px 20px;">
                    @if($appointment->status == 'pending')
                        <span style="background:#fef3c7; color:#d97706; padding:4px 12px; border-radius:20px;">⏳ {{ app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente' }}</span>
                    @elseif($appointment->status == 'confirmed')
                        <span style="background:#dbeafe; color:#2563eb; padding:4px 12px; border-radius:20px;">✓ {{ app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé' }}</span>
                    @elseif($appointment->status == 'completed')
                        <span style="background:#d1fae5; color:#059669; padding:4px 12px; border-radius:20px;">✅ {{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé' }}</span>
                    @else
                        <span style="background:#fee2e2; color:#dc2626; padding:4px 12px; border-radius:20px;">✗ {{ app()->getLocale() == 'ar' ? 'ملغى' : 'Annulé' }}</span>
                    @endif
                </td>
                <td style="padding:15px 20px;">
                    @if($appointment->status == 'pending')
                        <form action="{{ route('donor.appointments.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد؟' : 'Êtes-vous sûr ?' }}')">
                            @csrf
                            <button type="submit" style="background:#fee2e2; color:#dc2626; border:none; padding:6px 12px; border-radius:8px; cursor:pointer;">✗ {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Annuler' }}</button>
                        </form>
                    @else
                        <span style="color:#94a3b8;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:60px; color:#94a3b8;">
                    <div style="font-size:48px;">📅</div>
                    <p>{{ app()->getLocale() == 'ar' ? 'لا توجد مواعيد' : 'Aucun rendez-vous' }}</p>
                    <a href="{{ route('donor.appointments.create') }}" style="display:inline-block; margin-top:15px; background:#dc2626; color:white; padding:10px 20px; border-radius:8px; text-decoration:none;">➕ {{ app()->getLocale() == 'ar' ? 'موعد جديد' : 'Nouveau RDV' }}</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection