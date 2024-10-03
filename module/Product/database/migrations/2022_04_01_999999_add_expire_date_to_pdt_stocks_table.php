<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpireDateToPdtStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pdt_stocks', 'expite_date')) {
            Schema::table('pdt_stocks', function (Blueprint $table) {
                $table->date('expite_date')->nullable()->after('date');
            });
        };
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_stocks', function (Blueprint $table) {
            $table->dropColumn('expite_date');
        });
    }
}
