<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponColumnsToInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->nullable()->after('delivery_man_id');
            $table->decimal('coupon_discount_amount', 10, 2)->nullable()->default(0)->after('total_discount_amount');

            $table->foreign('coupon_id')->references('id')->on('inv_coupons');
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
