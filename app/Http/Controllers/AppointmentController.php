<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Donor;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmed;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $donor = auth()->user()->donor;
        $appointments = $donor->appointments()->orderBy('appointment_date', 'desc')->get();
        return view('donor.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('donor.appointments.create');
    }

    // ========== STORE (مرة وحدة فقط) ==========
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $donor = auth()->user()->donor;

        if (!$donor) {
            return redirect()->back()->with('error', 'Donor profile not found');
        }

        $dateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);

        $appointment = Appointment::create([
            'donor_id' => $donor->id,
            'appointment_date' => $dateTime,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        try {
            Mail::to($donor->user->email)->send(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            \Log::error('Email failed: ' . $e->getMessage());
        }

        return redirect()->route('donor.appointments')
            ->with('success', app()->getLocale() == 'ar' ? 'تم إنشاء الموعد بنجاح!' : 'Rendez-vous créé avec succès !');
    }
    // ========== نهاية STORE ==========

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->donor_id != auth()->user()->donor->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        
        $appointment->update(['status' => 'cancelled']);
        
        return redirect()->route('donor.appointments')
            ->with('success', app()->getLocale() == 'ar' ? 'تم إلغاء الموعد!' : 'Rendez-vous annulé !');
    }
}