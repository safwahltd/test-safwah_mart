<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfferIdColumnInPdtProductDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_discounts', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_id')->nullable()->after('id');
            $table->foreign('offer_id')->references('id')->on('pdt_offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_product_discounts', function (Blueprint $table) {
            //
        });
    }
}
