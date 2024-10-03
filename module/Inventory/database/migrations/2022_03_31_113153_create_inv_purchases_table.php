<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('type')->default('Direct')->comment('Direct, Procedure. If Purchase Type is Direct it means it does not create PO and PI related informations and Status will be use (Pending, Approved & Received).');
            $table->date('date');
            $table->date('p_o_date')->nullable();
            $table->date('p_i_date')->nullable();
            $table->date('supplier_p_i_date')->nullable();
            $table->date('verified_at')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('invoice_no')->unique();
            $table->string('p_o_no')->unique()->nullable();
            $table->string('p_i_no')->unique()->nullable();
            $table->string('supplier_p_i_no')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->comment('Pending, PO Pending, PI Pending, Verified, Approved, Received, Cancelled');
            $table->decimal('total_quantity', 16, 6)->nullable()->default(0);
            $table->decimal('subtotal', 16, 6)->nullable()->default(0);
            $table->decimal('total_discount_percent', 16, 6)->nullable()->default(0);
            $table->decimal('total_discount_amount', 16, 6)->nullable()->default(0);
            $table->decimal('payable_amount', 16, 6)->nullable()->default(0);
            $table->decimal('paid_amount', 16, 6)->nullable()->default(0);
            $table->decimal('due_amount', 16, 6)->nullable()->default(0);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('p_o_created_by')->nullable();
            $table->unsignedBigInteger('p_i_created_by')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();


            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('p_o_created_by')->references('id')->on('users');
            $table->foreign('p_i_created_by')->references('id')->on('users');
            $table->foreign('verified_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
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
        Schema::dropIfExists('inv_purchases');
    }
}
