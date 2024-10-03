<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvCustomerinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_customer_infos', function (Blueprint $table) {

            $table->unsignedBigInteger('area_id')->nullable()->after('address');
            $table->unsignedBigInteger('district_id')->nullable()->after('area_id');
            $table->unsignedBigInteger('receiver_area_id')->nullable()->after('receiver_address');
            $table->unsignedBigInteger('receiver_district_id')->nullable()->after('receiver_area_id');

            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('receiver_area_id')->references('id')->on('areas');
            $table->foreign('receiver_district_id')->references('id')->on('districts');
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
