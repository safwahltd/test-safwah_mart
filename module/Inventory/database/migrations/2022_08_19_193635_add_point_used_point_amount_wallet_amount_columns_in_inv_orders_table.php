<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointUsedPointAmountWalletAmountColumnsInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->integer('point_used')->nullable()->default(0)->after('coupon_discount_amount');
            $table->decimal('point_amount', 10, 2)->nullable()->default(0)->after('point_used');
            $table->decimal('wallet_amount', 10, 2)->nullable()->default(0)->after('point_amount');
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
            $table->dropColumn('point_used');
            $table->dropColumn('point_amount');
            $table->dropColumn('wallet_amount');
        });
    }
}
