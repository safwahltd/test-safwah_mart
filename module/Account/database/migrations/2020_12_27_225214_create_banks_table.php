<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('banks')) {
            Schema::create('banks', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
            });
        } 

        if (!Schema::hasColumn('banks', 'name')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->string('name');
            });
        }

        if (!Schema::hasColumn('banks', 'bank_account_no')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->string('bank_account_no')->nullable();
            });
        }

        if (!Schema::hasColumn('banks', 'bank_name')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->string('bank_name')->nullable();
            });
        }

        if (!Schema::hasColumn('banks', 'branch_name')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->string('branch_name')->nullable();
            });
        }

        if (!Schema::hasColumn('banks', 'branch_mobile')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->string('branch_mobile')->nullable();
            });
        }

        if (!Schema::hasColumn('banks', 'branch_email')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->string('branch_email')->nullable();
            });
        }

        if (!Schema::hasColumn('banks', 'branch_address')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->text('branch_address')->nullable();
            });
        }

        if (!Schema::hasColumn('banks', 'company_id')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id');
                $table->foreign('company_id')->references('id')->on('companies');
            });
        }

        if (!Schema::hasColumn('banks', 'created_by')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by');
                $table->foreign('created_by')->references('id')->on('users');

            });
        }

        if (!Schema::hasColumn('banks', 'updated_by')) {
            
            Schema::table('banks', function (Blueprint $table) {
                $table->unsignedBigInteger('updated_by')->nullable();

                $table->foreign('updated_by')->references('id')->on('users');

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
        Schema::dropIfExists('banks');
    }
}
