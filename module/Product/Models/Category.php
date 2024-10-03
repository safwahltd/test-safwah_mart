<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class Category extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_categories';



    public function scopeShowOnMenu($query)
    {
        $query->where('show_on_menu', 'Yes');
    }




    /*
    |--------------------------------------------------------------------------
    | PRODUCTS METHOD
    |--------------------------------------------------------------------------
    */
    public function products()
    {
        return $this->hasMany(Product::class);
    }





    /*
     |--------------------------------------------------------------------------
     | PARENT CATEGORY METHOD
     |--------------------------------------------------------------------------
    */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }





    /*
     |--------------------------------------------------------------------------
     | PARENT CATEGORIES METHOD
     |--------------------------------------------------------------------------
    */
    public function parentCategories()
    {
        return  $this->hasMany(Category::class, 'id', 'parent_id')
                ->with('parentCategories')->select('id', 'parent_id', 'name', 'slug');
    }



    /*
    |--------------------------------------------------------------------------
    | CHILD CATEGORY METHOD
    |--------------------------------------------------------------------------
    */
    public function childCategories()
    {
        return  $this->hasMany(Category::class, 'parent_id', 'id')
                ->with(['childCategories' => function($query) {
                    $query->with('productType:id,name')
                    ->orderBy('serial_no', 'ASC')
                    ->select('id', 'parent_id', 'name', 'product_type_id', 'slug','image');
                }])
                ->with('productType:id,name')
                ->orderBy('serial_no', 'ASC')
                ->select('id', 'parent_id', 'name','product_type_id','slug','image');
    }





    /*
    |--------------------------------------------------------------------------
    | CHILD CATEGORY METHOD
    |--------------------------------------------------------------------------
    */
    public function childCategoriesWithCount()
    {
        return  $this->hasMany(Category::class, 'parent_id', 'id')
                ->with(['childCategoriesWithCount' => function($query) {
                    $query->with('productType:id,name')
                    ->withCount('products as total_product')
                    ->orderBy('serial_no', 'ASC')
                    ->select('id', 'parent_id', 'name', 'product_type_id', 'slug');
                }])
                ->with('productType:id,name')
                ->orderBy('serial_no', 'ASC')
                ->select('id', 'parent_id', 'name','product_type_id','slug');
    }




    /*
    |--------------------------------------------------------------------------
    | SUB CATEGORY METHOD
    |--------------------------------------------------------------------------
    */
    public function subCategories()
    {
        return  $this->hasMany(Category::class, 'parent_id', 'id')

                    ->with(['subCategories' => function($query) {
                        $query->with('productType:id,name')
                        ->orderBy('serial_no', 'ASC')
                        ->select('id', 'parent_id', 'name', 'slug', 'product_type_id', 'meta_title', 'meta_description', 'alt_text', 'image','banner_image');
                    }])

                    ->with('productType:id,name')
                    ->orderBy('serial_no', 'ASC')
                    ->select('id', 'parent_id', 'name', 'slug', 'product_type_id', 'meta_title', 'meta_description', 'alt_text', 'image','banner_image');
    }



    /*
    |--------------------------------------------------------------------------
    | CHILD CATEGORIES METHOD (SHOW ON MENU)
    |--------------------------------------------------------------------------
    */
    public function childCategoriesShowOnMenu()
    {
        return  $this->hasMany(Category::class, 'parent_id', 'id')
                // ->whereHas('products')
                ->with(['childCategoriesShowOnMenu' => function($query) {
                    $query
                    // ->whereHas('products')
                    ->showOnMenu()->select('id', 'parent_id', 'icon','image' ,'name', 'product_type_id', 'slug');
                }])
                ->showOnMenu()
                ->orderBy('id', 'asc')
                ->select('id', 'parent_id', 'name','product_type_id','slug', 'icon','image');
    }




    /*
    |--------------------------------------------------------------------------
    | CHECK PRODUCT STOCK BEFORE DELETE A PARENT CATEGORY
    |--------------------------------------------------------------------------
    */

    public function scopeApiQuery($query)
    {
        $query->active();
    }




    public function getImageAttribute()
    {
        $image = $this->attributes['image'];

        if (file_exists(public_path($image))) {
            return $image;
        }else{
            return 'default-img.jpg';
        }

    }




    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}






