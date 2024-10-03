<?php

namespace Module\Product\Models;

use App\Model;

class ProductMeasurement extends Model
{
    protected $table = 'pdt_product_measurements';




    
    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }




    
    /*
     |--------------------------------------------------------------------------
     | STOCK SUMMARIES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stockSummaries()
    {
        return $this->hasMany(StockSummary::class, 'variation_id');
    }


}
