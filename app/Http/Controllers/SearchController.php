<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\BloodStock;

class SearchController extends Controller
{
    public function index()
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Tanger', 'Agadir', 'Oujda', 'Kenitra'];
        return view('donor.search.search_index', compact('bloodTypes', 'cities'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'blood_type' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'city' => ['nullable', 'string', 'max:100'],
            'search_type' => ['required', 'in:donors,blood_bank'],
        ]);

        $bloodType = $validated['blood_type'];
        $city = $validated['city'] ?? null;
        $searchType = $validated['search_type'];

        $compatibleTypes = $this->getCompatibleTypes($bloodType);
        
        if ($searchType === 'donors') {
            $query = Donor::with('user')
                ->where('is_available', true)
                ->whereIn('blood_type', $compatibleTypes);
            if ($city) {
                $query->where('city', 'LIKE', "%{$city}%");
            }
            $results = $query->limit(50)->get();
        } else {
            $results = BloodStock::whereIn('blood_type', $compatibleTypes)
                ->where('units_available', '>', 0)
                ->get();
        }

        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Tanger', 'Agadir', 'Oujda', 'Kenitra'];

        return view('donor.search.search_index', compact(
            'results', 'bloodType', 'city', 'searchType', 
            'bloodTypes', 'cities', 'compatibleTypes'
        ));
    }

    private function getCompatibleTypes(string $neededType): array
    {
        $map = [
            'A+'  => ['A+', 'A-', 'O+', 'O-'],
            'A-'  => ['A-', 'O-'],
            'B+'  => ['B+', 'B-', 'O+', 'O-'],
            'B-'  => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+'  => ['O+', 'O-'],
            'O-'  => ['O-'],
        ];
        return $map[$neededType] ?? [];
    }
}