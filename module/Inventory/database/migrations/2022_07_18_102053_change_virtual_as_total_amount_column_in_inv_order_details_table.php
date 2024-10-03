<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVirtualAsTotalAmountColumnInInvOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_details', function (Blueprint $table) {
            $table->decimal('total_amount', 16, 6)->virtualAs('sale_price * quantity + vat_amount - discount_amount * quantity')->after('total_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_order_details', function (Blueprint $table) {
            //
        });
    }
}
