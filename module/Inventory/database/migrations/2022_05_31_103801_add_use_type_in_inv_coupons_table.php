<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUseTypeInInvCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_coupons', function (Blueprint $table) {
            $table->string('use_type')->nullable()->default('Once')->after('id')->comment('Once or Multiple');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_coupons', function (Blueprint $table) {
            $table->dropColumn('use_type');
        });
    }
}
