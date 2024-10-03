<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdtProductUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_product_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('product_type');
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('unit_measure')->nullable();
            $table->string('supplier')->nullable();
            $table->string('country')->nullable();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->decimal('purchase_price', 16, 6)->nullable()->default(0);
            $table->decimal('sale_price', 16, 6)->nullable()->default(0);
            $table->decimal('weight', 16, 6)->nullable()->default(0);
            $table->string('is_variation')->nullable()->comments('Yes, No');
            $table->string('vat_applicable')->nullable()->comments('Yes, No');
            $table->string('is_refundable')->nullable()->comments('Yes, No');
            $table->string('is_highlight')->nullable()->comment('Yes, No');
            $table->string('opening_quantity')->nullable();
            $table->integer('warehouse_id')->nullable();
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
        Schema::dropIfExists('pdt_product_uploads');
    }
}
