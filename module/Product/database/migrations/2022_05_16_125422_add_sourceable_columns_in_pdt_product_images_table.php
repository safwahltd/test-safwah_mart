<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceableColumnsInPdtProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_product_images', function (Blueprint $table) {
            if (!Schema::hasColumn('pdt_product_images', 'sourcable_type')) {
                $table->string('sourcable_type')->nullable()->after('id');
            }
            
            if (!Schema::hasColumn('pdt_product_images', 'sourcable_id')) {
                $table->unsignedBigInteger('sourcable_id')->nullable()->after('sourcable_type');
            }
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
            $table->dropColumn('sourcable_type');
            $table->dropColumn('sourcable_id');
        });
    }
}
