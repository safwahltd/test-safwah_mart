<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFromInvOrderCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_customer_infos', function (Blueprint $table) {


            $table->dropForeign(['area_id']);
            $table->dropColumn('area_id');
            $table->dropForeign(['district_id']);
            $table->dropColumn('district_id');
            $table->dropForeign(['receiver_area_id']);
            $table->dropColumn('receiver_area_id');
            $table->dropForeign(['receiver_district_id']);
            $table->dropColumn('receiver_district_id');

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
