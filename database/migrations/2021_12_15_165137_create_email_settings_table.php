<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {

            $table->id();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('mail_mailer');
            $table->string('mail_host');
            $table->string('mail_port');
            $table->string('mail_encryption');
            $table->string('mail_username');
            $table->string('mail_password');
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
        Schema::dropIfExists('email_settings');
    }
}
