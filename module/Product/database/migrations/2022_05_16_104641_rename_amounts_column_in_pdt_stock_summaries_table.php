<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAmountsColumnInPdtStockSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_stock_summaries', function (Blueprint $table) {
            $table->renameColumn('stock_in_amount', 'stock_in_value');
            $table->renameColumn('stock_out_amount', 'stock_out_value');
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
