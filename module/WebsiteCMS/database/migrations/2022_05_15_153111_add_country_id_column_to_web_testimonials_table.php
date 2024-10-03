<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdColumnToWebTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_testimonials', function (Blueprint $table) {

            $table->unsignedBigInteger('country_id')->nullable()->after('id');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

          });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
