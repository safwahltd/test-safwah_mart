<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('image')->nullable()->default('default.png');
            $table->integer('country_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('overseas_agent')->nullable();
            $table->string('coupon')->nullable();
            $table->text('address')->nullable();

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyers');
    }
}
