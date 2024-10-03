<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvOrderEmailSmsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_order_email_sms_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('is_sent_email')->nullable()->comment('Yes,No');
            $table->string('is_sent_sms')->nullable()->comment('Yes,No');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('inv_orders');

        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_order_email_message_statuses');
    }
}
