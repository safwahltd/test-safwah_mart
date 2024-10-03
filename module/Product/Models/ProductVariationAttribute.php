<?php

namespace Module\Product\Models;

use App\Model;

class ProductVariationAttribute extends Model
{
    protected $table = 'pdt_product_variation_attributes';


    

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }


    

    public function attributeType()
    {
        return $this->belongsTo(AttributeType::class, 'attribute_type_id');
    }


    

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
