<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $subject = app()->getLocale() == 'ar' 
            ? '✅ تأكيد موعد التبرع بالدم' 
            : '✅ Confirmation de rendez-vous de don de sang';

        return $this->subject($subject)->view('emails.appointment_confirmed');
    }
}