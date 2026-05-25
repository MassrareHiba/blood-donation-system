@extends('layouts.app')

@section('content')
<style>
    .results-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .results-header {
        margin-bottom: 30px;
    }
    
    .results-header h1 {
        color: #dc2626;
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .filter-info {
        background: #f8fafc;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .filter-tag {
        background: white;
        padding: 6px 15px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
    }
    
    .filter-tag strong {
        color: #dc2626;
    }
    
    .results-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .results-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .results-table th {
        background: #f8fafc;
        padding: 15px 20px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .results-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .blood-badge {
        background: #fef2f2;
        color: #dc2626;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }
    
    .status-available {
        background: #d1fae5;
        color: #059669;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-block;
    }
    
    .status-unavailable {
        background: #fee2e2;
        color: #dc2626;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-block;
    }
    
    .compatible-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 15px 20px;
        margin-top: 20px;
    }
    
    .compatible-types {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .compatible-type {
        background: #dc2626;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    
    .btn-back {
        display: inline-block;
        background: #64748b;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        margin-top: 20px;
    }
    
    .btn-back:hover {
        background: #475569;
    }
    
    .lang-switch {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .lang-btn {
        padding: 6px 14px;
        border-radius: 20px;
        border: 2px solid #dc2626;
        background: white;
        color: #dc2626;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }
    
    .lang-btn.active {
        background: #dc2626;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px;
        color: #94a3b8;
    }
    
    .empty-state .icon {
        font-size: 64px;
        margin-bottom: 16px;
    }
</style>

<div class="results-container">
    <div class="lang-switch">
        <a href="{{ url('/language/fr') }}" class="lang-btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">FR</a>
        <a href="{{ url('/language/ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
    </div>

    <div class="results-header">
        <h1>🔍 {{ app()->getLocale() == 'ar' ? 'نتائج البحث' : 'Résultats de recherche' }}</h1>
        <p>{{ app()->getLocale() == 'ar' ? 'نتائج البحث عن متبرعين متوافقين' : 'Résultats de la recherche de donneurs compatibles' }}</p>
    </div>

    <!-- Filter Info -->
    <div class="filter-info">
        <div class="filter-tag">
            <strong>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم:' : 'Groupe sanguin:' }}</strong> {{ $bloodType ?? '-' }}
        </div>
        @if($city)
        <div class="filter-tag">
            <strong>{{ app()->getLocale() == 'ar' ? 'المدينة:' : 'Ville:' }}</strong> {{ $city }}
        </div>
        @endif
        <div class="filter-tag">
            <strong>{{ app()->getLocale() == 'ar' ? 'نوع البحث:' : 'Type de recherche:' }}</strong> 
            {{ $searchType == 'donors' ? (app()->getLocale() == 'ar' ? 'المتبرعين' : 'Donneurs') : (app()->getLocale() == 'ar' ? 'بنك الدم' : 'Banque de sang') }}
        </div>
    </div>

    <!-- Compatible Types Info -->
    @if(isset($compatibleTypes) && $compatibleTypes && $searchType == 'donors')
    <div class="compatible-box">
        <strong>🩸 {{ app()->getLocale() == 'ar' ? 'فصائل الدم المتوافقة مع' : 'Groupes sanguins compatibles avec' }} {{ $bloodType }}:</strong>
        <div class="compatible-types">
            @foreach($compatibleTypes as $type)
                <span class="compatible-type">{{ $type }}</span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Results -->
    <div class="results-card">
        @if(count($results) > 0)
            <table class="results-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Nom' }}</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم' : 'Groupe sanguin' }}</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Téléphone' }}</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $donor)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $donor->user->name }}</strong></td>
                        <td><span class="blood-badge">🩸 {{ $donor->blood_type }}</span></td>
                        <td>{{ $donor->city ?? '-' }}</td>
                        <td>{{ $donor->phone ?? '-' }}</td>
                        <td>
                            @if($donor->is_available)
                                <span class="status-available">✓ {{ app()->getLocale() == 'ar' ? 'متاح' : 'Disponible' }}</span>
                            @else
                                <span class="status-unavailable">✗ {{ app()->getLocale() == 'ar' ? 'غير متاح' : 'Indisponible' }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="icon">🔍</div>
                <h3>{{ app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'Aucun résultat' }}</h3>
                <p>{{ app()->getLocale() == 'ar' ? 'لم يتم العثور على متبرعين متوافقين مع معايير البحث الخاصة بك' : 'Aucun donneur compatible trouvé avec vos critères de recherche' }}</p>
            </div>
        @endif
    </div>

    <a href="{{ route('donor.search') }}" class="btn-back">
        ← {{ app()->getLocale() == 'ar' ? 'العودة إلى البحث' : 'Retour à la recherche' }}
    </a>
</div>
@endsection