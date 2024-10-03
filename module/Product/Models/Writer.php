<?php

namespace Module\Product\Models;

use App\Model;

class Writer extends Model
{

    protected $table = 'pdt_writers';

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
