<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointAndWalletColumnInAccCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_customers', function (Blueprint $table) {
            $table->decimal('point', 10, 2)->nullable()->default(0);
            $table->decimal('wallet', 10, 2)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_customers', function (Blueprint $table) {
            $table->dropColumn('point');
            $table->dropColumn('wallet');
        });
    }
}
