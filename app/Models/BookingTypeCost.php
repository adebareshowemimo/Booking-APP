<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTypeCost extends Model
{
    use HasFactory;

    public function getAgeFromAttribute()
    {
        $result = [];
        if ($this->age_year_start) {
            $result []= $this->age_year_start . " year(s)";
        }
        if ($this->age_month_start) {
            $result []= $this->age_month_start . " month(s)";
        }
        if ($this->age_week_start || count($result) === 0) {
            $result []= $this->age_week_start . " week(s)";
        }
        return implode(",", $result);
    }

    public function getAgeToAttribute()
    {
        $result = [];
        if ($this->age_year_end) {
            $result []= $this->age_year_end . " year(s)";
        }
        if ($this->age_month_end) {
            $result []= $this->age_month_end . " month(s)";
        }
        if ($this->age_week_end || count($result) === 0) {
            $result []= $this->age_week_end . " week(s)";
        }
        return implode(",", $result);
    }
}
