<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAffiliateColumnsToInvOrdersTable extends Migration
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
            $table->dropColumn('affiliate_code');
            $table->dropColumn('affiliate_discount');
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
