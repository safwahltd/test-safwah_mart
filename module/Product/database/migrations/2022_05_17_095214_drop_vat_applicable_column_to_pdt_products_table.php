<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropVatApplicableColumnToPdtProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->dropColumn('is_highlight');
            $table->dropColumn('vat_applicable');
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
            //
        });
    }
}
