@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <h1 style="font-size:28px; font-weight:800;">💉 {{ app()->getLocale() == 'ar' ? 'مخزون الدم' : 'Stock de sang' }}</h1>
    <div>
        <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
        <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:30px;">
    @foreach($stocks as $stock)
    <div style="background:white; border-radius:16px; padding:20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <div style="font-size:36px; font-weight:800; color:#dc2626;">{{ $stock->blood_type }}</div>
        <div style="font-size:48px; font-weight:800; margin:15px 0;">{{ $stock->units_available }}</div>
        <div style="color:#64748b;">{{ app()->getLocale() == 'ar' ? 'وحدة متاحة' : 'unités disponibles' }}</div>
        
        <form action="{{ route('admin.update-blood-stock', $stock->id) }}" method="POST" style="margin-top:15px;">
            @csrf
            <div style="display:flex; gap:10px;">
                <input type="number" name="units_available" value="{{ $stock->units_available }}" style="flex:1; padding:8px; border:1px solid #ddd; border-radius:8px;">
                <button type="submit" style="background:#dc2626; color:white; border:none; padding:8px 15px; border-radius:8px; cursor:pointer;">{{ app()->getLocale() == 'ar' ? 'تحديث' : 'Mettre à jour' }}</button>
            </div>
        </form>
    </div>
    @endforeach
</div>

<!-- Stock Level Indicator -->
<div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom:20px;">📊 {{ app()->getLocale() == 'ar' ? 'مستوى المخزون' : 'Niveau du stock' }}</h3>
    @foreach($stocks as $stock)
    <div style="margin-bottom:15px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
            <span style="font-weight:600;">{{ $stock->blood_type }}</span>
            <span>{{ $stock->units_available }} {{ app()->getLocale() == 'ar' ? 'وحدة' : 'unités' }}</span>
        </div>
        <div style="width:100%; height:10px; background:#e2e8f0; border-radius:5px; overflow:hidden;">
            <div style="width:{{ min(100, $stock->units_available) }}%; height:100%; background:{{ $stock->units_available < 10 ? '#dc2626' : ($stock->units_available < 30 ? '#f59e0b' : '#10b981') }}; border-radius:5px;"></div>
        </div>
    </div>
    @endforeach
</div>
@endsection