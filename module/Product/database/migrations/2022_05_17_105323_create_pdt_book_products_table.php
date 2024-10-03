<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdtBookProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_book_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('writer_id');
            $table->unsignedBigInteger('publisher_id');
            $table->date('published_at')->nullable();
            $table->string('isbn')->nullable();
            $table->string('edition')->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->string('language')->nullable();
            $table->string('attachment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdt_book_products');
    }
}
