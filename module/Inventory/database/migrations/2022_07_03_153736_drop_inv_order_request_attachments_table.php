<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInvOrderRequestAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_request_attachments', function (Blueprint $table) {
            $table->dropForeign(['order_request_id']);
        });

        Schema::table('inv_order_request_attachments', function (Blueprint $table) {
            $table->drop('inv_order_request_attachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
