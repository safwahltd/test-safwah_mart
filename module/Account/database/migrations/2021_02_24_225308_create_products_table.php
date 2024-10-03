<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
                
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
            });
        }


        Schema::table('products', function (Blueprint $table) {
            
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
            }
            if (!Schema::hasColumn('products', 'unit_id')) {
                $table->unsignedBigInteger('unit_id')->nullable();
            }
            if (!Schema::hasColumn('products', 'name')) {
                $table->string('name')->nullable();
            }

            if (!Schema::hasColumn('products', 'product_type')) {
                $table->string('product_type', 16, 2)->default(0)->nullable();
            }

            if (!Schema::hasColumn('products', 'product_code')) {
                $table->string('product_code')->default(0)->nullable();
            } else {
                $table->string('product_code', 255)->default(0)->nullable()->change();
            }
            
            if (!Schema::hasColumn('products', 'purchase_price')) {
                $table->decimal('purchase_price', 16, 2)->default(0)->nullable();
            }
            if (!Schema::hasColumn('products', 'selling_price')) {
                $table->decimal('selling_price', 16, 2)->default(0)->nullable();
            }

            if (!Schema::hasColumn('products', 'opening_quantity')) {
                $table->decimal('opening_quantity', 16, 2)->default(0)->nullable();
            }
            if (!Schema::hasColumn('products', 'current_stock')) {
                $table->decimal('current_stock', 16, 2)->default(0)->nullable();
            }
            if (!Schema::hasColumn('products', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable();
                $table->foreign('company_id')->references('id')->on('companies');
            }
            if (!Schema::hasColumn('products', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->foreign('created_by')->references('id')->on('users');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
