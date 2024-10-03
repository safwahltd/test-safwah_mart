<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvOrderReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_order_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('return_reason_id')->nullable();
            $table->string('invoice_no');
            $table->date('date');
            $table->decimal('total_quantity', 10, 2)->default(0);
            $table->decimal('total_weight', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('note')->nullable();

            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('order_id')->references('id')->on('inv_orders');
            $table->foreign('customer_id')->references('id')->on('acc_customers');
            $table->foreign('return_reason_id')->references('id')->on('inv_return_reasons');
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
        Schema::dropIfExists('inv_order_returns');
    }
}
