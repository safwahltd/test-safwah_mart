<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('order_detail_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('lot')->nullable();
            $table->decimal('purchase_price', 16, 6)->nullable()->default(0);
            $table->decimal('sale_price', 16, 6)->nullable()->default(0);
            $table->decimal('quantity', 16, 6)->nullable()->default(0);
            $table->decimal('vat_percent', 16, 6)->nullable()->default(0);
            $table->decimal('vat_amount', 16, 6)->nullable()->default(0);
            $table->decimal('discount_percent', 16, 6)->nullable()->default(0);
            $table->decimal('discount_amount', 16, 6)->nullable()->default(0);
            $table->decimal('total_purchase_cost', 16, 6)->virtualAs('purchase_price * quantity');
            $table->decimal('total_amount', 16, 6)->virtualAs('sale_price * quantity + vat_amount - discount_amount');
            $table->timestamps();

            $table->foreign('sale_id')->references('id')->on('inv_sales')->onDelete('cascade');
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
        Schema::dropIfExists('inv_sale_details');
    }
}
