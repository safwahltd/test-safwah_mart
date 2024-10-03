<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;


class Barcode extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_product_barcodes';
}
