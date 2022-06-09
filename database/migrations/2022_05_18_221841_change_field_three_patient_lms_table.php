<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldThreePatientLmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_lms', function (Blueprint $table) {
            $table->dropColumn('diagnostic');
            $table->unsignedBigInteger('diagnostic_id')->nullable(true)->after('address_id');
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
            $table->longText('diagnostic')->after('date_end');
            $table->dropColumn('diagnostic_id');
        });
    }
}
