<?php

namespace Module\WebsiteCMS\Models;

use App\Model;
use App\Models\User;
use Module\Product\Models\Product;

class Wishlist extends Model
{

    protected $table = 'web_wishlists';

    protected $guarded = [];

    

    public function scopeApiQuery($query)
    {
        $query->active();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
