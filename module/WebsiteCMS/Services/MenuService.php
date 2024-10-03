<?php

namespace Module\WebsiteCMS\Services;

use Module\WebsiteCMS\Models\Menu;


class MenuService
{



    public $menu;
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


        Menu::updateOrCreate([
            'id'                => $id,
        ], [
            'name'              => $request->name,
            'parent_id'         => $request->parent_id,
            'icon'              => $request->icon,
            'position'          => $request->position,
            'order_no'          => $request->order_no,
            'menu_category_id'  => $request->menu_category_id,
        ]);
    }
}
