<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('purchase_id');
            $table->string('invoice_no')->nullable();
            $table->string('date');
            $table->enum('balance_type', ['Debit', 'Credit']);
            $table->unsignedBigInteger('account_id')->nullable();
            $table->decimal('amount', 15);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('acc_suppliers')->onDelete('CASCADE');
            $table->foreign('purchase_id')->references('id')->on('acc_purchases')->onDelete('CASCADE');
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('supplier_ledgers');
    }
}
