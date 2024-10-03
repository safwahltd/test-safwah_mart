<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_purchase_return_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_return_id')->nullable();
            $table->unsignedBigInteger('purchase_detail_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('product_type')->default('Good')->comment('Good, Damage');
            $table->decimal('quantity', 20, 2)->default(0);
            $table->decimal('price', 20, 2)->default(0);
            $table->decimal('subtotal', 20, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_purchase_return_details');
    }
}
