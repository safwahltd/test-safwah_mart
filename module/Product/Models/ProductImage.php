<?php

namespace Module\Product\Models;
use App\Model;
use Module\Product\Models\ProductVariation;
use Illuminate\Database\Eloquent\Relations\Relation;


Relation::morphMap([
    'Product'            => Product::class,
    'Product Variation'  => ProductVariation::class,
]);


class ProductImage extends Model
{
    protected $table = 'pdt_product_images';

    


    public function scopeVariationImages($query)
    {
        $query->where(function ($q) {
            $q->where('sourcable_type', 'Product Variation')
            ->orWhere('sourcable_type', 'Product Opening By Product Variation');
        });
    }



    /*
     |--------------------------------------------------------------------------
     | SOURCABLE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function sourcable()
    {
        return $this->morphTo();
    }

    



    /*
     |--------------------------------------------------------------------------
     | PRODUCT (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeProduct($query)
    {
        $query->where('sourcable_type', 'Product');
    }

    



    /*
     |--------------------------------------------------------------------------
     | PRODUCT VARIATION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function scopeProductVariation($query)
    {
        $query->where(function ($q) {
            $q->where('sourcable_type', 'Product Variation')
            ->orWhere('sourcable_type', 'Product Opening By Product Variation');
        });
    }
}
