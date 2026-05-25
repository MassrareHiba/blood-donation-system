<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Appointment;
use App\Models\BloodStock;

class ChartController extends Controller
{
    public function index()
    {
        // Blood type distribution
        $bloodTypeData = Donor::selectRaw('blood_type, COUNT(*) as count')
            ->groupBy('blood_type')
            ->pluck('count', 'blood_type')
            ->toArray();

        // Monthly appointments
        $monthlyAppointments = Appointment::selectRaw('MONTH(appointment_date) as month, COUNT(*) as count')
            ->whereYear('appointment_date', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = $monthlyAppointments[$i] ?? 0;
        }

        // Appointment status
        $appointmentStatus = [
            (app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente') => Appointment::where('status', 'pending')->count(),
            (app()->getLocale() == 'ar' ? 'مؤكد' : 'Confirmé') => Appointment::where('status', 'confirmed')->count(),
            (app()->getLocale() == 'ar' ? 'مكتمل' : 'Terminé') => Appointment::where('status', 'completed')->count(),
        ];

        // Blood stock
        $bloodStock = BloodStock::pluck('units_available', 'blood_type')->toArray();

        // City distribution
        $cityData = Donor::selectRaw('city, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->pluck('count', 'city')
            ->toArray();

        // Availability
        $availabilityData = [
            (app()->getLocale() == 'ar' ? 'متاح' : 'Disponible') => Donor::where('is_available', true)->count(),
            (app()->getLocale() == 'ar' ? 'غير متاح' : 'Indisponible') => Donor::where('is_available', false)->count(),
        ];

        return view('charts.index', compact(
            'bloodTypeData', 'monthlyData', 'appointmentStatus',
            'bloodStock', 'cityData', 'availabilityData'
        ));
    }
}