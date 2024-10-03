<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRmreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rmreports')) {
            Schema::create('rmreports', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('company_id');
                $table->unsignedBigInteger('factory_id');
                $table->string('date');
                $table->unsignedBigInteger('unit_id');
                $table->decimal('stock')->default(0);
                $table->decimal('avg_rate');
                $table->timestamps();

                if (!Schema::hasColumn('rmreports', 'stock_in')) {
                    $table->decimal('stock_in')->nullable();
                }


                if (!Schema::hasColumn('rmreports', 'stock_out')) {
                    $table->decimal('stock_out')->nullable();
                }
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
        Schema::dropIfExists('rmreports');
    }
}
