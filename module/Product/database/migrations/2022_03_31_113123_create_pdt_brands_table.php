<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdtBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdt_brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->text('logo')->nullable();
            $table->string('is_highlight')->nullable()->comment('Yes,No');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('product_type_id')->references('id')->on('pdt_product_types');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdt_brands');
    }
}
