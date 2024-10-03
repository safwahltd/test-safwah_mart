<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDamageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_damage_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('damage_id')->nullable();
            $table->unsignedBigInteger('product_id');
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
        Schema::dropIfExists('acc_damage_details');
    }
}
