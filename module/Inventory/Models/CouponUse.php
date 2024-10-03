<?php

namespace Module\Inventory\Models;

use App\Model;
use Module\Account\Models\Customer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Module\Inventory\Models\Order;

Relation::morphMap([
    'Order' => Order::class,
]);

class CouponUse extends Model
{
    protected $table = 'inv_coupon_uses';

    


    /*
     |--------------------------------------------------------------------------
     | SOURCABLE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function sourcable()
    {
        return $this->morphTo();
    }

    


    /*
     |--------------------------------------------------------------------------
     | COUPON (RELATION)
     |--------------------------------------------------------------------------
    */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    


    /*
     |--------------------------------------------------------------------------
     | CUSTOMER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
