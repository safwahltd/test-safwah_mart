<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class ProductSaleDiscount extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_product_discounts';

    protected $guarded = [];

}
