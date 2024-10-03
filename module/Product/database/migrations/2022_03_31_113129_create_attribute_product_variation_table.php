<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeProductVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_product_variation', function (Blueprint $table) {

            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('attribute_id');

            $table->foreign('product_variation_id')->references('id')->on('pdt_product_variations')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('pdt_attributes');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_product_variation');
    }
}
