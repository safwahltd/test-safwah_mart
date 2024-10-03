<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdtStockSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_stock_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('lot')->nullable();
            $table->decimal('stock_in_qty', 16, 6)->nullable()->default(0);
            $table->decimal('stock_out_qty', 16, 6)->nullable()->default(0);
            $table->decimal('balance_qty', 16, 6)->virtualAs('stock_in_qty - stock_out_qty');
            $table->decimal('stock_in_amount', 16, 6)->nullable()->default(0);
            $table->decimal('stock_out_amount', 16, 6)->nullable()->default(0);
            $table->decimal('balance_amount', 16, 6)->virtualAs('stock_in_amount - stock_out_amount');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('product_id')->references('id')->on('pdt_products')->onDelete('cascade');
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
        Schema::dropIfExists('pdt_stock_summaries');
    }
}
