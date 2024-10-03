<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeightInInvOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_details', function (Blueprint $table) {
            $table->decimal('weight', 10, 2)->nullable()->default(0)->after('total_amount')->comment('Weight in kg (Total weight of this product)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_order_details', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
}
