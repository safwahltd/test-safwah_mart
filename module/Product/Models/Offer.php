<?php

namespace Module\Product\Models;

use App\Model;
use Module\Product\Models\ProductDiscount;

class Offer extends Model
{
    protected $table = 'pdt_offers';

    protected $guarded = [];



    /*
     |--------------------------------------------------------------------------
     | API QUERY (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeApiQuery($query)
    {
        $query->active();
    }




    
    public function productDiscounts()
    {
        return $this->hasMany(ProductDiscount::class, 'offer_id');
    }
}
