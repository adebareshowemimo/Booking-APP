<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    use HasFactory;

    public function costs() {
        return $this->hasMany(BookingTypeCost::class)
            ->orderBy('age_year_start', 'asc')
            ->orderBy('age_year_end', 'asc')
            ->orderBy('age_month_start', 'asc')
            ->orderBy('age_month_end', 'asc')
            ->orderBy('age_week_start', 'asc')
            ->orderBy('age_week_end', 'asc');
    }
}
