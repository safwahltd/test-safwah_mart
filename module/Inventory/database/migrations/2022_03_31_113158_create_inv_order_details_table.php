<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_order_details', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->decimal('purchase_price', 16, 6)->nullable()->default(0);
            $table->decimal('sale_price', 16, 6)->nullable()->default(0);
            $table->decimal('quantity', 16, 6)->nullable()->default(0);
            $table->decimal('vat_percent', 16, 6)->nullable()->default(0);
            $table->decimal('vat_amount', 16, 6)->nullable()->default(0);
            $table->decimal('discount_percent', 16, 6)->nullable()->default(0);
            $table->decimal('discount_amount', 16, 6)->nullable()->default(0);
            $table->decimal('total_cost', 16, 6)->virtualAs('purchase_price * quantity');
            $table->decimal('total_amount', 16, 6)->virtualAs('sale_price * quantity + vat_amount - discount_amount');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('inv_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('pdt_products');
            $table->foreign('product_variation_id')->references('id')->on('pdt_product_variations');
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
        Schema::dropIfExists('inv_order_details');
    }
}
