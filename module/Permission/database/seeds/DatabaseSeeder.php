<?php

namespace Module\Permission\Database\Seeds;
use Module\Permission\database\seeds\ModuleTableSeeder;
use Module\Permission\database\seeds\SubmoduleTableSeeder;
use Module\Permission\database\seeds\ParentPermissionTableSeeder;
use Module\Permission\database\seeds\PermissionTableSeeder;
use Module\Permission\database\seeds\PermissionFeatureTableSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(ModuleTableSeeder::class);
        // $this->call(SubmoduleTableSeeder::class);
        // $this->call(ParentPermissionTableSeeder::class);
        $this->call(PermissionTableSeeder::class);

    }
}
