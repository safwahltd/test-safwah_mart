<?php

namespace Module\Inventory\Models;

use App\Model;
use Module\Product\Models\Product;
use Module\Product\Models\ProductVariation;

class ProductDamageDetail extends Model
{
    protected $table = 'inv_product_damage_details';





    /*
     |--------------------------------------------------------------------------
     | PRODUCT DAMAGE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productDamage()
    {
        return $this->belongsTo(ProductDamage::class, 'product_damage_id');
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
}
