<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGrnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_grn_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grn_id');
            $table->unsignedBigInteger('purchase_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('lot')->nullable();
            $table->decimal('purchase_price', 16, 6)->nullable()->default(0);
            $table->decimal('quantity', 16, 6)->nullable()->default(0);
            $table->decimal('amount', 16, 6)->nullable()->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('grn_id')->references('id')->on('inv_grn')->onDelete('cascade');
            $table->foreign('purchase_detail_id')->references('id')->on('inv_purchase_details');
            $table->foreign('product_id')->references('id')->on('pdt_products');
            $table->foreign('product_variation_id')->references('id')->on('pdt_product_variations');
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
        Schema::dropIfExists('inv_grn_details');
    }
}
