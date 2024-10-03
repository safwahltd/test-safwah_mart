<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropVatAndVatTypeColumnsToPdtCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_categories', function (Blueprint $table) {
            $table->dropColumn('vat');
            $table->dropColumn('vat_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_categories', function (Blueprint $table) {
            //
        });
    }
}
