<?php

namespace Module\Permission\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Module\Permission\Models\Module;
use Illuminate\Support\Facades\Schema;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::disableForeignKeyConstraints();
        // DB::table('modules')->truncate();
        // // DB::truncate('inv_statuses');
        // Schema::enableForeignKeyConstraints();
        
        foreach ($this->getModules() ?? [] as $module)
        {
            Module::updateOrCreate([
                'name'  => $module['name'],
            ], [
                'id'        => $module['id'],
                'status'    => $module['status'],
            ]);
        }
        // dd(Module::where('name', 'Account & Finance')->first());
    }

    private function getModules()
    {
        return [
            ['id' => '1',          'name' => 'User Access',                'status' => '1'],
            ['id' => '2',          'name' => 'Product',                    'status' => '1'],
            ['id' => '3',          'name' => 'Inventory',                  'status' => '1'],
            ['id' => '4',          'name' => 'Website CMS',                'status' => '1'],
            ['id' => '6',          'name' => 'Delivery App API',           'status' => '1'],
            ['id' => '150000',     'name' => 'Account & Finance',          'status' => '1'],
            ['id' => '200000',     'name' => 'Courier Management',         'status' => '1'],

            ['id' => '700000',     'name' => 'Setting',                     'status' => '1'],

        ];
    }
}
