<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvOrderAmountWiseShippingCostDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_order_amount_wise_shipping_cost_discounts', function (Blueprint $table) {
            $table->id();
            $table->decimal('from_amount', 10, 2);
            $table->decimal('to_amount', 10, 2);
            $table->decimal('discount')->default(0);
            $table->tinyInteger('status')->default(1);

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_order_amount_wise_shipping_cost_discounts');
    }
}
