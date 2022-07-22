<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldOnDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('doctors', 'fisrt_name')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('fisrt_name');
                $table->string('first_name')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('doctors', 'first_name')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('first_name');
                $table->string('fisrt_name')->after('id');
            });
        }
    }
}
