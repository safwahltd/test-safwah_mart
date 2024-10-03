<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->morphs('transactionable');
                $table->timestamps();
            });
        } 

        if (!Schema::hasColumn('transactions', 'invoice_no')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('invoice_no')->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'date')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('date');
            });
        }

        if (!Schema::hasColumn('transactions', 'redirect_path')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('redirect_path')->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'balance_type')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('balance_type')->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'account_id')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('account_id');
                $table->foreign('account_id')->references('id')->on('accounts');
            });
        }

        if (!Schema::hasColumn('transactions', 'amount')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->decimal('amount', 15);
            });
        }

        if (!Schema::hasColumn('transactions', 'created_by')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by');
                $table->foreign('created_by')->references('id')->on('users');
            });
        }

        if (!Schema::hasColumn('transactions', 'company_id')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id');
                $table->foreign('company_id')->references('id')->on('companies');
            });
        }

        if (!Schema::hasColumn('transactions', 'updated_by')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->foreign('updated_by')->references('id')->on('users');
            });
        }

        if (!Schema::hasColumn('transactions', 'description')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('description')->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'transaction_item_type')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('transaction_item_type')->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'batch_id')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('batch_id')->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'debit_amount')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->decimal('debit_amount', 16, 4)->default(0)->nullable();
            });
        }

        if (!Schema::hasColumn('transactions', 'credit_amount')) {
            
            Schema::table('transactions', function (Blueprint $table) {
                $table->decimal('credit_amount', 16, 4)->default(0)->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}