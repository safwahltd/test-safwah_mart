<?php

namespace Module\Inventory\Models;

use App\Model;
use Module\Product\Models\Stock;
use App\Traits\AutoCreatedUpdated;
use Module\Product\Models\Product;
use Module\Product\Models\ProductVariation;

class PurchaseDetail extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_purchase_details';
    




    /*
     |--------------------------------------------------------------------------
     | PURCHASE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
    




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
     | PRODUCT VARIATION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }




    /*
     |--------------------------------------------------------------------------
     | GRN DETAIL (RELATION)
     |--------------------------------------------------------------------------
    */
    public function grnDetail()
    {
        return $this->hasMany(GrnDetail::class, 'purchase_detail_id');
    }





    /*
     |--------------------------------------------------------------------------
     | STOCKS (METHOD)
     |--------------------------------------------------------------------------
    */
    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
