<?php

namespace Module\Product\Models;
use App\Traits\AutoCreatedUpdated;

use App\Model;
use App\Models\User;

class ProductUser extends Model
{

    protected $table = 'pdt_product_users';


    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }




}
