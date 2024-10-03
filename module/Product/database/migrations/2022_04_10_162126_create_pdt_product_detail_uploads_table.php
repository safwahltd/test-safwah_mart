<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdtProductDetailUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_product_detail_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_upload_id');
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('purchase_price', 16, 6)->default(0);
            $table->decimal('sale_price', 16, 6)->default(0);
            $table->decimal('opening_stock', 10, 2)->default(0);
            $table->integer('warehouse_id')->default(1);
            $table->timestamps();

            $table->foreign('product_upload_id')->references('id')->on('pdt_product_uploads')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdt_product_detail_uploads');
    }
}
