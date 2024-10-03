<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdtProductVariationAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_product_variation_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('attribute_type_id');
            $table->unsignedBigInteger('attribute_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('pdt_products');
            $table->foreign('product_variation_id')->references('id')->on('pdt_product_variations');
            $table->foreign('attribute_type_id')->references('id')->on('pdt_attribute_types');
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
        Schema::dropIfExists('pdt_product_variation_attributes');
    }
}
