<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.blood_stock_report') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { color: #e74c3c; margin: 0; }
        .summary { background: #f9f9f9; padding: 15px; margin: 15px 0; border-radius: 5px; }
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
        <h2>{{ __('messages.blood_stock_report') }}</h2>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <h3>{{ __('messages.total_blood_units') }}: <span style="color:#e74c3c;">{{ $totalUnits }}</span></h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ __('messages.blood_type') }}</th>
                <th>{{ __('messages.units_available') }}</th>
                <th>{{ __('messages.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bloodStocks as $stock)
            <tr>
                <td><strong>{{ $stock->blood_type }}</strong></td>
                <td>{{ $stock->units_available }}</td>
                <td>{{ $stock->units_available > 10 ? __('messages.available') : __('messages.unavailable') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ __('messages.system_name') }}</p>
    </div>
</body>
</html>