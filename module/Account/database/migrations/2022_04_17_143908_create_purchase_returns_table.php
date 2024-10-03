<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_purchase_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->string('invoice_no')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->decimal('total_return_amount', 20, 2)->default(0);
            $table->decimal('total_exchange_amount', 20, 2)->default(0);
            $table->decimal('total_amount', 20, 2)->default(0);
            $table->decimal('total_discount', 20, 2)->default(0);
            $table->decimal('total_payable', 20, 2)->default(0);
            $table->decimal('total_paid_amount', 20, 2)->default(0);
            $table->decimal('total_due_amount', 20, 2)->default(0);

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_purchase_returns');
    }
}
