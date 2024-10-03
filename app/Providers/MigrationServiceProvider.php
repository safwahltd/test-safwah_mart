<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Permission\Models\Module;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        /*
         |--------------------------------------------------------------------------
         | PRODUCT
         |--------------------------------------------------------------------------
        */
        $this->loadMigrationsFrom([
            base_path().DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'Product'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations',
        ]);
        





        /*
         |--------------------------------------------------------------------------
         | INVENTORY
         |--------------------------------------------------------------------------
        */
        $this->loadMigrationsFrom([
            base_path().DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'Inventory'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations',
        ]);
        





        /*
         |--------------------------------------------------------------------------
         | WEBSITE CMS
         |--------------------------------------------------------------------------
        */
        $this->loadMigrationsFrom([
            base_path().DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'WebsiteCMS'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations',
        ]);
        





        /*
         |--------------------------------------------------------------------------
         | ACCOUNT
         |--------------------------------------------------------------------------
        */
        $this->loadMigrationsFrom([
            base_path().DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'Account'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations',
        ]);
    }
}
