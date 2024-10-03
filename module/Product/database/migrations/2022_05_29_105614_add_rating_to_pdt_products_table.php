<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatingToPdtProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->decimal('avg_rating')->after('sub_text')->default(0);
            $table->integer('total_rating_user')->after('avg_rating')->default(0);
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->dropColumn('avg_rating');
            $table->dropColumn('total_rating_user');
        });
    }
}
