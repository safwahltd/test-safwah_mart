<?php

namespace Module\Inventory\Models;

use App\Model;
use Module\Product\Models\Stock;
use Module\Product\Models\Product;
use Module\Product\Models\ProductVariation;

class OrderReturnDetail extends Model
{
    protected $table = 'inv_order_return_details';





    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderReturn()
    {
        return $this->belongsTo(OrderReturn::class, 'order_return_id');
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER DETAIL (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
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
     | STOCKS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
