<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Module\Permission\Models\Module;

class CreateInvoiceNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('submodules', function (Blueprint $table) {

            $table->dropForeign('submodules_module_id_foreign');

            $table->foreign('module_id')
                    ->references('id')
                    ->on('modules')
                    ->onDelete('cascade');
        });
        
        Schema::table('parent_permissions', function (Blueprint $table) {

            $table->dropForeign('parent_permissions_submodule_id_foreign');

            $table->foreign('submodule_id')
                    ->references('id')
                    ->on('submodules')
                    ->onDelete('cascade');
        });
        
        Schema::table('permissions', function (Blueprint $table) {

            $table->dropForeign('permissions_parent_permission_id_foreign');

            $table->foreign('parent_permission_id')
                    ->references('id')
                    ->on('parent_permissions')
                    ->onDelete('cascade');
        });
        
        Schema::table('permission_user', function (Blueprint $table) {

            $table->dropForeign('permission_user_permission_id_foreign');

            $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');
        });

        Module::where('id', 10)->delete();

        Module::updateOrCreate([
            'id'        => 150000,
            'name'      => 'Account & Finance',
        ], ['status'    => 1]);
        

        Schema::create('invoice_nos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('year');
            $table->unsignedInteger('next_id')->default(1);
            $table->unsignedBigInteger('company_id');
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
        Schema::dropIfExists('invoice_nos');
    }
}
