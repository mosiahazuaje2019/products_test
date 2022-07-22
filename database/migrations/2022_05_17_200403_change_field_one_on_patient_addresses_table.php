<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldOneOnPatientAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_adresses', function (Blueprint $table) {
            $table->renameColumn('address', 'name');
            $table->enum('category', ['address','phone'])->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_adresses', function (Blueprint $table) {
            $table->renameColumn('name','address');
            $table->dropColumn('category');
        });
    }
}
