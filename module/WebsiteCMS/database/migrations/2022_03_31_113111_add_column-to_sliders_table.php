<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('button_title')->nullable();
            $table->string('button_icon')->nullable();
            $table->string('button_url')->nullable();
            $table->tinyInteger('button_status')->nullable();
          });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('button_title');
            $table->dropColumn('button_icon');
            $table->dropColumn('button_url');
            $table->dropColumn('button_status');
          });
       }
}
