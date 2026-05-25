<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Appointment;

class DonorController extends Controller
{
    public function dashboard()
    {
        $donor = auth()->user()->donor;
        $appointments = $donor->appointments()->orderBy('appointment_date', 'desc')->get();
        return view('donor.dashboard', compact('donor', 'appointments'));
    }

    public function editProfile()
    {
        $donor = auth()->user()->donor;
        return view('donor.profile.edit', compact('donor'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
        ]);

        $donor = auth()->user()->donor;
        $donor->update($request->only(['phone', 'city', 'date_of_birth', 'address']));

        return redirect()->route('donor.dashboard')
            ->with('success', app()->getLocale() == 'ar' ? 'تم تحديث الملف بنجاح!' : 'Profil mis à jour avec succès !');
    }

    public function history()
    {
        $donor = auth()->user()->donor;
        $history = $donor->appointments()->where('status', 'completed')->orderBy('appointment_date', 'desc')->get();
        return view('donor.history.index', compact('history', 'donor'));
    }

    public function settings()
    {
        return view('donor.settings.index');
    }
}