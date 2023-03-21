<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldThreeOnPatientLmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_lms', function (Blueprint $table){
            $table->integer('discount_percent')->after('status')->nullable(true);
            $table->string('invoice_number')->after('discount_percent')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_lms', function (Blueprint $table){
            $table->dropColumn('discount_percent');
            $table->dropColumn('invoice_number');
        });
    }
}
