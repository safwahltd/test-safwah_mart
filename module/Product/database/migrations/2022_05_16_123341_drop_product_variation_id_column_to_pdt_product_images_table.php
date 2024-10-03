<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropProductVariationIdColumnToPdtProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_images', function (Blueprint $table) {
            $table->dropForeign('pdt_product_variation_images_product_variation_id_foreign');
            $table->dropColumn('product_variation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdt_product_images', function (Blueprint $table) {
            //
        });
    }
}
