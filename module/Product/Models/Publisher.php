<?php

namespace Module\Product\Models;

use App\Model;

class Publisher extends Model
{

    protected $table = 'pdt_publishers';


    protected $guarded = [];


    /*
     |--------------------------------------------------------------------------
     | BOOK PRODUCTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function bookProducts()
    {
        return $this->hasMany(BookProduct::class);
    }


    /*
     |--------------------------------------------------------------------------
     | BOOK PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function bookProduct()
    {
        return $this->hasOne(BookProduct::class, 'product_id');
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




    public function scopeApiQuery($query)
    {
        $query;
    }


}
