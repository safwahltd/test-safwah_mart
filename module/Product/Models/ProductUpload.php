<?php

namespace Module\Product\Models;

use App\Model;

class ProductUpload extends Model
{
    protected $table = 'pdt_product_uploads';


    /*
     |--------------------------------------------------------------------------
     | PRODUCT (METHOD)
     |--------------------------------------------------------------------------
    */
    public function productDetailUpload()
    {
        return $this->hasMany(ProductDetailUpload::class);
    }
}
