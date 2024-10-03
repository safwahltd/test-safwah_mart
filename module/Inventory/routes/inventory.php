<?php

use Illuminate\Support\Facades\Route;
use Module\Inventory\Controllers\SaleController;
use Module\Inventory\Controllers\OrderController;
use Module\Inventory\Controllers\CouponController;
use Module\Inventory\Controllers\ReportController;
use Module\Inventory\Controllers\CustomerController;
use Module\Inventory\Controllers\TimeSlotController;
use Module\Inventory\Controllers\WarehouseController;
use Module\Inventory\Controllers\DeliveryManController;
use Module\Inventory\Controllers\Purchase\POController;
use Module\Inventory\Controllers\CustomerTypeController;
use Module\Inventory\Controllers\StockRequestController;
use Module\Inventory\Controllers\Purchase\PurchaseController;
use Module\Inventory\Controllers\DeliveryManTimeSlotController;
use Module\Inventory\Controllers\DueCollectionController;
use Module\Inventory\Controllers\OrderAmountWiseShippingCostDiscountController;
use Module\Inventory\Controllers\OrderReturnController;
use Module\Inventory\Controllers\ReturnReasonController;
use Module\Inventory\Controllers\SupplierRequestController;
use Module\Inventory\Controllers\WeightWiseExtraShippingCostController;
use Module\Inventory\Controllers\OrderCreateController;


Route::get('get-customers', [SaleController::class, 'getCustomers'])->name('get-customers');
Route::get('get-sale-products', [SaleController::class, 'getSaleProducts'])->name('get-sale-products');

Route::group(['middleware' => 'auth', 'prefix' => 'admin/inventory', 'as' => 'inv.'], function () {





    /*
    |--------------------------------------------------------------------------
    | STOCK REQUESTS ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('stock-requests',                    [StockRequestController::class, 'index'])->name('stock-requests.index');
    Route::delete('stock-requests/{id}',            [StockRequestController::class, 'destroy'])->name('stock-requests.destroy');





    /*
    |--------------------------------------------------------------------------
    | SALE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('sales', SaleController::class);

    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {

        Route::get('create/pos-sale', [SaleController::class, 'createPosSale'])->name('create.pos-sale');


        Route::group(['prefix' => 'axios', 'as' => 'axios.'], function () {

            Route::post('create-customer',              [SaleController::class, 'createCustomer'])->name('create-customer');
            Route::post('edit-customer',                [SaleController::class, 'editCustomer'])->name('edit-customer');

            Route::get('get-product-variations',        [SaleController::class, 'getProductVariations'])->name('get-product-variations');
            Route::get('get-product-measurements',      [SaleController::class, 'getProductMeasurements'])->name('get-product-measurements');
            Route::get('get-lots',                      [SaleController::class, 'getLots'])->name('get-lots');
            Route::get('get-item-stock',                [SaleController::class, 'getItemStock'])->name('get-item-stock');
            Route::get('search-item',                   [SaleController::class, 'searchItem'])->name('search-item');
            Route::get('orders/search-item',            [OrderController::class, 'searchItem'])->name('orders.search-item');

            Route::get('recent-transaction',           [SaleController::class, 'recentTransaction'])->name('recent-transaction');

        });
    });








    /*
     |--------------------------------------------------------------------------
     | PURCHASE ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('purchases', PurchaseController::class);

    Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {

        Route::delete('items/destroy/{id}',                             [PurchaseController::class, 'purchaseItemsDestroy'])->name('items.destroy');
        Route::match(['GET', 'POST'], 'approve-and-receive/{id}',       [PurchaseController::class, 'purchaseApproveAndReceive'])->name('approve-and-receive');


        Route::group(['prefix' => 'axios', 'as' => 'axios.'], function () {

            Route::get('get-product-variations',                        [PurchaseController::class, 'getProductVariations'])->name('get-product-variations');
        });


        Route::group(['prefix' => 'p-o', 'as' => 'p-o.'], function () {

            Route::get('/',                                             [POController::class, 'poList'])->name('list');
            Route::get('create',                                        [POController::class, 'poCreate'])->name('create');
            Route::post('store',                                        [POController::class, 'poStore'])->name('store');
            Route::get('edit/{id}',                                     [POController::class, 'poEdit'])->name('edit');
            Route::put('update/{id}',                                   [POController::class, 'poUpdate'])->name('update');
            Route::match(['GET', 'POST'], 'verification/{id}',          [POController::class, 'poVerification'])->name('verification');

            Route::delete('items/destroy/{id}',                         [POController::class, 'poItemsDestroy'])->name('items.destroy');
            Route::delete('destroy/{id}',                               [POController::class, 'poDestroy'])->name('destroy');
        });
    });




    /*
     |--------------------------------------------------------------------------
     | CUSTOMER ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('customers',     CustomerController::class);




    /*
     |--------------------------------------------------------------------------
     | CUSTOMER TYPES ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('customer-types', CustomerTypeController::class);




    /*
     |--------------------------------------------------------------------------
     | DELIVERY MAN ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('delivery-mans',        DeliveryManController::class);
    Route::post('update-delivery-discount', [DeliveryManController::class, 'updateDeliveryDiscountSetting'])->name('update-delivery-discount');
    Route::get('delivery-discount',         [DeliveryManController::class, 'deliveryDiscount'])->name('delivery-mans.delivery-discount');

    Route::get('get-areas-by-district',     [DeliveryManController::class, 'getAreasByDistrict'])->name('get-areas-by-district');

    Route::get('delivery-man-orders',       [OrderController::class, 'deliveryManOrders'])->name('delivery-man-orders');


    /*
     |--------------------------------------------------------------------------
     | TIME SLOTS ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('time-slots', TimeSlotController::class);


    /*
     |--------------------------------------------------------------------------
     | WEIGHT WISE EXTRA SHIPPING COST ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('weight-wise-extra-shipping-costs', WeightWiseExtraShippingCostController::class);


    /*
     |--------------------------------------------------------------------------
     | WEIGHT WISE EXTRA SHIPPING COST ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('shipping-cost-discounts', OrderAmountWiseShippingCostDiscountController::class);



    /*
     |--------------------------------------------------------------------------
     | DELIVERY MAN TIME SLOTS ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('delivery-man-time-slots', DeliveryManTimeSlotController::class);



    /*
     |--------------------------------------------------------------------------
     | WAREHOUSE ROUTES
     |--------------------------------------------------------------------------
    */
    Route::resource('warehouses', WarehouseController::class);





    /*
     |--------------------------------------------------------------------------
     | REPORT ROUTES
     |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {





        /*
        |--------------------------------------------------------------------------
        | INVENTORY REPORT ROUTES
        |--------------------------------------------------------------------------
        */
        Route::get('sales-report',                      [ReportController::class, 'salesReport'])->name('sales-report');
        Route::get('daily-sales-report',                [ReportController::class, 'dailySalesReport'])->name('daily-sales-report');
        Route::get('product-report',                    [ReportController::class, 'productReport'])->name('product-report');
        Route::get('stock-in-hand',                     [ReportController::class, 'stockInHand'])->name('stock-in-hand');
        Route::get('product-alert',                     [ReportController::class, 'productAlertReport'])->name('product-alert');
        Route::get('product-expire-report',             [ReportController::class, 'productExpiredReport'])->name('product-expire-report');
        Route::get('item-ledger',                       [ReportController::class, 'itemLedger'])->name('item-ledger');
        Route::get('monthly-order-report',              [ReportController::class, 'monthlyOrder'])->name('monthly-order-report');
        Route::get('daily-order-report',                [ReportController::class, 'dailyOrder'])->name('daily-order-report');




        /*
        |--------------------------------------------------------------------------
        | ORDER REPORT ROUTES
        |--------------------------------------------------------------------------
        */
        Route::get('order/receivable-dues',     [ReportController::class, 'receivableDues'])->name('receivable-dues');





        Route::group(['prefix' => 'axios', 'as' => 'axios.'], function () {

            Route::get('get-products-by-category',      [ReportController::class, 'getProductsByCategory'])->name('get-products-by-category');
            Route::get('get-variations-by-product',     [ReportController::class, 'getVariationsByProduct'])->name('get-variations-by-product');
        });
    });




     /*
     |--------------------------------------------------------------------------
     | PRODUCT ORDER PDF EXPORT
     |--------------------------------------------------------------------------
    */
    Route::get('product-order-excel-export',           [ReportController::class, 'productOrderExcelExport'])->name('product-order-excel-export');
    Route::get('/product-order-pdf-export',             [ReportController::class, 'productOrderPdfExport'])->name('product-order-pdf-export');




     /*
     |--------------------------------------------------------------------------
     | COUPONS ROUTE
     |--------------------------------------------------------------------------
    */
    Route::resource('coupons', CouponController::class);

    /*
     |--------------------------------------------------------------------------
     | ORDER ROUTE
     |--------------------------------------------------------------------------
    */
    Route::resource('orders', OrderController::class);
    Route::resource('order-creates', OrderCreateController::class);

    Route::resource('supplier-request', SupplierRequestController::class);


    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {

        Route::get('change-order-status/{id}',      [OrderController::class, 'changeOrderStatusCreate'])->name('change-order-status.create');
        Route::post('change-order-status/{id}',     [OrderController::class, 'changeOrderStatus'])->name('change-order-status');
        Route::get('axios/search-item',             [OrderController::class, 'searchItem'])->name('axios.search-item');
    });





    /*
    |--------------------------------------------------------------------------
    | DUE COLLECTION CREATE
    |--------------------------------------------------------------------------
    */
    Route::get('due-collections/create',  [DueCollectionController::class, 'create'])->name('due-collections.create');
    Route::post('due-collections/store',  [DueCollectionController::class, 'store'])->name('due-collections.store');








    /*
     |--------------------------------------------------------------------------
     | RETURN REASON ROUTE
     |--------------------------------------------------------------------------
    */
    Route::resource('return-reasons', ReturnReasonController::class);






    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN ROUTE
     |--------------------------------------------------------------------------
    */
    Route::resource('order-returns', OrderReturnController::class);
    Route::group(['prefix' => 'order-returns', 'as' => 'order-returns.'], function () {
        Route::get('change-status/{id}',    [OrderReturnController::class, 'changeStatus'])->name('change-status');
        Route::post('update-status/{id}',   [OrderReturnController::class, 'updateStatus'])->name('update-status');
        Route::get('show/{id}',             [OrderReturnController::class, 'show'])->name('show');
    });



});
Route::get('update-order-status/{order_id}/{status_id}',      [OrderController::class, 'updateOrderStatus'])->name('update-order-status');

