<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsOnInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table){
            $table->dropColumn('patient_lms_id');
            $table->dropColumn('patient_id');
            $table->dropColumn('lm_code');
            $table->dropColumn('date_ini');
            $table->string('invoice_number')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table){
            $table->dropColumn('invoice_number');
            $table->unsignedBigInteger('patient_lms_id');
            $table->unsignedSmallInteger('patient_id');
            $table->unsignedBigInteger('lm_code');
            $table->date('date_ini');
        });
    }
}
