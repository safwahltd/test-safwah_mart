<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class ProductAttribute extends Model
{
    use AutoCreatedUpdated;
    
    protected $guarded = [];

    protected $table = 'pdt_product_attributes';
}
