<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvProductSupplyRequestAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_product_supply_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_request_id');
            $table->string('attachment');

            $table->timestamps();

            $table->foreign('supply_request_id')->references('id')->on('inv_product_supply_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_product_supply_request_attachments');
    }
}
