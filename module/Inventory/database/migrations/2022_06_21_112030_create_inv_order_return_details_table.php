<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvOrderReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_order_return_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_return_id');
            $table->unsignedBigInteger('order_detail_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->default(0);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('vat_percent', 10, 2)->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('discount_percent', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->nullable()->virtualAs('purchase_price * quantity');
            $table->decimal('total_amount', 10, 2)->nullable()->virtualAs('sale_price * quantity + vat_amount - discount_amount');
            $table->decimal('weight', 10, 2)->default(0);
            $table->string('return_type')->nullable()->comment('Damaged, Expired, Good');
            $table->timestamps();
            
            $table->foreign('order_return_id')->references('id')->on('inv_order_returns');
            $table->foreign('order_detail_id')->references('id')->on('inv_order_details');
            $table->foreign('product_id')->references('id')->on('pdt_products');
            $table->foreign('product_variation_id')->references('id')->on('pdt_product_variations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_order_return_details');
    }
}
