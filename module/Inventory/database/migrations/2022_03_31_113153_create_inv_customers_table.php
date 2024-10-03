<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('reffered_by')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('type')->nullable()->comment("Showroom, Ecommerce, Both");
            $table->string('name', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('gender', 255)->nullable()->comment("Male, Female, Others");
            $table->string('country', 255)->nullable();
            $table->text('address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->tinyInteger('is_default')->default(0);
            $table->decimal('opening_balance', 16, 6)->nullable()->default(0);
            $table->decimal('current_balance', 16, 6)->nullable()->default(0);
            $table->tinyInteger('status')->default(1)->comment("0 = Inactive, 1 = Active");
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reffered_by')->references('id')->on('users');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
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
        Schema::dropIfExists('inv_customers');
    }
}
