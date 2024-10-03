<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddCurrentStatusToInvOrdersTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {

            $table->unsignedBigInteger('company_id')->after('id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->after('company_id')->nullable();
            $table->unsignedBigInteger('current_status')->nullable()->after('grand_total');

            
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('current_status')->references('id')->on('inv_statuses');
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
            $table->dropColumn('current_status');
        });
    }
}
