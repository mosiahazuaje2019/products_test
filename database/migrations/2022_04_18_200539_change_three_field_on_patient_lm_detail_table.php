<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeThreeFieldOnPatientLmDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_lm_details', function (Blueprint $table) {
            if (Schema::hasColumn('patient_lm_details', 'lm_id')) {
                $table->dropColumn('lm_id');
            }

            $table->unsignedBigInteger('order_id')->after('product_id');
            $table->foreign('order_id')->references('id')->on('patient_lms');
            $table->dropColumn('presentation_id');
            $table->dropColumn('delivery');
            $table->dropColumn('price');
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
            $table->string('lm_id', 255)->after('price');
            $table->dropForeign('patient_lm_details_order_id_foreign');
            $table->dropColumn('order_id');
        });
    }
}
