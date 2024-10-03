<?php

namespace Module\Product\Models;

use App\Model;

class ProductTag extends Model
{
    protected $table = 'pdt_product_tags';


    /*
     |--------------------------------------------------------------------------
     | HIGHLIGHT TYPE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
