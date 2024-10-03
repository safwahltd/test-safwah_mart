<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWebContactsTable extends Migration
{

    public function up()
    {
        Schema::table('web_contacts', function (Blueprint $table) {
            $table->string('subject')->after('phone')->nullable();
            $table->dropColumn('is_replied');
        });
    }


    public function down()
    {
        Schema::dropIfExists('web_contacts');
    }
}
