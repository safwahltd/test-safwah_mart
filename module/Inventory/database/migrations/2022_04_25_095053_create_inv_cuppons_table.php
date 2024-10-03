<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvCupponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_cuppons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('discount_type');
            $table->decimal('rate', 12, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('is_highlight')->nullable()->comment('Yes, No');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('inv_cuppons');
    }
}
