<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrandTotalVirtualizationInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->dropColumn('grand_total');
        });

        Schema::table('inv_orders', function (Blueprint $table) {
            $table->decimal('total_cod_charge', 10, 2)->nullable()->default(0)->after('shipping_cost');
            $table->decimal('grand_total', 10, 2)->virtualAs('subtotal + total_vat_amount + total_shipping_cost + total_cod_charge - total_discount_amount - coupon_discount_amount - point_amount - wallet_amount')->after('wallet_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            //
        });
    }
}
