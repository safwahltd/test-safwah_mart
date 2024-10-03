<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSubsidiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_subsidiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('account_group_id')->nullable();
            $table->unsignedBigInteger('account_control_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deletable')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('account_group_id')->references('id')->on('account_groups');
            $table->foreign('account_control_id')->references('id')->on('account_controls');
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
        Schema::dropIfExists('account_subsidiaries');
    }
}
