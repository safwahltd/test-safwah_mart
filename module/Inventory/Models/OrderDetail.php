<?php

namespace Module\Inventory\Models;

use App\Model;
use Module\Product\Models\Stock;
use Module\Product\Models\Product;
use Module\Product\Models\ProductVariation;

class OrderDetail extends Model
{

    protected $table = 'inv_order_details';





    /*
     |--------------------------------------------------------------------------
     | ORDER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
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
     | SALE DETAIL (RELATION)
     |--------------------------------------------------------------------------
    */
    public function saleDetail()
    {
        return $this->hasOne(SaleDetail::class, 'order_detail_id');
    }





    /*
     |--------------------------------------------------------------------------
     | STOCKS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }



    public function scopeApiQuery($query)
    {
        $query->active();
    }
}
