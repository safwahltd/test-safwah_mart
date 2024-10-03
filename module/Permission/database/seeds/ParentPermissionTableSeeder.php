<?php

namespace Module\Permission\database\seeds;

use Illuminate\Database\Seeder;
use Module\Permission\Models\ParentPermission;

class ParentPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getDatas() ?? [] as $parent_permission)
        {
            try {
                ParentPermission::firstOrCreate([
                    'name'          => $parent_permission['name']
                ], [
                    'id'            => $parent_permission['id'],
                    'submodule_id'  => $parent_permission['submodule_id']
                ]);
                
            } catch (\Exception $th) {
                //throw $th;
            }
        }
    }

    private function getDatas()
    {
        return $parent_permissions = array(
            array('id' => '1','name' => 'Permission Access','submodule_id' => '1','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '2','name' => 'Product','submodule_id' => '2','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '3','name' => 'Category','submodule_id' => '3','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '4','name' => 'Brand','submodule_id' => '4','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '5','name' => 'Unit Measure','submodule_id' => '5','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '6','name' => 'Attribute Type','submodule_id' => '6','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '7','name' => 'Attribute',     'submodule_id' => '7','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '8','name' => 'Highlight Type','submodule_id' => '8','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '9','name' => 'Product Tag',   'submodule_id' => '9','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '10','name' => 'Product Type', 'submodule_id' => '10','created_at' => '2021-11-08 10:25:56','updated_at' => '2021-11-08 10:25:56'),
            array('id' => '11','name' => 'Discount','submodule_id' => '11','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '12','name' => 'Website CMS','submodule_id' => '12','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '13','name' => 'Order','submodule_id' => '13','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '14','name' => 'Return','submodule_id' => '14','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            array('id' => '301','name' => 'Sale','submodule_id' => '301','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '302','name' => 'Purchase','submodule_id' => '302','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '303','name' => 'Inventory Report','submodule_id' => '303','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '304','name' => 'Customer','submodule_id' => '304','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '305','name' => 'Config','submodule_id' => '305','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '306','name' => 'Logistic','submodule_id' => '306','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '307','name' => 'Print Order Invoice','submodule_id' => '13','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '308','name' => 'Warehouse Access','submodule_id' => '307','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '300009','name' => 'Transfer Stock','submodule_id' => '309','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '300010','name' => 'Stock Adjustment','submodule_id' => '310','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),


            array('id' => '15','name' => 'Barcode','submodule_id' => '15','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '16','name' => 'Offer','submodule_id' => '16','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '17','name' => 'Book','submodule_id' => '17','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '18','name' => 'Due Collection','submodule_id' => '18','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),


            array('id' => '700000','name' => 'Setting','submodule_id' => '700000','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),
            array('id' => '100001','name' => 'User','submodule_id' => '100001','created_at' => '2021-11-08 10:26:01','updated_at' => '2021-11-08 10:26:01'),

            
          );
    }
}
