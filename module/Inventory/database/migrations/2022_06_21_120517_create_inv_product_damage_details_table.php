<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvProductDamageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_product_damage_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_damage_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->default(0);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('vat_percent', 10, 2)->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('discount_percent', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->nullable()->virtualAs('purchase_price * quantity');
            $table->decimal('total_amount', 10, 2)->nullable()->virtualAs('sale_price * quantity + vat_amount - discount_amount');
            $table->decimal('weight', 10, 2)->default(0);
            $table->string('condition')->nullable()->comment('Damaged, Expired');
            $table->timestamps();
            
            $table->foreign('product_damage_id')->references('id')->on('inv_product_damages');
            $table->foreign('product_id')->references('id')->on('pdt_products');
            $table->foreign('product_variation_id')->references('id')->on('pdt_product_variations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_product_damage_details');
    }
}
