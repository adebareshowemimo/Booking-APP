<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applicants()
    {
        return $this->hasMany(Applicant::class)->orderBy('applicant_order', 'ASC');
    }

    public function booking_type()
    {
        return $this->belongsTo(BookingType::class);
    }
}
