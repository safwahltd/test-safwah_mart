<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class Brand extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_brands';




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
    | PRODUCT UPLOADS METHOD
    |--------------------------------------------------------------------------
    */
    public function productUploads()
    {
        return $this->hasMany(ProductUpload::class);
    }




    /*
    |--------------------------------------------------------------------------
    | BRAND NAME (STATIC) METHOD
    |--------------------------------------------------------------------------
    */
    public static function brandName($id)
    {
        $brand = Brand::select('name')->whereId($id)->first();
        !empty($brand->name) ? $brandName = Brand::select('name')->whereId($id)->first() : $brandName = '';
        return $brandName;
    }


    public function scopeApiQuery($query)
    {
        $query->active();
    }




    public function getLogoAttribute()
    {
        $image = $this->attributes['logo'];

        if (file_exists(public_path($image))) {
            return $image;
        }

        return 'default-img.jpg';
    }
}
