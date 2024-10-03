<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('invoice_no')->unique();
            $table->date('date');
            $table->string('type')->comment('POS, Ecommerce');
            $table->decimal('total_quantity', 16, 6)->nullable()->default(0);
            $table->decimal('total_cost', 16, 6)->nullable()->default(0);
            $table->decimal('subtotal', 16, 6)->nullable()->default(0);
            $table->decimal('total_vat_percent', 16, 6)->nullable()->default(0);
            $table->decimal('total_vat_amount', 16, 6)->nullable()->default(0);
            $table->decimal('total_discount_percent', 16, 6)->nullable()->default(0);
            $table->decimal('total_discount_amount', 16, 6)->nullable()->default(0);
            $table->decimal('rounding', 16, 6)->nullable()->default(0);
            $table->decimal('payable_amount', 16, 6)->nullable()->default(0);
            $table->decimal('paid_amount', 16, 6)->nullable()->default(0);
            $table->decimal('due_amount', 16, 6)->nullable()->default(0);
            $table->decimal('change_amount', 16, 6)->nullable()->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('customer_id')->references('id')->on('inv_customers');
            $table->foreign('order_id')->references('id')->on('inv_orders');
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
        Schema::dropIfExists('inv_sales');
    }
}
