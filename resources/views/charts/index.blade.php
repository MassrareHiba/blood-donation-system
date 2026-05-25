@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <h1 style="font-size:28px; font-weight:800;">📈 {{ app()->getLocale() == 'ar' ? 'الرسوم البيانية' : 'Graphiques' }}</h1>
    <div>
        <a href="{{ url('/language/fr') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='fr'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='fr'?'white':'#dc2626' }}; text-decoration:none;">FR</a>
        <a href="{{ url('/language/ar') }}" style="padding:8px 16px; border-radius:20px; border:2px solid #dc2626; background:{{ app()->getLocale()=='ar'?'#dc2626':'white' }}; color:{{ app()->getLocale()=='ar'?'white':'#dc2626' }}; text-decoration:none;">AR</a>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:25px;">
    <!-- Pie: Blood Type Distribution -->
    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px;">🩸 {{ app()->getLocale() == 'ar' ? 'توزيع فصائل الدم' : 'Distribution des groupes sanguins' }}</h3>
        <canvas id="bloodTypeChart" height="250"></canvas>
    </div>

    <!-- Line: Monthly Appointments -->
    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px;">📅 {{ app()->getLocale() == 'ar' ? 'المواعيد الشهرية' : 'Rendez-vous mensuels' }}</h3>
        <canvas id="monthlyChart" height="250"></canvas>
    </div>

    <!-- Bar: Appointment Status -->
    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px;">📊 {{ app()->getLocale() == 'ar' ? 'حالة المواعيد' : 'Statut des rendez-vous' }}</h3>
        <canvas id="statusChart" height="250"></canvas>
    </div>

    <!-- Bar: Blood Stock Levels -->
    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px;">💉 {{ app()->getLocale() == 'ar' ? 'مستويات مخزون الدم' : 'Niveaux de stock de sang' }}</h3>
        <canvas id="stockChart" height="250"></canvas>
    </div>

    <!-- Pie: Donors by City -->
    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px;">📍 {{ app()->getLocale() == 'ar' ? 'المتبرعون حسب المدينة' : 'Donneurs par ville' }}</h3>
        <canvas id="cityChart" height="250"></canvas>
    </div>

    <!-- Pie: Donor Availability -->
    <div style="background:white; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px;">✅ {{ app()->getLocale() == 'ar' ? 'توفر المتبرعين' : 'Disponibilité des donneurs' }}</h3>
        <canvas id="availabilityChart" height="250"></canvas>
    </div>
</div>

<script>
// Blood Type Distribution
const bloodTypeData = {!! json_encode($bloodTypeData) !!};
new Chart(document.getElementById('bloodTypeChart'), {
    type: 'pie',
    data: {
        labels: Object.keys(bloodTypeData),
        datasets: [{ data: Object.values(bloodTypeData), backgroundColor: ['#dc2626','#3b82f6','#10b981','#f59e0b','#8b5cf6','#ec4899','#06b6d4','#84cc16'] }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Monthly Appointments
const monthlyData = {!! json_encode(array_values($monthlyData)) !!};
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
        datasets: [{ label: '{{ app()->getLocale() == "ar" ? "المواعيد" : "Rendez-vous" }}', data: monthlyData, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', tension: 0.4, fill: true }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

// Appointment Status
const statusData = {!! json_encode($appointmentStatus) !!};
new Chart(document.getElementById('statusChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(statusData),
        datasets: [{ label: '{{ app()->getLocale() == "ar" ? "العدد" : "Nombre" }}', data: Object.values(statusData), backgroundColor: ['#f59e0b','#3b82f6','#10b981'] }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

// Blood Stock Levels
const stockData = {!! json_encode($bloodStock) !!};
new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(stockData),
        datasets: [{ label: '{{ app()->getLocale() == "ar" ? "الوحدات" : "Unités" }}', data: Object.values(stockData), backgroundColor: '#dc2626' }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});

// Donors by City
const cityData = {!! json_encode($cityData) !!};
new Chart(document.getElementById('cityChart'), {
    type: 'pie',
    data: {
        labels: Object.keys(cityData),
        datasets: [{ data: Object.values(cityData), backgroundColor: ['#dc2626','#3b82f6','#10b981','#f59e0b','#8b5cf6','#1abc9c'] }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Donor Availability
const availabilityData = {!! json_encode($availabilityData) !!};
new Chart(document.getElementById('availabilityChart'), {
    type: 'pie',
    data: {
        labels: Object.keys(availabilityData),
        datasets: [{ data: Object.values(availabilityData), backgroundColor: ['#10b981','#dc2626'] }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endsection