<?php

namespace Module\Product\Models;

use App\Model;
use Module\Product\Models\Offer;
use App\Traits\AutoCreatedUpdated;

class ProductDiscount extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_product_discounts';

    


    
    /*
     |--------------------------------------------------------------------------
     | OFFER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    


    
    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
