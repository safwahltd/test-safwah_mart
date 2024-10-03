<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDistrictsAndAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->decimal('free_delivery_amount', 10, 2)->nullable()->after('shipping_cost');
            $table->decimal('min_purchase_amount', 10, 2)->nullable()->after('shipping_cost');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->decimal('free_delivery_amount', 10, 2)->nullable()->after('name');
            $table->decimal('min_purchase_amount', 10, 2)->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
