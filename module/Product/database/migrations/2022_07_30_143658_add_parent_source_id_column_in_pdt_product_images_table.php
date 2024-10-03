<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentSourceIdColumnInPdtProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_images', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_source_id')->nullable()->after('id');
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
            $table->foreign('parent_source_id')->references('id')->on('pdt_product_images')->onDelete('cascade');
        });
    }
}
