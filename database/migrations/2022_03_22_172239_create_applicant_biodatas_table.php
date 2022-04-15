<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantBiodatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_biodatas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id');
            $table->boolean('same_as_primary')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expiration_date')->nullable();
            $table->text('home_address_nigeria')->nullable();
            $table->text('us_intended_address')->nullable();
            $table->text('home_address')->nullable();
            $table->string('case_number')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('applicant_biodatas');
    }
}
