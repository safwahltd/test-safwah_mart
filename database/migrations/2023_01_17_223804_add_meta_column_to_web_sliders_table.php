<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaColumnToWebSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_sliders', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('alt_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_sliders', function (Blueprint $table) {
            //
        });
    }
}
