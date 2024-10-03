<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameExpiteDateColumnToExpireDateInPdtStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_stocks', function (Blueprint $table) {

            $table->renameColumn('expite_date', 'expire_date');
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
