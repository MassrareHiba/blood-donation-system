@extends('layouts.app')

@section('content')
<style>
    .search-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .search-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .search-header h1 {
        color: #dc2626;
        font-size: 32px;
        margin-bottom: 10px;
    }
    
    .search-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }
    
    .form-group select, .form-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
    }
    
    .radio-group {
        display: flex;
        gap: 30px;
        margin-top: 10px;
    }
    
    .radio-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: normal;
        cursor: pointer;
    }
    
    .btn-search {
        background: #dc2626;
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
    }
    
    .btn-search:hover {
        background: #b91c1c;
    }
    
    .info-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .info-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .results-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .results-table th {
        background: #f8fafc;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #475569;
    }
    
    .results-table td {
        padding: 15px;
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
        margin-bottom: 20px;
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
    
    .filter-info {
        background: #f8fafc;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
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

<div class="search-container">
    <div class="lang-switch">
        <a href="{{ url('/language/fr') }}" class="lang-btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">FR</a>
        <a href="{{ url('/language/ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
    </div>

    <div class="search-header">
        <h1>🩸 {{ app()->getLocale() == 'ar' ? 'البحث عن متبرعين' : 'Rechercher des Donneurs' }}</h1>
        <p>{{ app()->getLocale() == 'ar' ? 'ابحث عن متبرعين متوافقين حسب فصيلة الدم والمدينة' : 'Trouvez des donneurs compatibles par groupe sanguin et ville' }}</p>
    </div>

    <!-- Search Form -->
    <div class="search-card">
        <form action="{{ route('donor.search.results') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم *' : 'Groupe sanguin *' }}</label>
                    <select name="blood_type" required>
                        <option value="">{{ app()->getLocale() == 'ar' ? '-- اختر --' : '-- Sélectionner --' }}</option>
                        @foreach($bloodTypes as $type)
                            <option value="{{ $type }}" {{ isset($bloodType) && $bloodType == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</label>
                    <select name="city">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع المدن' : 'Toutes les villes' }}</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}" {{ isset($city) && $city == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'نوع البحث' : 'Type de recherche' }}</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="search_type" value="donors" {{ (isset($searchType) && $searchType == 'donors') || !isset($searchType) ? 'checked' : '' }}>
                        {{ app()->getLocale() == 'ar' ? 'المتبرعين' : 'Donneurs' }}
                    </label>
                    <label>
                        <input type="radio" name="search_type" value="blood_bank" {{ isset($searchType) && $searchType == 'blood_bank' ? 'checked' : '' }}>
                        {{ app()->getLocale() == 'ar' ? 'بنك الدم' : 'Banque de sang' }}
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn-search">
                🔍 {{ app()->getLocale() == 'ar' ? 'بحث' : 'Rechercher' }}
            </button>
        </form>
    </div>

    <!-- Info Cards (يظهر فقط فالصفحة الرئيسية) -->
    @if(!isset($results))
    <div class="info-cards">
        <div class="info-card">
            <div style="font-size: 40px;">🩸</div>
            <h3>{{ app()->getLocale() == 'ar' ? 'مطابقة ذكية' : 'Matching intelligent' }}</h3>
            <p>{{ app()->getLocale() == 'ar' ? 'يجد تلقائياً فصائل الدم المتوافقة' : 'Trouve automatiquement les groupes compatibles' }}</p>
        </div>
        <div class="info-card">
            <div style="font-size: 40px;">📍</div>
            <h3>{{ app()->getLocale() == 'ar' ? 'بحث حسب الموقع' : 'Recherche par localisation' }}</h3>
            <p>{{ app()->getLocale() == 'ar' ? 'تصفية النتائج حسب المدينة' : 'Filtrez les résultats par ville' }}</p>
        </div>
        <div class="info-card">
            <div style="font-size: 40px;">✅</div>
            <h3>{{ app()->getLocale() == 'ar' ? 'نتائج فورية' : 'Résultats instantanés' }}</h3>
            <p>{{ app()->getLocale() == 'ar' ? 'عرض المتبرعين المتاحين فقط' : 'Affiche uniquement les donneurs disponibles' }}</p>
        </div>
    </div>
    @endif

    <!-- Results -->
    @if(isset($results))
        <!-- Filter Info -->
        <div class="filter-info">
            <div class="filter-tag">
                <strong>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم:' : 'Groupe sanguin:' }}</strong> {{ $bloodType }}
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
        @if(isset($compatibleTypes) && $searchType == 'donors')
        <div class="compatible-box">
            <strong>🩸 {{ app()->getLocale() == 'ar' ? 'فصائل الدم المتوافقة مع' : 'Groupes sanguins compatibles avec' }} {{ $bloodType }}:</strong>
            <div class="compatible-types">
                @foreach($compatibleTypes as $type)
                    <span class="compatible-type">{{ $type }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Results Table -->
        <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h3 style="padding: 20px; margin: 0; border-bottom: 1px solid #e2e8f0;">
                📊 {{ app()->getLocale() == 'ar' ? 'نتائج البحث' : 'Résultats de recherche' }}
                ({{ count($results) }} {{ app()->getLocale() == 'ar' ? 'نتيجة' : 'résultat(s)' }})
            </h3>
            
            @if(count($results) > 0)
                @if($searchType == 'donors')
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
                                <td><strong>{{ $donor->user ? $donor->user->name : 'N/A' }}</strong></td>
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
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم' : 'Groupe sanguin' }}</th>
                                <th>{{ app()->getLocale() == 'ar' ? 'الوحدات المتاحة' : 'Unités disponibles' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $index => $stock)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="blood-badge">🩸 {{ $stock->blood_type }}</span></td>
                                <td><strong>{{ $stock->units_available }}</strong> {{ app()->getLocale() == 'ar' ? 'وحدة' : 'unités' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @else
                <div class="empty-state">
                    <div class="icon">🔍</div>
                    <h3>{{ app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'Aucun résultat' }}</h3>
                    <p>{{ app()->getLocale() == 'ar' ? 'لم يتم العثور على نتائج مطابقة لبحثك' : 'Aucun résultat trouvé pour votre recherche' }}</p>
                </div>
            @endif
        </div>

        <a href="{{ route('donor.search') }}" class="btn-back">
            ← {{ app()->getLocale() == 'ar' ? 'العودة إلى البحث' : 'Retour à la recherche' }}
        </a>
    @endif
</div>
@endsection