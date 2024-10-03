<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatAndVatTypeColumnToPdtProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_products', function (Blueprint $table) {
            $table->decimal('vat', 16, 6)->nullable()->default(0)->after('manufacture_model_no');
            $table->string('vat_type')->nullable()->comment('Percentage or Flat')->after('vat');
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
            $table->dropColumn('vat');
            $table->dropColumn('vat_type');
        });
    }
}
