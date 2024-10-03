<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraShippingCostAndShippingCostDiscountColumnInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('extra_shipping_cost_id')->nullable()->after('shipping_cost');
            $table->decimal('extra_shipping_cost_amount', 10, 2)->nullable()->default(0)->after('extra_shipping_cost_id');

            $table->unsignedBigInteger('shipping_cost_discount_id')->nullable()->after('extra_shipping_cost_amount');
            $table->decimal('shipping_cost_discount_amount', 10, 2)->nullable()->default(0)->after('shipping_cost_discount_id');

            $table->decimal('total_shipping_cost', 10, 2)->virtualAs('shipping_cost + extra_shipping_cost_amount - shipping_cost_discount_amount')->after('shipping_cost_discount_amount');
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
            $table->dropColumn('extra_shipping_cost_id');
            $table->dropColumn('extra_shipping_cost_amount');
            $table->dropColumn('shipping_cost_discount_id');
            $table->dropColumn('shipping_cost_discount_amount');
        });
    }
}
