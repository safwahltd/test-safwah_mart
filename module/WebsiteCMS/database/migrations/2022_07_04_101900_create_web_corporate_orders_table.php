<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebCorporateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('web_corporate_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('institution_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->longText('description')->nullable();
            $table->string('attachment')->nullable();

            $table->tinyInteger('status')->default(1);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }


    public function down()
    {
        Schema::dropIfExists('web_corporate_orders');
    }
}
