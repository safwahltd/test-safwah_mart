<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class Coupon extends Model
{
    use AutoCreatedUpdated;
    
    protected $table = 'inv_coupons';
    
    public function scopeApiQuery($query)
    {
        $query->active();
    }



    public function couponUses()
    {
        return $this->hasMany(CouponUse::class);
    }
   
}
