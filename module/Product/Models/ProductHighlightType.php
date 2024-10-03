<?php

namespace Module\Product\Models;

use App\Model;

class ProductHighlightType extends Model
{
    protected $table = 'pdt_product_highlight_types';




    
    /*
     |--------------------------------------------------------------------------
     | HIGHLIGHT TYPE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function highlightType()
    {
        return $this->belongsTo(HighlightType::class, 'highlight_type_id');
    }





      /*
     |--------------------------------------------------------------------------
     | PRODUCT PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
