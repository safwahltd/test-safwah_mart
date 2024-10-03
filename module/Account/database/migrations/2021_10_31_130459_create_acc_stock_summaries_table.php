<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccStockSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_stock_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->float('opening_qty')->nullable()->default(0);
            $table->float('purchase_qty')->nullable()->default(0);
            $table->float('sale_qty')->nullable()->default(0);
            $table->float('issue_qty')->nullable()->default(0);
            $table->float('purchase_return_qty')->nullable()->default(0);
            $table->float('sale_return_qty')->nullable()->default(0);
            $table->float('transfer_in_qty')->nullable()->default(0);
            $table->float('transfer_out_qty')->nullable()->default(0);
            $table->float('available_qty')->virtualAs('opening_qty + purchase_qty + purchase_return_qty + sale_return_qty + transfer_in_qty - sale_qty - issue_qty - transfer_out_qty');
            $table->decimal('total_amount', 15);
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
        Schema::dropIfExists('acc_stock_summaries');
    }
}
