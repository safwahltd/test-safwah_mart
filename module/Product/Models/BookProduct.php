<?php

namespace Module\Product\Models;

use App\Model;

class BookProduct extends Model
{
    protected $table = 'pdt_book_products';

    protected $guarded = [];



    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }



    /*
     |--------------------------------------------------------------------------
     | WRITER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }



    /*
     |--------------------------------------------------------------------------
     | PUBLISHER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
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
