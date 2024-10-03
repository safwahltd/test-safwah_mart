<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Module\InvApiController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\Setting\PopupNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-profile',                      [InvApiController::class, 'getProfile']);
    Route::post('update-customer',                 [InvApiController::class, 'updateCustomer']);
    Route::post('update-socialuser-phone',         [InvApiController::class, 'updateSocialUserPhone']);
    Route::get('my-point',                          [InvApiController::class, 'myPoint']);
    Route::get('my-wallet',                         [InvApiController::class, 'myWallet']);
});


//------------------ GET SOCIALITE USER ------------------//
Route::get('get-socialite-user/{social_provider}',          [ApiController::class, 'getSocialiteUser']);


Route::post('/social-register',        [RegisterController::class, 'socialRegister']);
Route::post('/register',        [RegisterController::class, 'register']);
Route::get('/account-check',    [RegisterController::class, 'accountCheck']);
Route::post('/update-password', [RegisterController::class, 'updatePassword']);
Route::get('/check-current-password',  [RegisterController::class, 'checkCurrentPassword']);

Route::post('/login',           [LoginController::class, 'login']);


Route::get('/get-company',      [ApiController::class, 'getCompany']);
Route::get('/get-ecom-settings', [ApiController::class, 'getEcomSettings']);
Route::get('/get-page-section-ecom-settings', [ApiController::class, 'getPageSectionEcomSettings']);
Route::get('/get-districts',    [ApiController::class, 'getDritricts']);
Route::get('/get-areas/{district_id}',     [ApiController::class, 'getAreas']);


Route::get('/product-types', [ProductTypeController::class, 'productTypes']);

Route::get('/brands', [BrandController::class, 'brands']);

Route::get('/popup-notifications', [PopupNotificationController::class, 'getPopNotifications']);
Route::get('/products-promo-code', [PromoCodeController::class, 'index']);
Route::get('/get-last-order-id', [SettingController::class, 'getLastOrderId']);

Route::get('/categories', [CategoryController::class, 'categories']);

Route::get('/sub-categories', [SubCategoryController::class, 'subCategories']);

Route::get('get-minimum-order-amount-value', [SettingController::class, 'getMinimumOrderAmountValue']);


Route::get('checkout-system-setting', [SettingController::class, 'checkoutSystemSetting']);

// Route::get('deliverydate-timeslot-system-setting', [SettingController::class, 'deliveryDateTimeSlotSystemSetting']);

Route::get('deliverydate-timeslot-cms-setting', [SettingController::class, 'deliveryDateTimeSlotCmsSetting']);

// checkout page settings
Route::get('checkout-page-cms-setting', [SettingController::class, 'checkoutPageCmsSetting']);
