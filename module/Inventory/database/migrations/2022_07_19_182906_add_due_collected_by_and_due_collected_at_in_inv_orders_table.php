<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDueCollectedByAndDueCollectedAtInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('due_collected_by')->nullable()->after('current_status');
            $table->date('due_collected_at')->nullable()->after('due_collected_by');

            $table->foreign('due_collected_by')->references('id')->on('users');
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
