<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalWeightInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->decimal('total_weight', 10, 2)->nullable()->default(0)->comment('Weight in kg');
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
            $table->dropColumn('total_weight');
        });
    }
}
