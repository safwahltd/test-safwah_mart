<?php

namespace Module\WebsiteCMS\Services;

use Module\WebsiteCMS\Models\MenuCategory;


class MenuCategoryService
{



    public $menuCategory;
    public $request;


    public function __construct()
    {
        $this->request = \request();
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrUpdate($id = null)
    {
        $request = $this->request;


        MenuCategory::updateOrCreate([
            'id'        => $id,
        ], [
            'name'      => $request->name,
        ]);
    }
}
