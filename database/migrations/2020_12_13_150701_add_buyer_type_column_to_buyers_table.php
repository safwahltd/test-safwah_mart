<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuyerTypeColumnToBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->string('buyer_type')->nullable();
        });
        Schema::table('buyer_uploads', function (Blueprint $table) {
            $table->string('buyer_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn('buyer_type');
        });
        Schema::table('buyer_uploads', function (Blueprint $table) {
            $table->dropColumn('buyer_type');
        });
    }
}
