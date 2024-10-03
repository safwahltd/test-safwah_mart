<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInvSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_sales', function (Blueprint $table) {

            $table->unsignedBigInteger('sale_by')->nullable()->after('change_amount');
            $table->decimal('shipping_charge',12,6)->nullable()->default(0)->after('total_cost');

            $table->foreign('sale_by')->references('id')->on('users');

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
