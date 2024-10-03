<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStockTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_transections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('factory_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('source_type');
            $table->integer('source_id');
            $table->string('date'); //<----Source Date
            $table->decimal('quantity', 16, 2)->default(0);
            $table->decimal('price', 16, 2)->default(0);
            $table->decimal('amount', 16, 2)->virtualAs('quantity * price');
            $table->enum('stock_type', ['In', 'Out']);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('CASCADE');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
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
        Schema::dropIfExists('product_stock_transections');
    }
}
