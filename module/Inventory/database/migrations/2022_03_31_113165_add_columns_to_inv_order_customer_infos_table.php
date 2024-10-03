<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInvOrderCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_customer_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('area_id')->after('address');
            $table->unsignedBigInteger('district_id')->after('area_id');
            $table->unsignedBigInteger('receiver_area_id')->after('receiver_address');
            $table->unsignedBigInteger('receiver_district_id')->after('receiver_area_id');

            $table->foreign('area_id')->references('id')->on('inv_sales')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('inv_sales')->onDelete('cascade');
            $table->foreign('receiver_area_id')->references('id')->on('inv_sales')->onDelete('cascade');
            $table->foreign('receiver_district_id')->references('id')->on('inv_sales')->onDelete('cascade');

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
