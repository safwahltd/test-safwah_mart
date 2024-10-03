<?php

use Illuminate\Support\Facades\Route;
use Module\Inventory\Controllers\Api\ApiController;

Route::group(['prefix' => 'api'], function () {

    Route::get('get-otp/{phone}',                               [ApiController::class, 'getOTP']);
    Route::get('get-coupon',                                    [ApiController::class, 'getCoupon']);
    Route::post('submit-order',                                 [ApiController::class, 'submitOrder']);
    Route::get('get-order-by-tnx-no/{tnx_no}',                  [ApiController::class, 'getOrderByTnxNo']);
    Route::post('update-order-payment-status',                  [ApiController::class, 'updateOrderPaymentStatus']);
    Route::post('submit-supplier-request',                      [ApiController::class, 'submitSupplierRequest']);
    Route::post('submit-corporate-order',                       [ApiController::class, 'corporateOrderStore']);
    Route::post('submit-orderby-picture',                       [ApiController::class, 'orderByPictureStore']);
    Route::post('submit-appointment-booking',                   [ApiController::class, 'appointmentBookingStore']);
    Route::get('get-time-slots',                                [ApiController::class, 'timeSlots']);
    Route::get('get-order-status/{id}',                         [ApiController::class, 'getOrderStatus']);
    Route::get('get-weight-wise-extra-shipping-cost',           [ApiController::class, 'getWeightWiseExtraShippingCost']);
    Route::get('get-order-amount-wise-shipping-cost-discount',  [ApiController::class, 'getOrderAmountWiseShippingCostDiscount']);
    Route::get('require-point-by-grand-total',                  [ApiController::class, 'requirePointByGrandTotal']);
    Route::get('get-point-rate',                                [ApiController::class, 'getPointRate']);
    Route::get('get-minimum-point-for-withdraw',                [ApiController::class, 'getMinimumPointForWithdraw']);
    Route::get('get-order-current-status',                      [ApiController::class, 'getOrderCurrentStatus']);
    Route::get('get-customer-type-wise-discount',               [ApiController::class, 'getCustomerTypeWiseDiscount']);

    Route::middleware('auth:sanctum')->group( function () {
        Route::get('get-customer/{id}',                         [ApiController::class, 'getCustomer']);
        Route::get('get-customer-by-user/{user_id}',            [ApiController::class, 'getCustomerByUser']);
        Route::get('get-all-orders-by-customer/{id}',           [ApiController::class, 'getAllOrdersByCustomer']);
        Route::get('get-single-order/{id}',                     [ApiController::class, 'getSingleOrder']);
        Route::post('update-single-order/{id}',                 [ApiController::class, 'updateSingleOrder']);
        Route::get('change-order-status/{id}',                  [ApiController::class, 'changeOrderStatus']);
        Route::get('get-all-stock-requests-by-customer/{id}',   [ApiController::class, 'getAllStockRequestByCustomer']);
        Route::get('get-order-show/{id}',                       [ApiController::class, 'orderShow']);
        Route::get('get-order-histories/{id}',                  [ApiController::class, 'orderHistories']);
        Route::get('get-orders',                                [ApiController::class, 'allOrder']);
        Route::get('get-customer-product-reviews/{id}',         [ApiController::class, 'productReviews']);
        Route::get('get-customer-wishlists/{id}',               [ApiController::class, 'customerWishlists']);
        Route::get('get-order-returns/{id}',                    [ApiController::class, 'getOrderReturns']);
        Route::get('show-order-return/{id}',                    [ApiController::class, 'showOrderReturn']);
        Route::get('create-order-return',                       [ApiController::class, 'createOrderReturn']);
        Route::post('store-order-return',                       [ApiController::class, 'storeOrderReturn']);
        Route::delete('delete-order-return/{id}',               [ApiController::class, 'deleteOrderReturn']);
    });
});


