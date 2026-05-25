@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
        <h1 style="font-size:28px; font-weight:800;">📜 {{ app()->getLocale() == 'ar' ? 'تاريخ التبرعات' : 'Historique des dons' }}</h1>
        <p style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'جميع تبرعاتك السابقة' : 'Tous vos dons antérieurs' }}</p>
    </div>
    <div>
        <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
        <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
    </div>
</div>

@php
    $history = auth()->user()->donor->appointments()->where('status', 'completed')->orderBy('appointment_date', 'desc')->get();
    $totalDonations = $history->count();
    $totalUnits = $history->sum('units_donated') ?? $totalDonations;
    $lastDonation = $history->first();
@endphp

<!-- Stats -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:30px;">
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:32px; font-weight:800; color:#dc2626;">{{ $totalDonations }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'عدد التبرعات' : 'Nombre de dons' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:32px; font-weight:800; color:#dc2626;">{{ $totalUnits }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'وحدات الدم' : 'Unités de sang' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center;">
        <div style="font-size:16px; font-weight:800; color:#dc2626;">{{ $lastDonation ? $lastDonation->appointment_date->format('d/m/Y') : 'N/A' }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'آخر تبرع' : 'Dernier don' }}</div>
    </div>
</div>

<!-- History Table -->
<div style="background:white; border-radius:16px; overflow:auto;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f8fafc;">
                <th style="padding:15px 20px;">#</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'فصيلة الدم' : 'Groupe' }}</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'الوحدات' : 'Unités' }}</th>
                <th style="padding:15px 20px;">{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $index => $donation)
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:15px 20px;">{{ $index + 1 }}</td>
                <td style="padding:15px 20px;">{{ $donation->appointment_date->format('d/m/Y') }}</td>
                <td style="padding:15px 20px;"><span style="background:#fef2f2; color:#dc2626; padding:5px 12px; border-radius:20px;">{{ $donation->blood_type_donated ?? auth()->user()->donor->blood_type }}</span></td>
                <td style="padding:15px 20px;">{{ $donation->units_donated ?? '1' }}</td>
                <td style="padding:15px 20px;"><span style="background:#d1fae5; color:#059669; padding:4px 12px; border-radius:20px;">✓ {{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé' }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:60px; color:#94a3b8;">
                    <div style="font-size:48px;">📋</div>
                    <p>{{ app()->getLocale() == 'ar' ? 'لا توجد تبرعات مسجلة' : 'Aucun don enregistré' }}</p>
                    <a href="{{ route('donor.appointments.create') }}" style="display:inline-block; margin-top:15px; background:#dc2626; color:white; padding:10px 20px; border-radius:8px; text-decoration:none;">➕ {{ app()->getLocale() == 'ar' ? 'موعد جديد' : 'Nouveau RDV' }}</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection