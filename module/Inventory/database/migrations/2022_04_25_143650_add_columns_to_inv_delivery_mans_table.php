<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInvDeliveryMansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_delivery_mans', function (Blueprint $table) {
            $table->unsignedBigInteger('area_id')->nullable()->after('id');
            $table->unsignedBigInteger('district_id')->nullable()->after('id');

            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('district_id')->references('id')->on('districts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
