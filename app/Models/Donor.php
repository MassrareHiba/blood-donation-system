<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'blood_type',
        'address',
        'city',
        'date_of_birth',
        'gender',
        'weight',
        'medical_history',
        'last_donation_date',
        'is_available',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_donation_date' => 'datetime',
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function age(): int
    {
        return $this->date_of_birth->age;
    }

    public function canDonate(): bool
    {
        if (!$this->is_available) {
            return false;
        }

        if ($this->last_donation_date === null) {
            return true;
        }

        return $this->last_donation_date->diffInDays(now()) >= 56;
    }
}