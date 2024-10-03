<?php

use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'auth'], function () {
    Route::prefix('/admin')->group(function () {
        /*
         |--------------------------------------------------------------------------
         | DUE PAYMENT ROUTES
         |--------------------------------------------------------------------------
        */
        Route::prefix('/payments')->group(function () {

            Route::resource('/due-payments', 'DuePaymentController');

        });
    });
});
