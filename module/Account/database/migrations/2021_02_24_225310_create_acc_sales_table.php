<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('acc_customers')) {
           
            Schema::create('acc_customers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('mobile')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->decimal('opening_balance', 16, 2)->default(0);
                $table->decimal('current_balance', 16, 2)->default(0);
                $table->unsignedBigInteger('account_id')->nullable();
                $table->unsignedBigInteger('company_id')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->decimal('previous_due')->default(0);
            
                
                $table->timestamps();

                $table->foreign('account_id')->references('id')->on('accounts');
                $table->foreign('company_id')->references('id')->on('companies');
                $table->foreign('created_by')->references('id')->on('users');
                $table->foreign('updated_by')->references('id')->on('users');
            }); 
        }

        Schema::create('acc_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
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

            if (Schema::hasTable('acc_customers')) {
                $table->foreign('customer_id')->references('id')->on('acc_customers');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_sales');
    }
}
