<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodStock;
use App\Models\Donor;
use App\Models\Appointment;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_donors' => Donor::count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_blood_units' => BloodStock::sum('units_available'),
        ];

        $bloodStocks = BloodStock::all();
        $recentAppointments = Appointment::with('donor.user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'bloodStocks', 'recentAppointments'));
    }

    public function donors()
    {
        $donors = Donor::with('user')->paginate(20);
        return view('admin.donors.index', compact('donors'));
    }

    public function appointments()
    {
        $appointments = Appointment::with('donor.user')->latest()->paginate(20);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function bloodStock()
    {
        $stocks = BloodStock::all();
        return view('admin.blood_stock.index', compact('stocks'));
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated');
    }

    public function updateBloodStock(Request $request, $id)
    {
        $stock = BloodStock::findOrFail($id);
        $stock->update(['units_available' => $request->units_available]);
        return redirect()->back()->with('success', 'Stock updated');
    }
    
}