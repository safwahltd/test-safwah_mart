<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProductType extends Model
{
    use AutoCreatedUpdated, HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pdt_product_types';

    protected $guarded = [];


   /*
    |--------------------------------------------------------------------------
    | PRODUCTS CATEGORY METHOD
    |--------------------------------------------------------------------------
    */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCTS BRAND METHOD
    |--------------------------------------------------------------------------
    */
    public function brands()
    {
        return $this->hasMany(Brand::class);
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
     | GET TABLE NAME
     |--------------------------------------------------------------------------
    */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }


}
