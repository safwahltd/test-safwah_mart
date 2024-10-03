<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvWeightWiseExtraShippingCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_weight_wise_extra_shipping_costs', function (Blueprint $table) {
            $table->id();
            $table->decimal('from_weight')->comment('weight in kg');
            $table->decimal('to_weight')->comment('weight in kg');
            $table->decimal('extra_cost')->default(0);
            $table->tinyInteger('status')->default(1);

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_weight_wise_extra_shipping_costs');
    }
}
