<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDate extends Model
{
    use HasFactory;

    protected $dates = [ 'schedule' ];

    public function times()
    {
        return $this->hasMany(AppointmentTime::class);
    }
}
