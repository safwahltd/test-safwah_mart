<?php

namespace Module\Permission\database\seeds;

use Illuminate\Database\Seeder;
use Module\Permission\Models\Submodule;

class SubmoduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getSubmodules() ?? [] as $submodule)
        {
            Submodule::firstOrCreate([
                'name'      => $submodule['name']
            ], [
                'id'        => $submodule['id'],
                'module_id' => $submodule['module_id'],
            ]);
        }
    }

    private function getSubmodules()
    {
        return $submodules = array(
            array('id' => '1','name' => 'Access Panel',  'module_id' => '1','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '2','name' => 'Product',       'module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '3','name' => 'Category',      'module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '4','name' => 'Brand',         'module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '5','name' => 'Unit Measure',  'module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '6','name' => 'Attribute Type','module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '7','name' => 'Attribute',     'module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '8','name' => 'Highlight Type','module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '9','name' => 'Product Tag',   'module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '10','name' => 'Product Types','module_id' => '2','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '11','name' => 'Discount',     'module_id' => '2','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '12','name' => 'Website CMS',  'module_id' => '4','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '13','name' => 'Order',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '14','name' => 'Order Return',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '301','name' => 'Sale',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '302','name' => 'Purchase',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '303','name' => 'Inventory Report',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '304','name' => 'Customer',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '305','name' => 'Config',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '306','name' => 'Logistic',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '307','name' => 'Warehouse Access',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '309','name' => 'Stock Transfer',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '310','name' => 'Stock Adjustment',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            // array('id' => '307','name' => 'Print Order Invoice',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '15','name' => 'Barcode',  'module_id' => '2','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '16','name' => 'Offer',  'module_id' => '2','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '17','name' => 'Book',  'module_id' => '2','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '18','name' => 'Due Collection',  'module_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            

            array('id' => '700000','name' => 'Setting',  'module_id' => '700000','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '100001','name' => 'User',  'module_id' => '1','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),


        );
    }
}
