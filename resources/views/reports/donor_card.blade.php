<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.donor_card') }} - {{ $donor->user->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px; }
        .card { width: 350px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { background: #e74c3c; color: white; padding: 20px; text-align: center; }
        .body { padding: 20px; }
        .info { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .blood-type { font-size: 48px; font-weight: bold; color: #e74c3c; text-align: center; margin: 15px 0; }
        .footer { background: #f9f9f9; padding: 15px; text-align: center; font-size: 11px; color: #666; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>🩸 {{ __('messages.donor') }}</h2>
            <p>{{ __('messages.donor_card') }}</p>
        </div>
        <div class="body">
            <div class="blood-type">{{ $donor->blood_type }}</div>
            <div class="info"><span><strong>{{ __('messages.name') }}</strong></span><span>{{ $donor->user->name }}</span></div>
            <div class="info"><span><strong>{{ __('messages.blood_type') }}</strong></span><span>{{ $donor->blood_type }}</span></div>
            <div class="info"><span><strong>{{ __('messages.city') }}</strong></span><span>{{ $donor->city }}</span></div>
            <div class="info"><span><strong>{{ __('messages.status') }}</strong></span><span>{{ $donor->is_available ? __('messages.available') : __('messages.unavailable') }}</span></div>
        </div>
        <div class="footer">
            <p>{{ __('messages.system_name') }}</p>
            <p>ID: #{{ str_pad($donor->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>
</body>
</html>