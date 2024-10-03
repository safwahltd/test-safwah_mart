<?php

namespace App\Providers;

use Module\Permission\Models\Module;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace                    = 'App\Http\Controllers';




    /*
     |--------------------------------------------------------------------------
     | MODULE
     |--------------------------------------------------------------------------
    */
    protected $permission                   = 'Module\Permission\Controllers';
    protected $inventory                    = 'Module\Inventory\Controllers';
    protected $inventory_api                = 'Module\Inventory\Controllers\Api';
    protected $product                      = 'Module\Product\Controllers';
    protected $product_api                  = 'Module\Product\Controllers\Api';
    protected $website_cms                  = 'Module\WebsiteCMS\Controllers';
    protected $website_cms_api              = 'Module\WebsiteCMS\Controllers\Api';
    protected $account                      = 'Module\Account\Controllers';




    public $HOME = '/';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {

        Route::group(['middleware' => 'web'], function () {
            
            
            
            

            /*
             |--------------------------------------------------------------------------
             | WEB
             |--------------------------------------------------------------------------
            */
            Route::namespace($this->namespace)->group(base_path('routes/web.php'));





            /*
             |--------------------------------------------------------------------------
             | PERMISSION
             |--------------------------------------------------------------------------
            */
            Route::namespace($this->permission)->group(base_path('module/Permission/routes/web.php'));





            /*
             |--------------------------------------------------------------------------
             | PRODUCT
             |--------------------------------------------------------------------------
            */
            Route::namespace($this->product)->group(base_path('module/Product/routes/web.php'));
            Route::namespace($this->product)->group(base_path('module/Product/routes/api.php'));



            if (Schema::hasTable('modules')) {
                $modules = Module::active()->get();

                /*
                |--------------------------------------------------------------------------
                | INVENTORY
                |--------------------------------------------------------------------------
                */
                if ($modules->where('name', 'Inventory')->first() && file_exists(base_path() . '/module/Inventory/routes/web.php')) {
                    Route::middleware('web')->group(base_path('module/Inventory/routes/web.php'));
                }





                /*
                |--------------------------------------------------------------------------
                | WEBSITE CMS
                |--------------------------------------------------------------------------
                */
                if ($modules->where('name', 'Website CMS')->first() && file_exists(base_path() . '/module/WebsiteCMS/routes/web.php')) {
                    Route::middleware('web')->group(base_path('module/WebsiteCMS/routes/web.php'));
                }
            }





            /*
             |--------------------------------------------------------------------------
             | ACCOUNT & FINANCE
             |--------------------------------------------------------------------------
            */
            Route::namespace($this->account)->group(base_path('module/Account/routes/web_account.php'));
        });


        
        Route::namespace($this->website_cms_api)->group(base_path('module/WebsiteCMS/routes/api.php'));
        Route::namespace($this->inventory_api)->group(base_path('module/Inventory/routes/api.php'));
        Route::namespace($this->product_api)->group(base_path('module/Product/routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
