<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarehouseIdColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inv_warehouses')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('warehouse_id')->nullable()->after('company_id');
                $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
