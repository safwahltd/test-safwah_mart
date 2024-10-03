<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('delivery_man_id')->nullable();
            $table->date('date');
            $table->string('order_no')->unique();
            $table->string('affiliate_code')->nullable();
            $table->string('payment_type')->nullable()->comment('COD, Online');
            $table->string('payment_method')->nullable();
            $table->string('payment_tnx_no')->nullable();
            $table->decimal('total_quantity', 16, 6)->nullable()->default(0);
            $table->decimal('subtotal', 16, 6)->nullable()->default(0);
            $table->decimal('total_vat_amount', 16, 6)->nullable()->default(0);
            $table->decimal('shipping_cost', 16, 6)->nullable()->default(0);
            $table->decimal('affiliate_discount')->nullable();
            $table->decimal('total_discount_amount', 16, 6)->nullable()->default(0);
            $table->decimal('grand_total', 16, 6)->virtualAs('subtotal + total_vat_amount + shipping_cost - affiliate_discount - total_discount_amount');
            $table->string('status')->nullable()->comment('Pending, Confirmed, Delivery on going, Delivered, Return, Cancelled');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('acc_customers');
            $table->foreign('delivery_man_id')->references('id')->on('inv_delivery_mans');
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
        Schema::dropIfExists('inv_orders');
    }
}
