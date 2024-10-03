<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExistInReturnColumnInInvOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_details', function (Blueprint $table) {
            $table->tinyInteger('exist_in_return')->nullable()->default(0)->after('weight')->comment('0 mean No, 1 mean Yes');
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
            $table->dropColumn('exist_in_return');
        });
    }
}
