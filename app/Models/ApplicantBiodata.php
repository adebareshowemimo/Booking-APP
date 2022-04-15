<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantBiodata extends Model
{
    use HasFactory;

    protected $dates = [ 'passport_expiration_date' ];
}
