<?php

namespace App\Models;

use App\Models\Relationships\AppointmentRelationships;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use AppointmentRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'clinic_id',
        'appointment_schedule_id',
        'start_at',
    ];
}
