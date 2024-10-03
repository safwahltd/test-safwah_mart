<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxPriceDiscountToInvCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_coupons', function (Blueprint $table) {
            $table->decimal('max_price_discount', 16, 2)->default(0.00)->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_coupons', function (Blueprint $table) {
            $table->dropColumn(['max_price_discount']);
        });
    }
}
