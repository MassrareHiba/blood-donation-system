<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmation Rendez-vous</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; }
        .header { background: #dc2626; color: white; padding: 25px; text-align: center; }
        .content { padding: 25px; }
        .details { background: #f8fafc; padding: 15px; border-radius: 12px; margin: 20px 0; }
        .footer { background: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🩸 Blood Donation System</h1>
        <p>{{ app()->getLocale() == 'ar' ? 'تأكيد الموعد' : 'Confirmation de rendez-vous' }}</p>
    </div>
    <div class="content">
        <h2>{{ app()->getLocale() == 'ar' ? 'مرحباً' : 'Bonjour' }} {{ $appointment->donor->user->name }}</h2>
        <p>{{ app()->getLocale() == 'ar' ? 'تم تأكيد موعد التبرع بالدم الخاص بك.' : 'Votre rendez-vous de don de sang a été confirmé.' }}</p>
        <div class="details">
            <p><strong>{{ app()->getLocale() == 'ar' ? 'التاريخ:' : 'Date:' }}</strong> {{ $appointment->appointment_date->format('d/m/Y H:i') }}</p>
            <p><strong>{{ app()->getLocale() == 'ar' ? 'الحالة:' : 'Statut:' }}</strong> {{ $appointment->status == 'pending' ? (app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente') : ($appointment->status == 'confirmed' ? (app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé') : ($appointment->status == 'completed' ? (app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé') : 'Annulé')) }}</p>
        </div>
        <p>{{ app()->getLocale() == 'ar' ? 'شكراً لك على إنقاذ الأرواح! ❤️' : 'Merci de sauver des vies ! ❤️' }}</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Blood Donation System</p>
    </div>
</div>
</body>
</html>