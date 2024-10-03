<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInQuickLinksColumnInWebPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_pages', function (Blueprint $table) {
            $table->tinyInteger('show_in_quick_links')->nullable()->default(0)->after('is_default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_pages', function (Blueprint $table) {
            $table->dropColumn('show_in_quick_links');
        });
    }
}
