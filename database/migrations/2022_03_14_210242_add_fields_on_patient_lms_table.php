<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnPatientLmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_lms', function (Blueprint $table) {
            $table->date('date_ini')->after('lm_id');
            $table->date('date_end')->after('date_ini');
            $table->longText('diagnostic')->after('date_end');
            $table->unsignedBigInteger('doctor_id')->after('diagnostic');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_lms', function (Blueprint $table) {
            $table->dropForeign('patient_lms_doctor_id_foreign');
            $table->dropColumn('date_ini');
            $table->dropColumn('date_end');
            $table->dropColumn('diagnostic');
            $table->dropColumn('doctor_id');
        });
    }
}
