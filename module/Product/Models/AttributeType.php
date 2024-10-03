<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;


class AttributeType extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_attribute_types';



    /*
    |--------------------------------------------------------------------------
    | PRODUCT ATTRIBUTE
    |--------------------------------------------------------------------------
    */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }



    /*
    |--------------------------------------------------------------------------
    | PRODUCT VARIATION ATTRIBUTES
    |--------------------------------------------------------------------------
    */
    public function productVariationAttributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'attribute_type_id');
    }

}
