<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class Attribute extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_attributes';

    protected $guarded = [];


        /*
    |--------------------------------------------------------------------------
    | PRODUCTS ATTRIBUTE TYPE
    |--------------------------------------------------------------------------
    */
    public function attributeType()
    {
        return $this->belongsTo(AttributeType::class);
    }

}
