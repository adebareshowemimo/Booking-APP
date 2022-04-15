<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTime extends Model
{
    use HasFactory;

    public function date()
    {
        return $this->belongsTo(AppointmentDate::class,  'appointment_date_id', 'id');
    }
}
