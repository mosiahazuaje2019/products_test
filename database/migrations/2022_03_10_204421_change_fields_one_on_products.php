<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsOneOnProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_brand_id_foreign');
            $table->dropColumn(['size', 'count_inventory', 'date_boarding','brand_id']);
            $table->longtext('observation')->change()->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('size', ['S','M','L'])->after('name');
            $table->integer('count_inventory')->after('observation');
            $table->date('date_boarding')->after('count_inventory');
            $table->unsignedBigInteger('brand_id')->after('date_boarding');
            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }
}
