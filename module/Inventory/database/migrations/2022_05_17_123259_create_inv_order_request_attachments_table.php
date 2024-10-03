<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvOrderRequestAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_order_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_request_id');
            $table->string('attachment');

            $table->timestamps();

            $table->foreign('order_request_id')->references('id')->on('inv_order_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_order_request_attachments');
    }
}
