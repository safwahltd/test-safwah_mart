<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomQueryController;
use App\Http\Controllers\PointSettingController;
use App\Http\Controllers\Setting\CompanySettingController;
use App\Http\Controllers\Setting\EcomSettingController;
use App\Http\Controllers\Setting\EmailSettingController;
use App\Http\Controllers\Setting\OrderSettingController;
use App\Http\Controllers\Setting\PopupNotificationController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Setting\SmsApiSettingController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/cc', function() {
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
    // \Artisan::call('cache:clear');
    // \Artisan::call('view:clear');
    // \Artisan::call('config:cache');
    // \Artisan::call('optimize:clear');

    return 'DONE';
});
Route::get('/cc', function() {
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
    // \Artisan::call('cache:clear');
    // \Artisan::call('view:clear');
    // \Artisan::call('config:cache');
    // \Artisan::call('optimize:clear');

    return 'DONE';
});

Route::get('migrate', function() {
    Artisan::call('migrate');

    return 'success';
});

// Auth::routes();
Auth::routes(['register' => false]);

Route::get('/test', function () {
    return view('test');
});

Route::get('/invoice1', function () {
    return view('invoice1');
});

Route::get('/image', function () {
    return view('image');
});

Route::post('push', 'AttendanceDeviceApi\LogController@push');

//Route::get('/', 'HomeController@index')->name('index');

Route::group(['prefix' => 'password-reset', 'namespace' => 'Auth', 'as' => 'password-reset.'], function () {
    Route::post('send-email', 'LoginController@sendPasswordResetEmail')->name('send-email');
    Route::get('verify-token', 'LoginController@verifyResetPasswordToken')->name('verify-token');
    Route::post('reset-password', 'LoginController@updateUserPassword')->name('update-password');
});



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('index');

    Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/country',   'DashboardController@country')->name('country');
    Route::get('/get-current-month-wise-daily-sale-report', 'DashboardController@getCurrentMonthWiseDailySaleReport')->name('get-current-month-wise-daily-sale-report');


    Route::post('/update-status/{table}/{column}', 'Controller@updateStatus')->name('update-status');

    Route::get('user/password/edit', 'UserController@changePassword')->name('user.password.edit');
    Route::post('user/password/edit', 'UserController@updatePassword')->name('user.password.update');
    // only access for super admin which id is 1
    Route::get('user/change/password/{id}', 'UserController@AdminChangePassword')->name('admin.edit.password');
    Route::post('user/change/password', 'UserController@AdminUpdatePassword')->name('admin.update.password');

    Route::get('db-backup', 'DatabaseBackupController@db_backup')->name('db-backup');
    Route::resource('group', 'GroupController');
    Route::get('/print-groups', 'GroupController@printGroups')->name('print.groups');
    Route::resource('company', 'CompanyController');

    Route::resource('id-card-settings', 'IdCardSettingController');

    Route::resource('currency-conversions', 'CurrencyConversionController');



    Route::resource('system-setting', 'SystemSettingController');


    Route::group(['prefix' => 'global-setting'], function () {
        Route::resource('suppliers', 'SupplierController');
        Route::resource('supplier-types', 'SupplierTypeController');
    });



    Route::group(['middleware' => 'super-admin'], function () {
        Route::get('smart-soft-payments/alert', 'SmartSoftPaymentScheduleController@ajaxAlert')->name('smart-soft-payments.alert');
        Route::resource('smart-soft-payments', 'SmartSoftPaymentScheduleController');
    });

    Route::post('payment/feedback', 'SmartSoftPaymentScheduleController@feedback')->name('smart-soft-payments.feedback');


    Route::get('add-user', 'UserController@addUserFromEmployee');



    /// dashboard data load related routes
    Route::get('get-commercial-dashboard-data', 'HomeController@getCommercialDashboardData')->name('get-commercial-dashboard-data');
    Route::get('get-inventory-dashboard-data',  'HomeController@getInventoryDashboardData')->name('get-inventory-dashboard-data');
    Route::get('get-payment-dashboard-data',    'HomeController@getPaymentDashboardData')->name('get-payment-dashboard-data');




    Route::prefix('admin')->group(function () {

        // DISTRICTS ROUTES
        Route::resource('districts',          DistrictController::class);
        Route::post('update-districts-data',   'DistrictController@updateDistrictsData')->name('update-districts-data');

        // AREAS ROUTES
        Route::resource('areas', AreaController::class);
        Route::post('update-areas-data',   'AreaController@updateAreasData')->name('update-areas-data');

        Route::resource('/point-configs', PointConfigController::class);
    });
















    Route::group(['prefix' => '/admin/settings', 'namespace' => 'Setting', 'as' => 'settings.'], function () {

        Route::get('/',                                 [SettingController::class,              'index'])->name('index');
        Route::put('update-company-setting/{id?}',      [CompanySettingController::class,       'updateCompanySetting'])->name('update-company-setting');
        Route::put('update-email-setting/{id?}',        [EmailSettingController::class,         'updateEmailSetting'])->name('update-email-setting');
        Route::put('update-sms-api-setting/{id?}',      [SmsApiSettingController::class,        'updateSmsApiSetting'])->name('update-sms-api-setting');
        Route::put('update-ecom-setting',               [EcomSettingController::class,          'updateEcomSetting'])->name('update-ecom-setting');
        Route::put('update-order-setting',              [OrderSettingController::class,         'updateOrderSetting'])->name('update-order-setting');
        Route::put('update-point-setting',              [PointSettingController::class,         'updatePointSetting'])->name('update-point-setting');

        Route::resource('popup-notifications',          'PopupNotificationController');
    });




    /*
     |--------------------------------------------------------------------------
     | CUSTOM QUERY ROUTES
     |--------------------------------------------------------------------------
    */
    Route::get('add-acc-customers-from-inv-customers',              [CustomQueryController::class, 'addAccCustomersFromInvCustomers']);
    Route::get('add-current-status-value-in-inv-orders',            [CustomQueryController::class, 'addCurrentStatusValueInInvOrders']);
    Route::get('add-thumbnail-image-from-image-in-pdt-products',    [CustomQueryController::class, 'addThumbnailImageFromImageInPdtProducts']);
    Route::get('solve-220627521-order-issue',                       [CustomQueryController::class, 'solve220627521OrderIssue']);
    Route::get('solve-orders-discount-issue',                       [CustomQueryController::class, 'solveOrdersDiscountIssue']);
    Route::get('add-shipping-cost-in-220717712-order',              [CustomQueryController::class, 'addShippingCostIn220717712Order']);
    Route::get('add-quantity-in-2985-order-detail',                 [CustomQueryController::class, 'addQuantityIn2985OrderDetail']);
});


// Route::post('test-customer', [HomeController::class, 'testCustomer'])->name('test-customer');
