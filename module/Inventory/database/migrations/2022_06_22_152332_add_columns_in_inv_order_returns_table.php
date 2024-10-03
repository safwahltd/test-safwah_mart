<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInInvOrderReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_returns', function (Blueprint $table) {
            $table->string('status')->nullable()->default('Pending')->comment('Pending, Approved, Delivery Start, Delivery Done, Cancelled');
            $table->date('return_date')->nullable();
            $table->unsignedBigInteger('time_slot_id')->nullable();
            $table->unsignedBigInteger('delivery_man_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('approved_at')->nullable();
            $table->date('received_at')->nullable();
            $table->unsignedBigInteger('accepted_by')->nullable();
            $table->date('accepted_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->date('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
            
            $table->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->foreign('delivery_man_id')->references('id')->on('inv_delivery_mans');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_order_returns', function (Blueprint $table) {
            //
        });
    }
}
