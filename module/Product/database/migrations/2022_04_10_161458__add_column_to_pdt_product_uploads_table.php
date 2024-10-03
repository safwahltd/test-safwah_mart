<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPdtProductUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_uploads', function (Blueprint $table) {
       
            $table->decimal('wholesale_price', 16, 6)->nullable()->after('purchase_price')->default(0);
            $table->decimal('alert_quantity', 16, 6)->after('sale_price')->nullable()->default(0);
            $table->decimal('maximum_order_quantity', 16, 6)->nullable()->after('alert_quantity')->default(0);
            $table->string('video_link')->nullable()->after('maximum_order_quantity');
            $table->string('manufacture_barcode')->nullable()->after('video_link');
            $table->string('manufacture_model_no')->nullable()->after('manufacture_barcode');
            $table->string('est_shipping_days')->nullable()->after('manufacture_model_no');
            $table->string('barcode')->nullable()->after('est_shipping_days');
            $table->decimal('vat', 16, 6)->nullable()->after('barcode');
            $table->string('vat_type')->nullable()->after('vat');
            $table->string('sku')->nullable()->after('vat_type');
            $table->string('stock_visible')->nullable()->after('sku');


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
