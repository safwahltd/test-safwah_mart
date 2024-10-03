<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialDiscountColumnToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            //
             $table->double("special_discount")->after("total_discount_amount")->default(0);

            $table->dropColumn("grand_total");
        });
        Schema::table('inv_orders', function (Blueprint $table) {

            $table->decimal('grand_total', 10, 2)->virtualAs('subtotal + total_vat_amount + total_shipping_cost + total_cod_charge - total_discount_amount - coupon_discount_amount - point_amount - wallet_amount - special_discount')->after('wallet_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
