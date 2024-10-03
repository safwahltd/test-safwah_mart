<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('vat_no')->nullable();
            $table->string('facsimile_number')->nullable();
            $table->string('bonded_license')->nullable();
            $table->string('membership_number')->nullable();
            $table->string('bkmea_reg_no')->nullable();
            $table->string('import_reg_certi')->nullable();
            $table->string('export_reg_certi')->nullable();
            $table->string('epb_reg_no')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_details');
    }
}
