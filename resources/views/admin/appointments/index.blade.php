@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
    }
    
    .table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: auto;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        padding: 16px 20px;
        text-align: left;
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .data-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
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
    }
    
    .status-completed {
        background: #d1fae5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 20px;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
    }
    
    select {
        padding: 6px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        cursor: pointer;
    }
    
    .pagination {
        margin-top: 24px;
        display: flex;
        justify-content: center;
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
        margin-left: 10px;
    }
    
    .lang-switch.active {
        background: #dc2626;
        color: white;
    }
</style>

<div class="page-header">
    <div>
        <h1>📅 {{ app()->getLocale() == 'ar' ? 'إدارة المواعيد' : 'Gestion des rendez-vous' }}</h1>
    </div>
    <div>
        <a href="{{ url('/language/fr') }}" class="lang-switch {{ app()->getLocale() == 'fr' ? 'active' : '' }}">🇫🇷 FR</a>
        <a href="{{ url('/language/ar') }}" class="lang-switch {{ app()->getLocale() == 'ar' ? 'active' : '' }}">🇸🇦 AR</a>
    </div>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ app()->getLocale() == 'ar' ? 'المتبرع' : 'Donneur' }}</th>
                <th>{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</th>
                <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
                <th>{{ app()->getLocale() == 'ar' ? 'الإجراء' : 'Action' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $index => $appointment)
            <tr>
                <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $index + 1 }}</td>
                <td>{{ $appointment->donor->user->name ?? 'N/A' }}</td>
                <td>{{ $appointment->appointment_date ? $appointment->appointment_date->format('d/m/Y H:i') : 'N/A' }}</td>
                <td>
                    <span class="status-{{ $appointment->status }}">
                        {{ $appointment->status == 'pending' ? (app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente') : 
                           ($appointment->status == 'confirmed' ? (app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé') : 
                           ($appointment->status == 'completed' ? (app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé') : 
                           (app()->getLocale() == 'ar' ? 'ملغى' : 'Annulé'))) }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('admin.update-status', $appointment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente' }}</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé' }}</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé' }}</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'ملغى' : 'Annulé' }}</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $appointments->links() }}
</div>
@endsection