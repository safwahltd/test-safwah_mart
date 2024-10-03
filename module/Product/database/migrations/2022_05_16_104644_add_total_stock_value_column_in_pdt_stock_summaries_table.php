<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalStockValueColumnInPdtStockSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_stock_summaries', function (Blueprint $table) {
            $table->decimal('total_stock_value', 16, 6)->virtualAs('stock_in_value - stock_out_value')->after('stock_out_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_summaries', function (Blueprint $table) {
            //
        });
    }
}
