@extends('layouts.app')

@section('content')
<style>
    .admin-donors-container {
        max-width: 100%;
        overflow-x: auto;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title h1 {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 5px 0;
    }

    .page-title p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .lang-switcher {
        display: flex;
        gap: 10px;
    }

    .lang-btn {
        padding: 8px 20px;
        border-radius: 30px;
        border: 2px solid #dc2626;
        background: white;
        color: #dc2626;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
    }

    .lang-btn:hover, .lang-btn.active {
        background: #dc2626;
        color: white;
    }

    .stats-row {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .stat-box {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        flex: 1;
        min-width: 130px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        color: #dc2626;
    }

    .stat-label {
        color: #64748b;
        font-size: 13px;
        margin-top: 5px;
    }

    .table-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .donors-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .donors-table th {
        padding: 15px 18px;
        text-align: left;
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
    }

    .donors-table td {
        padding: 15px 18px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 14px;
    }

    .donors-table tr:hover td {
        background: #fef2f2;
    }

    .blood-badge {
        background: #fef2f2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }

    .status-available {
        background: #d1fae5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-unavailable {
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .pagination-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .pagination-info {
        color: #64748b;
        font-size: 14px;
    }

    .pagination-links {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .pagination-links a {
        padding: 8px 14px;
        border-radius: 8px;
        background: white;
        color: #1e293b;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        transition: all 0.2s;
        display: inline-block;
    }

    .pagination-links a:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    .pagination-links span.active {
        background: #dc2626;
        color: white;
        border: 1px solid #dc2626;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
    }

    .pagination-links span.disabled {
        padding: 8px 14px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        cursor: not-allowed;
        display: inline-block;
    }

    .empty-state {
        text-align: center;
        padding: 60px;
        color: #94a3b8;
    }

    .empty-state .icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .stats-row { flex-direction: column; }
        .pagination-area { flex-direction: column; align-items: center; }
        .header-section { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="admin-donors-container">
    <!-- Header -->
    <div class="header-section">
        <div class="page-title">
            <h1>🩸 {{ app()->getLocale() == 'ar' ? 'قائمة المتبرعين' : 'Liste des donneurs' }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'إدارة المتبرعين المسجلين في النظام' : 'Gérez les donneurs inscrits dans le système' }}</p>
        </div>
        <div class="lang-switcher">
            <a href="{{ url('/language/fr') }}" class="lang-btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">🇫🇷 FR</a>
            <a href="{{ url('/language/ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">🇸🇦 AR</a>
        </div>
    </div>

    <!-- Statistics -->
    @php
        $total = $donors->total();
        $available = $donors->where('is_available', true)->count();
        $unavailable = $donors->where('is_available', false)->count();
    @endphp

    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'إجمالي المتبرعين' : 'Total donneurs' }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $available }}</div>
            <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'متاحون للتبرع' : 'Disponibles' }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $unavailable }}</div>
            <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'غير متاحين' : 'Indisponibles' }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="donors-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Nom' }}</th>
                    <th>Email</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'فصيلة الدم' : 'Groupe' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'المدينة' : 'Ville' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Téléphone' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donors as $index => $donor)
                <tr>
                    <td>{{ $donors->firstItem() + $index }}</td>
                    <td><strong>{{ $donor->user->name ?? 'N/A' }}</strong></td>
                    <td>{{ $donor->user->email ?? 'N/A' }}</td>
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
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <div class="icon">🩸</div>
                        <p>{{ app()->getLocale() == 'ar' ? 'لا توجد متبرعين مسجلين' : 'Aucun donneur enregistré' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-area">
        <div class="pagination-info">
            {{ app()->getLocale() == 'ar' ? 'عرض' : 'Affichage' }} 
            <strong>{{ $donors->firstItem() ?? 0 }}</strong> 
            {{ app()->getLocale() == 'ar' ? 'إلى' : 'à' }} 
            <strong>{{ $donors->lastItem() ?? 0 }}</strong> 
            {{ app()->getLocale() == 'ar' ? 'من أصل' : 'sur' }} 
            <strong>{{ $donors->total() }}</strong> 
            {{ app()->getLocale() == 'ar' ? 'نتيجة' : 'résultats' }}
        </div>
        <div class="pagination-links">
            @if ($donors->hasPages())
                {{-- Bouton Précédent --}}
                @if ($donors->onFirstPage())
                    <span class="disabled">← {{ app()->getLocale() == 'ar' ? 'السابق' : 'Précédent' }}</span>
                @else
                    <a href="{{ $donors->previousPageUrl() }}">← {{ app()->getLocale() == 'ar' ? 'السابق' : 'Précédent' }}</a>
                @endif

                {{-- Numéros de pages --}}
                @foreach ($donors->getUrlRange(1, $donors->lastPage()) as $page => $url)
                    @if ($page == $donors->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Bouton Suivant --}}
                @if ($donors->hasMorePages())
                    <a href="{{ $donors->nextPageUrl() }}">{{ app()->getLocale() == 'ar' ? 'التالي' : 'Suivant' }} →</a>
                @else
                    <span class="disabled">{{ app()->getLocale() == 'ar' ? 'التالي' : 'Suivant' }} →</span>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection