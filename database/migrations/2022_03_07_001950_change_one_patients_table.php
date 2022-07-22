<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOnePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('patients', 'birthday')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('birthday_date');
                $table->string('age',10)->after('personal_id');
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
        if (Schema::hasColumn('patients', 'age')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('age');
                $table->date('birthday_date')->after('personal_id')->nullable(true);
            });
        }
    }
}
