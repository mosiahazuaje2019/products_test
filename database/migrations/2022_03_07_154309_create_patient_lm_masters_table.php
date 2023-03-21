<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientLmMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_lm_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->longText('diagnostic');
            $table->longText('observation');
            $table->date('dispactch_date');
            $table->date('generation_date');
            $table->longText('observation2');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
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
        Schema::dropIfExists('patient_lm_masters');
    }
}
