<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInOfferColumnInPdtProductDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_discounts', function (Blueprint $table) {
            $table->tinyInteger('show_in_offer')->nullable()->default(1)->comment('0 = No, 1 = Yes')->after('end_date');
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
            $table->dropColumn('show_in_offer');
        });
    }
}
