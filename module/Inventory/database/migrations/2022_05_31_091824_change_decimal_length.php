<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDecimalLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        |-------------------------------------------------------
        |             INVENTORY TABLES
        |-------------------------------------------------------
        */

        if (Schema::hasTable('inv_sale_payments') && Schema::hasColumn('inv_sale_payments', 'amount')) {
            Schema::table('inv_sale_payments', function (Blueprint $table) {
                $table->decimal('amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_sale_details') && Schema::hasColumns('inv_sale_details', ['purchase_price','sale_price', 'quantity','vat_percent','vat_amount','discount_percent','discount_amount'])) {
            Schema::table('inv_sale_details', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('vat_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('vat_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('discount_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('discount_amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_sales') && Schema::hasColumns('inv_sales', ['total_quantity','total_cost','shipping_charge','subtotal','total_vat_percent','total_vat_amount','total_discount_percent','total_discount_amount','rounding','payable_amount','paid_amount','due_amount','change_amount'])) {
            Schema::table('inv_sales', function (Blueprint $table) {
                $table->decimal('total_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_cost', 10, 2)->nullable()->default(0)->change();
                $table->decimal('shipping_charge', 10, 2)->nullable()->default(0)->change();
                $table->decimal('subtotal', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_vat_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_vat_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_discount_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_discount_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('rounding', 10, 2)->nullable()->default(0)->change();
                $table->decimal('payable_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('paid_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('due_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('change_amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_purchase_details') && Schema::hasColumns('inv_purchase_details', ['purchase_price','quantity','received_quantity'])) {
            Schema::table('inv_purchase_details', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('received_quantity', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_purchases') && Schema::hasColumns('inv_purchases', ['total_quantity','subtotal','total_discount_percent','total_discount_amount','payable_amount','paid_amount','due_amount'])) {
            Schema::table('inv_purchases', function (Blueprint $table) {
                $table->decimal('total_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('subtotal', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_discount_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_discount_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('payable_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('paid_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('due_amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_order_details') && Schema::hasColumns('inv_order_details', ['purchase_price','sale_price','quantity','vat_percent','vat_amount','discount_percent','discount_amount'])) {
            Schema::table('inv_order_details', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('vat_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('vat_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('discount_percent', 10, 2)->nullable()->default(0)->change();
                $table->decimal('discount_amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_orders') && Schema::hasColumns('inv_orders', ['total_quantity','subtotal', 'total_vat_amount','shipping_cost','total_discount_amount'])) {
            Schema::table('inv_orders', function (Blueprint $table) {
                $table->decimal('total_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('subtotal', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_vat_amount', 10, 2)->nullable()->default(0)->change();
                $table->decimal('shipping_cost', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_discount_amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_grn_details') && Schema::hasColumns('inv_grn_details', ['purchase_price','quantity', 'amount'])) {
            Schema::table('inv_grn_details', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_grn') && Schema::hasColumns('inv_grn', ['total_quantity','total_amount'])) {
            Schema::table('inv_grn', function (Blueprint $table) {
                $table->decimal('total_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('total_amount', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_ecom_accounts') && Schema::hasColumn('inv_ecom_accounts', 'balance')) {
            Schema::table('inv_ecom_accounts', function (Blueprint $table) {
                $table->decimal('balance', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_customer_types') && Schema::hasColumn('inv_customer_types', 'percentage')) {
            Schema::table('inv_customer_types', function (Blueprint $table) {
                $table->decimal('percentage', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('inv_customers') && Schema::hasColumns('inv_customers', ['opening_balance','current_balance'])) {
            Schema::table('inv_customers', function (Blueprint $table) {
                $table->decimal('opening_balance', 10, 2)->nullable()->default(0)->change();
                $table->decimal('current_balance', 10, 2)->nullable()->default(0)->change();
            });
        }


        /*
        |-------------------------------------------------------
        |             PRODUCT TABLES
        |-------------------------------------------------------
        */
        if (Schema::hasTable('pdt_stock_summaries') && Schema::hasColumns('pdt_stock_summaries', ['stock_in_qty','stock_out_qty','stock_in_value','stock_out_value'])) {
            Schema::table('pdt_stock_summaries', function (Blueprint $table) {
                $table->decimal('stock_in_qty', 10, 2)->nullable()->default(0)->change();
                $table->decimal('stock_out_qty', 10, 2)->nullable()->default(0)->change();
                $table->decimal('stock_in_value', 10, 2)->nullable()->default(0)->change();
                $table->decimal('stock_out_value', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('pdt_stocks') && Schema::hasColumns('pdt_stocks', ['purchase_price','sale_price','quantity','actual_quantity'])) {
            Schema::table('pdt_stocks', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('actual_quantity', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('pdt_product_variations') && Schema::hasColumns('pdt_product_variations', ['purchase_price','wholesale_price','sale_price'])) {
            Schema::table('pdt_product_variations', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('wholesale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('pdt_product_uploads') && Schema::hasColumns('pdt_product_uploads', ['purchase_price','wholesale_price','sale_price','alert_quantity','maximum_order_quantity','weight'])) {
            Schema::table('pdt_product_uploads', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('wholesale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('alert_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('maximum_order_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('weight', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('pdt_product_detail_uploads') && Schema::hasColumns('pdt_product_detail_uploads', ['purchase_price','sale_price'])) {
            Schema::table('pdt_product_detail_uploads', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
            });
        }

        if (Schema::hasTable('pdt_products') && Schema::hasColumns('pdt_products', ['purchase_price','wholesale_price','sale_price','weight','alert_quantity','maximum_order_quantity','vat'])) {
            Schema::table('pdt_products', function (Blueprint $table) {
                $table->decimal('purchase_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('wholesale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('sale_price', 10, 2)->nullable()->default(0)->change();
                $table->decimal('weight', 10, 2)->nullable()->default(0)->change();
                $table->decimal('alert_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('maximum_order_quantity', 10, 2)->nullable()->default(0)->change();
                $table->decimal('vat', 10, 2)->nullable()->default(0)->change();
            });
        }
    }


    public function down()
    {
        //
    }

}
