<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpireDateColumnToPdtStockSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_stock_summaries', function (Blueprint $table) {
            $table->date('expire_date')->nullable()->after('lot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_stock_summaries', function (Blueprint $table) {
            $table->dropColumn('expire_date');
        });
    }
}
