<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodStock extends Model
{
    use HasFactory;

    protected $table = 'blood_stocks';

    protected $fillable = [
        'blood_type',
        'units_available',
        'units_reserved',
        'storage_location',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function totalUnits(): int
    {
        return $this->units_available + $this->units_reserved;
    }

    public function availableUnits(): int
    {
        return $this->units_available - $this->units_reserved;
    }

    public static function getCompatibleTypes(string $neededType): array
    {
        $compatibility = [
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+' => ['O+', 'O-'],
            'O-' => ['O-'],
        ];

        return $compatibility[$neededType] ?? [];
    }
}