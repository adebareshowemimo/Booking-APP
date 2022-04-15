<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\CarbonPeriod;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);
        \App\Models\BookingType::factory(3)->create()->each(function ($bookingType, $index) {
            // #1 Row
            \App\Models\BookingTypeCost::factory(1)->create([
                'booking_type_id' => $bookingType->id,
                'age_year_start' => 0,
                'age_month_start' => 0,
                'age_week_start' => 0,
                'age_year_end' => 0,
                'age_month_end' => 0,
                'age_week_end' => 5
            ]);

            \App\Models\BookingTypeCost::factory(1)->create([
                'booking_type_id' => $bookingType->id,
                'age_year_start' => 0,
                'age_month_start' => 0,
                'age_week_start' => 6,
                'age_year_end' => 0,
                'age_month_end' => 5,
                'age_week_end' => 0
            ]);

            \App\Models\BookingTypeCost::factory(1)->create([
                'booking_type_id' => $bookingType->id,
                'age_year_start' => 1,
                'age_month_start' => 0,
                'age_week_start' => 0,
                'age_year_end' => 1,
                'age_month_end' => 11,
                'age_week_end' => 0
            ]);


            \App\Models\BookingTypeCost::factory(1)->create([
                'booking_type_id' => $bookingType->id,
                'age_year_start' => 2,
                'age_month_start' => 0,
                'age_week_start' => 0,
                'age_year_end' => 10,
                'age_month_end' => 0,
                'age_week_end' => 0
            ]);

            \App\Models\BookingTypeCost::factory(1)->create([
                'booking_type_id' => $bookingType->id,
                'age_year_start' => 67,
                'age_month_start' => 0,
                'age_week_start' => 0,
                'age_year_end' => 999,
                'age_month_end' => 0,
                'age_week_end' => 0
            ]);
        });
        \App\Models\SiteInformation::factory(1)->create();

        $period = CarbonPeriod::create('2022-03-19', '2022-12-19');

        // Iterate over the period
        foreach ($period as $date) {
            $appointmentDate = \App\Models\AppointmentDate::create([
                'date' => $date->format('Y-m-d'),
                'user_id' => 1
            ]);

            \App\Models\AppointmentTime::factory(3)->create([
                'appointment_date_id' => $appointmentDate->id
            ]);
        }
    }
}
