<?php

namespace Module\Inventory\Models;

use App\Model;
use Module\Product\Models\Stock;
use Module\Product\Models\Product;
use Module\Product\Models\ProductVariation;

class SaleDetail extends Model
{
    protected $table = 'inv_sale_details';





    /*
     |--------------------------------------------------------------------------
     | SALE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
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
