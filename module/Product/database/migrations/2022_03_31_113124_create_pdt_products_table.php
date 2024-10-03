<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdtProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_type_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_measure_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('purchase_price', 16, 6)->nullable()->default(0);
            $table->decimal('wholesale_price', 16, 6)->nullable()->default(0);
            $table->decimal('sale_price', 16, 6)->nullable()->default(0);
            $table->decimal('weight', 16, 6)->nullable()->default(0);
            $table->string('image')->nullable();
            $table->string('is_variation')->nullable()->comments('Yes, No');
            $table->string('vat_applicable')->nullable()->comments('Yes, No');
            $table->string('is_refundable')->nullable()->comments('Yes, No');
            $table->string('is_highlight')->nullable()->comment('Yes, No');
            $table->string('manufacture_barcode')->nullable();
            $table->string('manufacture_model_no')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('product_type_id')->references('id')->on('pdt_product_types');
            $table->foreign('category_id')->references('id')->on('pdt_categories');
            $table->foreign('brand_id')->references('id')->on('pdt_brands');
            $table->foreign('unit_measure_id')->references('id')->on('pdt_unit_measures');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers');
            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('pdt_products');
    }
}
