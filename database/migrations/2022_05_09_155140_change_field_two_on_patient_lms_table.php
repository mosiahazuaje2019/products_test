<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTwoOnPatientLmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_lms', function (Blueprint $table) {
            $table->string('lm_code',60)->after('diagnostic')->nullable(true);
            $table->string('authorized_by',120)->after('lm_code')->nullable(true);
            $table->longText('observation')->after('authorized_by')->nullable(true);
            $table->unsignedBigInteger('phone_id')->after('observation')->nullable(true);
            $table->unsignedBigInteger('address_id')->after('phone_id')->nullable(true);
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
            $table->dropColumn('lm_code');
            $table->dropColumn('authorized_by');
            $table->dropColumn('observation');
            $table->dropColumn('phone_id');
            $table->dropColumn('address_id');
        });
    }
}
