<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplyStatusToInvCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_coupons', function (Blueprint $table) {
            $table->tinyInteger('coupon_apply_status')->default(1)->after('status');
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
            $table->dropColumn(['coupon_apply_status']);
        });
    }
}
