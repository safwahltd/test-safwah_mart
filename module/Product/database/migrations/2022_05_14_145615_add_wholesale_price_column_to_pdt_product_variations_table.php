<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWholesalePriceColumnToPdtProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_variations', function (Blueprint $table) {
            $table->decimal('wholesale_price', 16, 6)->nullable()->default(0)->after('purchase_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_product_variations', function (Blueprint $table) {
            $table->dropColumn('wholesale_price');
        });
    }
}
