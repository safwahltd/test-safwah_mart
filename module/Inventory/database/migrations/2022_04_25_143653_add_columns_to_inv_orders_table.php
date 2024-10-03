<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('cuppon_id')->nullable()->after('total_discount_amount');
            $table->decimal('cuppon_discount_amount',12,4)->nullable()->after('cuppon_id');

            $table->foreign('cuppon_id')->references('id')->on('inv_cuppons');

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
