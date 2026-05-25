<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.appointments_report') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { color: #e74c3c; margin: 0; }
        .stats { display: flex; justify-content: space-around; margin: 15px 0; }
        .stat-box { background: #f9f9f9; padding: 10px; border-radius: 5px; text-align: center; width: 22%; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #e74c3c; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9f9f9; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🩸 {{ __('messages.system_name') }}</h1>
        <h2>{{ __('messages.appointments_report') }}</h2>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box"><h4>{{ $stats['total'] }}</h4><p>Total</p></div>
        <div class="stat-box"><h4>{{ $stats['pending'] }}</h4><p>{{ __('messages.pending') }}</p></div>
        <div class="stat-box"><h4>{{ $stats['confirmed'] }}</h4><p>{{ __('messages.confirmed') }}</p></div>
        <div class="stat-box"><h4>{{ $stats['completed'] }}</h4><p>{{ __('messages.completed') }}</p></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.donor') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $index => $appointment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $appointment->donor->user->name }}</td>
                <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                <td>{{ __('messages.' . $appointment->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ __('messages.system_name') }}</p>
    </div>
</body>
</html>