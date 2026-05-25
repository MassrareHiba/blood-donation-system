<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Appointment;
use App\Models\BloodStock;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_donors' => Donor::count(),
            'total_appointments' => Appointment::count(),
            'total_blood_units' => BloodStock::sum('units_available'),
        ];
        return view('reports.index', compact('stats'));
    }

    public function donorsReport()
    {
        $donors = Donor::with('user')->get();
        $pdf = Pdf::loadView('reports.donors', compact('donors'));
        return $pdf->download('donors_' . now()->format('Y-m-d') . '.pdf');
    }

    public function bloodStockReport()
    {
        $bloodStocks = BloodStock::all();
        $totalUnits = BloodStock::sum('units_available');
        $pdf = Pdf::loadView('reports.blood_stock', compact('bloodStocks', 'totalUnits'));
        return $pdf->download('blood_stock_' . now()->format('Y-m-d') . '.pdf');
    }

    public function appointmentsReport()
    {
        $appointments = Appointment::with(['donor.user'])->orderBy('appointment_date', 'desc')->get();
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];
        $pdf = Pdf::loadView('reports.appointments', compact('appointments', 'stats'));
        return $pdf->download('appointments_' . now()->format('Y-m-d') . '.pdf');
    }

    public function donorCard($donorId)
    {
        $donor = Donor::with('user')->findOrFail($donorId);
        $pdf = Pdf::loadView('reports.donor_card', compact('donor'));
        return $pdf->download('donor_card_' . $donor->user->name . '.pdf');
    }

    // ========== EXPORT XML (مرة وحدة فقط) ==========
    public function exportXML()
    {
        $donors = Donor::with('user')->get();
        
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><donors/>');
        
        foreach ($donors as $donor) {
            $donorNode = $xml->addChild('donor');
            $donorNode->addChild('id', $donor->id);
            $donorNode->addChild('name', htmlspecialchars($donor->user->name));
            $donorNode->addChild('email', htmlspecialchars($donor->user->email));
            $donorNode->addChild('blood_type', $donor->blood_type);
            $donorNode->addChild('city', htmlspecialchars($donor->city ?? ''));
            $donorNode->addChild('phone', $donor->phone ?? '');
            $donorNode->addChild('is_available', $donor->is_available ? 'true' : 'false');
        }
        
        $xmlString = $xml->asXML();
        
        return response($xmlString, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="donors_export_' . date('Y-m-d') . '.xml"');
    }

    // ========== IMPORT XML ==========
    public function importXML(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml|max:2048'
        ]);
        
        $file = $request->file('xml_file');
        $xmlContent = simplexml_load_file($file->getPathname());
        
        $imported = 0;
        $errors = [];
        
        foreach ($xmlContent->donor as $donorNode) {
            try {
                $user = User::where('email', (string)$donorNode->email)->first();
                
                if (!$user) {
                    $user = User::create([
                        'name' => (string)$donorNode->name,
                        'email' => (string)$donorNode->email,
                        'password' => bcrypt('password123'),
                        'role' => 'donor',
                    ]);
                }
                
                Donor::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone' => (string)$donorNode->phone,
                        'blood_type' => (string)$donorNode->blood_type,
                        'city' => (string)$donorNode->city,
                        'is_available' => (string)$donorNode->is_available === 'true',
                        'address' => '',
                        'date_of_birth' => '1990-01-01',
                        'gender' => 'male',
                        'weight' => 70,
                    ]
                );
                
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Error importing donor: " . $e->getMessage();
            }
        }
        
        return redirect()->back()
            ->with('success', "Imported $imported donors successfully!")
            ->with('errors', $errors);
    }
}