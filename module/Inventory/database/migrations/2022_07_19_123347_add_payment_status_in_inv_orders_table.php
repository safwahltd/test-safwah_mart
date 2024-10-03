<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusInInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_orders', function (Blueprint $table) {
            $table->string('payment_status')->nullable()->comment('Pending, Processing, Complete, Canceled, Failed, Partial, Due')->after('payment_tnx_no');
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
            $table->dropColumn('payment_status');
        });
    }
}
