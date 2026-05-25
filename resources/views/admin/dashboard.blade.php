@extends('layouts.app')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        background: #fef2f2;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
        margin: 0 auto 16px auto;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #dc2626;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #64748b;
    }
    
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    
    .card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        font-weight: 700;
        font-size: 18px;
    }
    
    .data-table {
        width: 100%;
    }
    
    .data-table th {
        padding: 16px 20px;
        text-align: left;
        color: #64748b;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #f8fafc;
    }
    
    .data-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
    }
    
    .badge-blood {
        background: #fef2f2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
    }
    
    .progress-bar {
        width: 100%;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        background: #dc2626;
    }
    
    .progress-fill.low {
        background: #f59e0b;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #d97706;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    
    .status-confirmed {
        background: #dbeafe;
        color: #2563eb;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    
    .status-completed {
        background: #d1fae5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
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
    
    .xml-section {
        margin-top: 32px;
    }
    
    .xml-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        padding: 24px;
    }
    
    .xml-box {
        text-align: center;
        padding: 24px;
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.3s;
    }
    
    .xml-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .btn-export {
        display: inline-block;
        margin-top: 16px;
        background: #10b981;
        color: white;
        padding: 10px 24px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
    }
    
    .btn-export:hover {
        background: #059669;
    }
    
    .btn-import {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 12px;
    }
    
    .btn-import:hover {
        background: #1d4ed8;
    }
    
    .file-input-custom {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 30px;
        padding: 8px 16px;
        color: #1e293b;
        width: 100%;
    }
    
    .file-input-custom:focus {
        outline: none;
        border-color: #dc2626;
    }
</style>

<div style="margin-bottom: 24px; display: flex; justify-content: flex-end; gap: 12px;">
    <a href="{{ url('/language/fr') }}" class="lang-switch {{ app()->getLocale() == 'fr' ? 'active' : '' }}">🇫🇷 FR</a>
    <a href="{{ url('/language/ar') }}" class="lang-switch {{ app()->getLocale() == 'ar' ? 'active' : '' }}">🇸🇦 AR</a>
</div>

<h1 style="font-size: 32px; font-weight: 800; margin-bottom: 32px; color: #1e293b;">
    👑 {{ app()->getLocale() == 'ar' ? 'لوحة تحكم المدير' : 'Tableau de bord Administrateur' }}
</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">🩸</div>
        <div class="stat-value">{{ $stats['total_donors'] }}</div>
        <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'المتبرعين' : 'Donneurs' }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-value">{{ $stats['total_appointments'] }}</div>
        <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'المواعيد' : 'Rendez-vous' }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-value">{{ $stats['pending_appointments'] }}</div>
        <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente' }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💉</div>
        <div class="stat-value">{{ $stats['total_blood_units'] }}</div>
        <div class="stat-label">{{ app()->getLocale() == 'ar' ? 'وحدات الدم' : 'Unités de sang' }}</div>
    </div>
</div>

<div class="content-grid">
    <div class="card">
        <div class="card-header">🩸 {{ app()->getLocale() == 'ar' ? 'مخزون الدم' : 'Stock de sang' }}</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() == 'ar' ? 'الفصيلة' : 'Groupe' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الوحدات' : 'Unités' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'المستوى' : 'Niveau' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bloodStocks as $stock)
                <tr>
                    <td><span class="badge-blood">{{ $stock->blood_type }}</span></td>
                    <td>{{ $stock->units_available }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill {{ $stock->units_available < 10 ? 'low' : '' }}" style="width: {{ min(100, $stock->units_available) }}%"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">📋 {{ app()->getLocale() == 'ar' ? 'آخر المواعيد' : 'Derniers rendez-vous' }}</div>
        @foreach($recentAppointments as $appointment)
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #1e293b;">{{ $appointment->donor->user->name ?? 'N/A' }}</strong><br>
                    <small style="color: #64748b;">{{ $appointment->appointment_date ? $appointment->appointment_date->format('d/m/Y H:i') : 'N/A' }}</small>
                </div>
                <span class="status-{{ $appointment->status }}">
                    {{ $appointment->status == 'pending' ? (app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente') : 
                       ($appointment->status == 'confirmed' ? (app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé') : 
                       ($appointment->status == 'completed' ? (app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé') : 'Annulé')) }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="xml-section">
    <div class="card">
        <div class="card-header" style="background: #dc2626; color: white;">
            📁 {{ app()->getLocale() == 'ar' ? 'استيراد/تصدير XML' : 'Import/Export XML' }}
        </div>
        <div class="xml-grid">
            <div class="xml-box">
                <div style="font-size: 48px; margin-bottom: 12px;">📥</div>
                <h4 style="margin-bottom: 8px;">{{ app()->getLocale() == 'ar' ? 'تصدير XML' : 'Export XML' }}</h4>
                <p style="color: #64748b; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'تصدير جميع المتبرعين إلى ملف XML' : 'Exporter tous les donneurs vers un fichier XML' }}</p>
                <a href="{{ route('admin.export-xml') }}" class="btn-export">⬇️ {{ app()->getLocale() == 'ar' ? 'تحميل' : 'Télécharger' }}</a>
            </div>
            <div class="xml-box">
                <div style="font-size: 48px; margin-bottom: 12px;">📤</div>
                <h4 style="margin-bottom: 8px;">{{ app()->getLocale() == 'ar' ? 'استيراد XML' : 'Import XML' }}</h4>
                <p style="color: #64748b; font-size: 14px;">{{ app()->getLocale() == 'ar' ? 'استيراد متبرعين من ملف XML' : 'Importer des donneurs depuis un fichier XML' }}</p>
                <form action="{{ route('admin.import-xml') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="xml_file" accept=".xml" required class="file-input-custom">
                    <button type="submit" class="btn-import">⬆️ {{ app()->getLocale() == 'ar' ? 'رفع واستيراد' : 'Importer' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection