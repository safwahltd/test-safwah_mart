<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlertQuantityAndMaximumOrderQuantityColumnsToPdtProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->decimal('alert_quantity', 16, 6)->nullable()->default(0)->after('weight');
            $table->decimal('maximum_order_quantity', 16, 6)->nullable()->default(0)->after('alert_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->dropColumn('alert_quantity');
            $table->dropColumn('maximum_order_quantity');
        });
    }
}
