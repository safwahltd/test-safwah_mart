<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGrnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_grn', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('purchase_id');
            $table->string('invoice_no')->unique();
            $table->date('date');
            $table->string('challan_number');
            $table->string('challan_attachment')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('total_quantity', 16, 6)->nullable()->default(0);
            $table->decimal('total_amount', 16, 6)->nullable()->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('supplier_id')->references('id')->on('acc_suppliers');
            $table->foreign('warehouse_id')->references('id')->on('inv_warehouses');
            $table->foreign('purchase_id')->references('id')->on('inv_purchases');
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
        Schema::dropIfExists('inv_grn');
    }
}
