<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdCardSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_card_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->longText('address')->nullable();
            $table->string('web_url')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('signature')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('corporate_address')->nullable();
            $table->string('group_logo')->nullable();

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('id_card_settings');
    }
}
