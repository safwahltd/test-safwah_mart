<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('transactionable_type');
            $table->unsignedBigInteger('transactionable_id');
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('acc_customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_wallet_transactions');
    }
}
