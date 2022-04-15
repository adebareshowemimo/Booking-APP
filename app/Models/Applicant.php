<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Applicant extends Model
{
    use HasFactory;

    protected $dates = [ 'birth_date' ];

    public function getAgeAttribute() {
        return Carbon::parse($this->birth_date)->diff(Carbon::now());
    }

    public function biodata()
    {
        return $this->hasOne(ApplicantBiodata::class);
    }
}
