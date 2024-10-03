<?php

namespace Module\Permission\database\seeds;

use Illuminate\Database\Seeder;
use Module\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getDatas() ?? [] as $permission)
        {
            try {
                Permission::updateOrCreate([
                    'id'                    => $permission['id'],
                ], [
                    'name'                  => $permission['name'],
                    'slug'                  => $permission['slug'],
                    'parent_permission_id'  => $permission['parent_permission_id'],
                    'created_by'            => 1,
                    'updated_by'            => 1,
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }

        }
    }

    private function getDatas()
    {
        return $permissions = array(
            // array('id' => '1','name' => 'Permission Access','slug' => 'permission.accesses.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '1','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '2','name' => 'Permitted Users','slug' => 'permission.permitted.users','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '1','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '3','name' => 'Permission Create','slug' => 'permission.accesses.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '1','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '4','name' => 'Permission Edit','slug' => 'permission.accesses.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '1','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '5','name' => 'Permission Delete','slug' => 'permission.accesses.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '1','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),

            // array('id' => '6','name' => 'Index','slug' => 'products.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '7','name' => 'View','slug' => 'products.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '8','name' => 'Create','slug' => 'products.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '9','name' => 'Edit','slug' => 'products.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '10','name' => 'Delete','slug' => 'products.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '11','name' => 'Upload','slug' => 'products.upload','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '12','name' => 'Index','slug' => 'categories.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '3','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '13','name' => 'View','slug' => 'categories.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '3','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '14','name' => 'Create','slug' => 'categories.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '3','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '15','name' => 'Edit','slug' => 'categories.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '3','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '16','name' => 'Delete','slug' => 'categories.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '3','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '17','name' => 'Index','slug' => 'brands.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '4','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '18','name' => 'View','slug' => 'brands.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '4','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '19','name' => 'Create','slug' => 'brands.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '4','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '20','name' => 'Edit','slug' => 'brands.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '4','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '21','name' => 'Delete','slug' => 'brands.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '4','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '22','name' => 'Index','slug' => 'unit-measures.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '5','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '23','name' => 'View','slug' => 'unit-measures.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '5','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '24','name' => 'Create','slug' => 'unit-measures.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '5','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '25','name' => 'Edit','slug' => 'unit-measures.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '5','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '26','name' => 'Delete','slug' => 'unit-measures.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '5','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '27','name' => 'Index','slug' => 'attribute-types.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '6','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '28','name' => 'View','slug' => 'attribute-types.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '6','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '29','name' => 'Create','slug' => 'attribute-types.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '6','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '30','name' => 'Edit','slug' => 'attribute-types.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '6','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '31','name' => 'Delete','slug' => 'attribute-types.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '6','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '32','name' => 'Index','slug' => 'attributes.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '7','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '33','name' => 'View','slug' => 'attributes.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '7','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '34','name' => 'Create','slug' => 'attributes.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '7','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '35','name' => 'Edit','slug' => 'attributes.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '7','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '36','name' => 'Delete','slug' => 'attributes.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '7','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '37','name' => 'Index','slug' => 'highlight-types.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '8','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '38','name' => 'View','slug' => 'highlight-types.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '8','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '39','name' => 'Create','slug' => 'highlight-types.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '8','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '40','name' => 'Edit','slug' => 'highlight-types.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '8','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '41','name' => 'Delete','slug' => 'highlight-types.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '8','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '42','name' => 'Index','slug' => 'product-tags.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '9','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '43','name' => 'View','slug' => 'product-tags.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '9','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '44','name' => 'Create','slug' => 'product-tags.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '9','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '45','name' => 'Edit','slug' => 'product-tags.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '9','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '46','name' => 'Delete','slug' => 'product-tags.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '9','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '47','name' => 'Index','slug' => 'product-types.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '10','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '48','name' => 'View','slug' => 'product-types.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '10','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '49','name' => 'Create','slug' => 'product-types.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '10','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '50','name' => 'Edit','slug' => 'product-types.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '10','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '51','name' => 'Delete','slug' => 'product-types.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '10','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '52','name' => 'Index','slug' => 'discounts.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '11','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '53','name' => 'View','slug' => 'discounts.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '11','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '54','name' => 'Create','slug' => 'discounts.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '11','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '55','name' => 'Edit','slug' => 'discounts.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '11','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '56','name' => 'Delete','slug' => 'discounts.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '11','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '57','name' => 'Product Variation Upload','slug' => 'product-variation-uploads','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '2','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '58','name' => 'Index','slug' => 'product-offer.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '16','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '59','name' => 'Index','slug' => 'product-barcode.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '15','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '60','name' => 'Index','slug' => 'product-book.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '17','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '101','name' => 'Index','slug' => 'website-cms.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '102','name' => 'View','slug' => 'website-cms.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '103','name' => 'Create','slug' => 'website-cms.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '104','name' => 'Edit','slug' => 'website-cms.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '105','name' => 'Delete','slug' => 'website-cms.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '115',   'name' => 'Meta Tag',           'slug' => 'website-cms.meta-tag',           'description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '116',   'name' => 'Popup Notification', 'slug' => 'website-cms.popup-notification', 'description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '117',   'name' => 'Supply Request',     'slug' => 'website-cms.supply-request',     'description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '12','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '201','name' => 'Index','slug' => 'orders.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '202','name' => 'Print','slug' => 'orders.print','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '203','name' => 'Status','slug' => 'orders.status','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '204','name' => 'Edit','slug' => 'orders.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '205','name' => 'Delete','slug' => 'orders.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '206','name' => 'Index','slug' => 'order-returns.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '14','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '207','name' => 'View','slug' => 'order-returns.view','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '14','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '208','name' => 'Create','slug' => 'order-returns.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '14','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '209','name' => 'Edit','slug' => 'order-returns.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '14','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '210','name' => 'Delete','slug' => 'order-returns.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '14','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '211','name' => 'Discount','slug' => 'orders.discount','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '212','name' => 'Create','slug' => 'inv.due-collections.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '18','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '213','name' => 'Index','slug'  => 'sales.index','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '301','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '214','name' => 'View','slug'   => 'sales.view','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '301','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '215','name' => 'Create','slug' => 'sales.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '301','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '216','name' => 'Edit','slug'   => 'sales.edit','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '301','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '217','name' => 'Delete','slug' => 'sales.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '301','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '218','name' => 'Print','slug'  => 'sales.print','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '301','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '219','name' => 'Index','slug' => 'purchases.index','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '220','name' => 'View','slug' => 'purchases.view','description' => NULL,'created_by'     => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '221','name' => 'Create','slug' => 'purchases.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '222','name' => 'Edit','slug' => 'purchases.edit','description' => NULL,'created_by'     => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '223','name' => 'Delete','slug' => 'purchases.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '224','name' => 'Print','slug' => 'purchases.print','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '225','name' => 'Approve and Receive','slug' => 'purchases.approve','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '302','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '226','name' => 'Sales','slug' => 'inv.report.sales','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '303','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '227','name' => 'Daily Sales','slug' => 'inv.report.daily-sales','description' => NULL,'created_by'     => '1','updated_by' => '1','parent_permission_id' => '303','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '228','name' => 'Stock In Hand','slug' => 'inv.report.stock-in-hand','description' => NULL,'created_by'     => '1','updated_by' => '1','parent_permission_id' => '303','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '229','name' => 'Item Ledger','slug' => 'inv.report.item-ledger','description' => NULL,'created_by'     => '1','updated_by' => '1','parent_permission_id' => '303','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '230','name' => 'Index','slug'  => 'inv.customers.index','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '304','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '231','name' => 'View','slug'   => 'inv.customers.view','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '304','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '231','name' => 'Create','slug' => 'inv.customers.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '304','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '233','name' => 'Edit','slug'   => 'inv.customers.edit','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '304','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '234','name' => 'Delete','slug' => 'inv.customers.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '304','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),



            // array('id' => '235','name' => 'Print Customer Copy','slug' => 'inv.order-invoice.customer-copy','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '307','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '236','name' => 'Print Accounts Copy','slug' => 'inv.order-invoice.accounts-copy','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '307','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '237','name' => 'Print Delivery Man Copy','slug' => 'inv.order-invoice.delivery-man-copy','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '307','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '238','name' => 'Print Store Copy','slug' => 'inv.order-invoice.store-copy','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '307','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '239','name' => 'Config','slug' => 'inv.config','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '305','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '240','name' => 'Logistic','slug' => 'inv.logistic','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '306','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '300091','name' => 'Index','slug'  => 'inv.stock-transfer.index','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300092','name' => 'Create','slug'  => 'inv.stock-transfer.create','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300093','name' => 'View','slug'  => 'inv.stock-transfer.view','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300094','name' => 'Edit','slug'  => 'inv.stock-transfer.edit','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300095','name' => 'Approve','slug'  => 'inv.stock-transfer.approve','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300096','name' => 'Receive','slug'  => 'inv.stock-transfer.receive','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300097','name' => 'Cancel','slug'  => 'inv.stock-transfer.cancel','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300098','name' => 'Delete','slug'  => 'inv.stock-transfer.delete','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300009','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '300101','name' => 'Index','slug'  => 'inv.stock-adjustments.index','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300102','name' => 'Create','slug'  => 'inv.stock-adjustments.create','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300103','name' => 'View','slug'  => 'inv.stock-adjustments.view','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300104','name' => 'Edit','slug'  => 'inv.stock-adjustments.edit','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300105','name' => 'Approve','slug'  => 'inv.stock-adjustments.approve','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300106','name' => 'Cancel','slug'  => 'inv.stock-adjustments.cancel','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '300107','name' => 'Delete','slug'  => 'inv.stock-adjustments.delete','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '300010','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),


            // array('id' => '700001','name' => 'Company','slug'  => 'settings.company','description' => NULL,'created_by'  => '1','updated_by' => '1','parent_permission_id' => '700000','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '700002','name' => 'Order','slug'    => 'settings.order','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '700000','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '700003','name' => 'Email','slug'    => 'settings.email','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '700000','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),
            // array('id' => '700004','name' => 'CMS','slug'      => 'settings.cms','description' => NULL,'created_by'   => '1','updated_by' => '1','parent_permission_id' => '700000','status' => '1','created_at' => '2021-11-08 10:26:30','updated_at' => '2021-11-08 10:26:30'),

            // array('id' => '100001','name' => 'User','slug' => 'permission.users.index','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '100001','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '100002','name' => 'Create','slug' => 'permission.users.create','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '100001','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '100003','name' => 'Edit','slug' => 'permission.users.edit','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '100001','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),
            // array('id' => '100004','name' => 'Delete','slug' => 'permission.users.delete','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '100001','status' => '1','created_at' => '2021-11-08 10:26:21','updated_at' => '2021-11-08 10:26:21'),

            array('id' => '700005','name' => 'Free Delivery','slug' => 'orders.free-deliveries','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2023-04-01 12:48:54','updated_at' => '2023-04-01 12:48:54'),
            array('id' => '700006','name' => 'Cod Charge','slug' => 'orders.cod-charge','description' => NULL,'created_by' => '1','updated_by' => '1','parent_permission_id' => '13','status' => '1','created_at' => '2023-04-01 12:48:54','updated_at' => '2023-04-01 12:49:41')



          );
    }
}
