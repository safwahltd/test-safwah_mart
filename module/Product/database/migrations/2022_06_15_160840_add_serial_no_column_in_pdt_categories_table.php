<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSerialNoColumnInPdtCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_categories', function (Blueprint $table) {
            $table->integer('serial_no')->nullable()->after('show_on_menu');
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
            $table->dropColumn('serial_no');
        });
    }
}
