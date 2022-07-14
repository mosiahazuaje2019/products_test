<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldOneOnPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function(Blueprint $table){
            $table->dropColumn('birthday_date');
            $table->string('age')->after('personal_id');
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function(Blueprint $table){
            $table->date('birthday_date')->after('personal_id');
            $table->unsignedBigInteger('user_id')->after('city_id');
            $table->dropColumn('age');
        });
    }
}
