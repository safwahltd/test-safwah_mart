<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdtStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('lot')->nullable();
            $table->date('date');
            $table->morphs('stockable');
            $table->string('stock_type')->comment('In, Out');
            $table->decimal('purchase_price', 16, 6)->nullable()->default(0);
            $table->decimal('sale_price', 16, 6)->nullable()->default(0);
            $table->decimal('quantity', 16, 6)->nullable()->default(0);
            $table->decimal('actual_quantity', 16, 6)->nullable()->default(0);
            $table->decimal('purchase_total', 16, 6)->virtualAs('purchase_price * quantity');
            $table->decimal('subtotal', 16, 6)->virtualAs('sale_price * quantity');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();


            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
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
        Schema::dropIfExists('pdt_stocks');
    }
}
