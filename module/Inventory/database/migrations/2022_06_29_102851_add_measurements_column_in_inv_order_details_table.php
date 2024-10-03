<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeasurementsColumnInInvOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_order_details', function (Blueprint $table) {
            $table->string('measurement_title')->nullable()->after('product_variation_id');
            $table->string('measurement_sku')->nullable()->after('measurement_title');
            $table->decimal('measurement_value', 10, 2)->nullable()->default(0)->after('measurement_sku');
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
            $table->dropColumn('measurement_title');
            $table->dropColumn('measurement_sku');
            $table->dropColumn('measurement_value');
        });
    }
}
