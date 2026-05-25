@extends('layouts.app')

@section('content')
<div style="max-width:600px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
        <h1 style="font-size:28px; font-weight:800;">➕ {{ app()->getLocale() == 'ar' ? 'موعد جديد' : 'Nouveau rendez-vous' }}</h1>
        <div>
            <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
            <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
        </div>
    </div>

    <div style="background:white; border-radius:16px; padding:30px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('donor.appointments.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'التاريخ *' : 'Date *' }}</label>
                <input type="date" name="appointment_date" required style="width:100%; padding:12px; border:2px solid #e2e8f0; border-radius:8px;" min="{{ date('Y-m-d') }}">
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'الوقت *' : 'Heure *' }}</label>
                <input type="time" name="appointment_time" required style="width:100%; padding:12px; border:2px solid #e2e8f0; border-radius:8px;">
            </div>
            
            <div style="margin-bottom:25px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">{{ app()->getLocale() == 'ar' ? 'ملاحظات' : 'Notes' }}</label>
                <textarea name="notes" rows="4" style="width:100%; padding:12px; border:2px solid #e2e8f0; border-radius:8px;"></textarea>
            </div>
            
            <button type="submit" style="width:100%; background:#dc2626; color:white; border:none; padding:14px; border-radius:8px; font-size:16px; font-weight:600; cursor:pointer;">{{ app()->getLocale() == 'ar' ? 'تأكيد الموعد' : 'Confirmer le rendez-vous' }}</button>
            
            <a href="{{ route('donor.appointments') }}" style="display:block; text-align:center; margin-top:15px; color:#64748b; text-decoration:none;">{{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Annuler' }}</a>
        </form>
    </div>
</div>
@endsection