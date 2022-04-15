<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique_id');
            $table->unsignedBigInteger('booking_type_id')->nullable();
            $table->unsignedInteger('total_applicants')->nullable();
            $table->datetime('booking_date_time')->nullable();
            $table->string('email')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('payment_amount', 16, 2)->nullable();
            $table->datetime('payment_date')->nullable();
            $table->string('primary_phone_number')->nullable();
            $table->string('secondary_phone_number')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
