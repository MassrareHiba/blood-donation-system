<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodStock;
use App\Models\Donor;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    // GET /api/blood-stock
    public function bloodStock()
    {
        $stocks = BloodStock::all();
        return response()->json([
            'success' => true,
            'data' => $stocks,
            'message' => 'Blood stock retrieved successfully'
        ], 200);
    }

    // GET /api/donors
    public function donors()
    {
        $donors = Donor::with('user')->get();
        return response()->json([
            'success' => true,
            'data' => $donors,
            'message' => 'Donors retrieved successfully'
        ], 200);
    }

    // GET /api/appointments
    public function appointments()
    {
        $appointments = Appointment::with('donor.user')->get();
        return response()->json([
            'success' => true,
            'data' => $appointments,
            'message' => 'Appointments retrieved successfully'
        ], 200);
    }

    // POST /api/appointments
    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
            'success' => true,
            'data' => $appointment,
            'message' => 'Appointment created successfully'
        ], 201);
    }

    // PUT /api/appointments/{id}
    public function updateAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'appointment_date' => 'sometimes|date',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return response()->json([
            'success' => true,
            'data' => $appointment,
            'message' => 'Appointment updated successfully'
        ], 200);
    }

    // DELETE /api/appointments/{id}
    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully'
        ], 200);
    }
}