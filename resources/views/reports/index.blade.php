@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <h1 style="font-size:28px; font-weight:800;">📊 {{ app()->getLocale() == 'ar' ? 'التقارير' : 'Rapports' }}</h1>
    <div>
        <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
        <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:30px;">
    <div style="background:white; border-radius:16px; padding:20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:40px;">🩸</div>
        <div style="font-size:32px; font-weight:800; color:#dc2626;">{{ $stats['total_donors'] }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'إجمالي المتبرعين' : 'Total donneurs' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:40px;">📅</div>
        <div style="font-size:32px; font-weight:800; color:#dc2626;">{{ $stats['total_appointments'] }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'إجمالي المواعيد' : 'Total rendez-vous' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:40px;">💉</div>
        <div style="font-size:32px; font-weight:800; color:#dc2626;">{{ $stats['total_blood_units'] }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'وحدات الدم' : 'Unités de sang' }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:40px;">📈</div>
        <div style="font-size:32px; font-weight:800; color:#10b981;">{{ $stats['total_donors'] + $stats['total_appointments'] }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'إجمالي العمليات' : 'Total opérations' }}</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:20px;">
    <div style="background:white; border-radius:16px; padding:25px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:50px;">🩸</div>
        <h3 style="margin:10px 0;">{{ app()->getLocale() == 'ar' ? 'تقرير المتبرعين' : 'Rapport des donneurs' }}</h3>
        <a href="{{ route('reports.donors') }}" style="display:inline-block; background:#dc2626; color:white; padding:10px 25px; border-radius:8px; text-decoration:none;">📄 {{ app()->getLocale() == 'ar' ? 'تحميل PDF' : 'Télécharger PDF' }}</a>
    </div>
    <div style="background:white; border-radius:16px; padding:25px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:50px;">💉</div>
        <h3 style="margin:10px 0;">{{ app()->getLocale() == 'ar' ? 'تقرير مخزون الدم' : 'Rapport du stock de sang' }}</h3>
        <a href="{{ route('reports.blood-stock') }}" style="display:inline-block; background:#dc2626; color:white; padding:10px 25px; border-radius:8px; text-decoration:none;">📄 {{ app()->getLocale() == 'ar' ? 'تحميل PDF' : 'Télécharger PDF' }}</a>
    </div>
    <div style="background:white; border-radius:16px; padding:25px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:50px;">📅</div>
        <h3 style="margin:10px 0;">{{ app()->getLocale() == 'ar' ? 'تقرير المواعيد' : 'Rapport des rendez-vous' }}</h3>
        <a href="{{ route('reports.appointments') }}" style="display:inline-block; background:#dc2626; color:white; padding:10px 25px; border-radius:8px; text-decoration:none;">📄 {{ app()->getLocale() == 'ar' ? 'تحميل PDF' : 'Télécharger PDF' }}</a>
    </div>
    <div style="background:white; border-radius:16px; padding:25px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:50px;">📊</div>
        <h3 style="margin:10px 0;">{{ app()->getLocale() == 'ar' ? 'الرسوم البيانية' : 'Graphiques' }}</h3>
        <a href="{{ route('charts.index') }}" style="display:inline-block; background:#10b981; color:white; padding:10px 25px; border-radius:8px; text-decoration:none;">📈 {{ app()->getLocale() == 'ar' ? 'عرض' : 'Voir' }}</a>
    </div>
</div>
@endsection