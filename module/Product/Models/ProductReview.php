<?php

namespace Module\Product\Models;

use App\Model;
use App\Models\User;

class ProductReview extends Model
{
    protected $table = 'pdt_product_reviews';

    public function user()
    {
        return $this->belongsTo(User::class);
    }




    

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
