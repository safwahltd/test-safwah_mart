<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAccCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_customers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_type_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('register_from')->nullable()->comment("Showroom, Website, Both");
            $table->string('gender', 255)->nullable()->comment("Male, Female, Others");
            $table->tinyInteger('is_default')->nullable()->default(0);
            $table->string('country')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('zip_code')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_type_id')->references('id')->on('acc_customer_types');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_customers', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('customer_type_id');
            $table->dropColumn('warehouse_id');
            $table->dropColumn('register_from');
            $table->dropColumn('gender');
            $table->dropColumn('is_default');
            $table->dropColumn('country');
            $table->dropColumn('district_id');
            $table->dropColumn('area_id');
            $table->dropColumn('zip_code');
            $table->dropColumn('status');
        });
    }
}
