<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPdtProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->string('sub_text')->nullable()->after('sku');
            $table->tinyInteger('sub_text_visible')->default(0);
            $table->tinyInteger('stock_visible')->default(0)->after('status');
            $table->string('est_shipping_days')->nullable()->after('manufacture_model_no');
            $table->string('video_link')->nullable()->after('image');
            $table->string('barcode')->nullable()->after('est_shipping_days');
            $table->string('short_description', 500)->nullable()->after('status');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->dropColumn('sub_text');
            $table->dropColumn('sub_text_visible');
            $table->dropColumn('stock_visible');
            $table->dropColumn('est_shipping_days');
            $table->dropColumn('video_link');
            $table->dropColumn('barcode');
            $table->dropColumn('short_description');
        }); 
    }
}
