<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPdtBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_brands', function (Blueprint $table) {
            $table->integer('position')->after('logo')->nullable();
            $table->string('meta_title')->after('position')->nullable();
            $table->string('meta_description')->after('meta_title')->nullable();

        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('pdt_brands', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
}
