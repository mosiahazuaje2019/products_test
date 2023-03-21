<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTwoOnPatientLmDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_lm_details', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->after('order_id');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_lm_details', function (Blueprint $table) {
            $table->dropForeign('patient_lm_details_patient_id_foreign');
            $table->dropColumn('patient_id');
        });
    }
}
