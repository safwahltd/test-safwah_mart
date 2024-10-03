<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraSaleFieldInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->decimal('paid_amount', 12, 2)->nullable()->default(0)->after('total_weight');
            $table->decimal('due_amount', 12, 2)->nullable()->default(0)->after('paid_amount');
            $table->decimal('change_amount', 12, 2)->nullable()->default(0)->after('due_amount');
            $table->decimal('rounding', 12, 2)->nullable()->default(0)->after('change_amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_orders', function (Blueprint $table) {

            $table->dropColumn('paid_amount');
            $table->dropColumn('due_amount');
            $table->dropColumn('change_amount');
            $table->dropColumn('rounding');
            
        });
    }
}
