<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatAndVatTypeColumnToPdtCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdt_categories', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('title');
            $table->decimal('vat', 16, 6)->nullable()->default(0)->after('show_on_menu');
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
        Schema::table('pdt_categories', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('vat');
            $table->dropColumn('vat_type');
        });
    }
}
