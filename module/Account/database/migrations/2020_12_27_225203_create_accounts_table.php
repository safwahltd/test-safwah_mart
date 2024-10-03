<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('account_group_id')->nullable();
            $table->unsignedBigInteger('account_control_id')->nullable();
            $table->unsignedBigInteger('account_subsidiary_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->enum('balance_type', ['Debit', 'Credit'])->nullable();
            $table->decimal('opening_balance',  15)->default(0);
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deletable')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('account_group_id')->references('id')->on('account_groups');
            $table->foreign('account_control_id')->references('id')->on('account_controls');
            $table->foreign('account_subsidiary_id')->references('id')->on('account_subsidiaries');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
