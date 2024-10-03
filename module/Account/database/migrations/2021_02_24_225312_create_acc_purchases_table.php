<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('date');
            $table->string('invoice_no')->unique();

            $table->decimal('qty_total', 16, 2)->default(0);
            $table->decimal('qty_amount', 16, 2)->default(0);

            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('total_amount', 16, 2)->default(0);
            $table->decimal('previous_due', 16, 2)->default(0);
            $table->decimal('payable_amount', 16, 2)->default(0);
            $table->decimal('paid_amount', 16, 2)->default(0);
            $table->decimal('due_amount', 16, 2)->default(0);

            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_purchases');
    }
}
