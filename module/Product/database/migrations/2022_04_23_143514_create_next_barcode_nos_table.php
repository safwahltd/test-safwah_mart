<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextBarcodeNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('next_barcode_nos')) {
            Schema::create('next_barcode_nos', function (Blueprint $table) {
                $table->id();
                $table->integer('next_no');
                $table->timestamps();
            });
       }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('next_barcode_nos');
    }
}
