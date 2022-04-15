<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTypeCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_type_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_type_id');
            $table->unsignedInteger('age_year_start');
            $table->unsignedInteger('age_month_start');
            $table->unsignedInteger('age_week_start');
            $table->unsignedInteger('age_year_end');
            $table->unsignedInteger('age_month_end');
            $table->unsignedInteger('age_week_end');
            $table->unsignedBigInteger('basic_fee');
            $table->unsignedBigInteger('immunization_fee');
            $table->text('description');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_type_costs');
    }
}
