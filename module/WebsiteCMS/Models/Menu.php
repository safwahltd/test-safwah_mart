<?php

namespace Module\WebsiteCMS\Models;


class Menu extends Model
{


    protected $table = 'web_menus';

    protected $guarded = [];





    /*
     |--------------------------------------------------------------------------
     | MENU CATEGORY
     |--------------------------------------------------------------------------
    */
    public function menu_category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id')->select('name', 'id');
    }






    /*
     |--------------------------------------------------------------------------
     | ALL MENU
     |--------------------------------------------------------------------------
    */
    public function allMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->with(array('allMenus' => function ($query) {

            $query->select('id', 'name', 'slug', 'icon', 'position', 'order_no', 'status', 'menu_category_id', 'image', 'parent_id')->with('menu_category');
        }))->orderBy('id', 'asc');
    }








    /*
     |--------------------------------------------------------------------------
     | MENUS
     |--------------------------------------------------------------------------
    */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
}
