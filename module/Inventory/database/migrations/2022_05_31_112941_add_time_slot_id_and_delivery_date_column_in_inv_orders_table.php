<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeSlotIdAndDeliveryDateColumnInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('time_slot_id')->nullable()->after('delivery_man_id');
            $table->date('delivery_date')->nullable()->after('date');

            $table->foreign('time_slot_id')->references('id')->on('time_slots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            //
        });
    }
}
