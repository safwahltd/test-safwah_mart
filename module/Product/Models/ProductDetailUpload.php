<?php

namespace Module\Product\Models;

use App\Model;
use Module\Inventory\Models\Warehouse;

class ProductDetailUpload extends Model
{
    protected $table = 'pdt_product_detail_uploads';

    public function productUpload()
    {
        return $this->belongsTo(ProductUpload::class, 'product_upload_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
