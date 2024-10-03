<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_banners', function (Blueprint $table) {
            $table->renameColumn('slug','url');
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
