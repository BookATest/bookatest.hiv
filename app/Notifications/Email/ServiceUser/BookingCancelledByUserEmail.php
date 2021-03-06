<?php

namespace App\Notifications\Email\ServiceUser;

use App\Models\Appointment;
use App\Models\Notification;
use App\Notifications\Email\Email;

class BookingCancelledByUserEmail extends Email
{
    /**
     * BookingCancelledByUserEmail constructor.
     *
     * @param \App\Models\Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        parent::__construct();

        $this->to = $appointment->serviceUser->email;
        $this->subject = 'Booking Cancellation';
        $this->message = "Your appointment has been cancelled with {$appointment->clinic->name} at {$appointment->start_at->format('l jS F H:i')} by an admin.";
        $this->notification = $appointment->serviceUser->notifications()->create([
            'channel' => Notification::EMAIL,
            'recipient' => $appointment->serviceUser->email,
            'message' => $this->message,
        ]);
    }
}
