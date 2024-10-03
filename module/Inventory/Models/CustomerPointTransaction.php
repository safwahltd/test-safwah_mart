<?php

namespace Module\Inventory\Models;

use App\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Order'         => Order::class,
    'Order Return'  => OrderReturn::class,
]);


class CustomerPointTransaction extends Model
{
    protected $table = 'customer_point_transactions';
    




    /*
     |--------------------------------------------------------------------------
     | TRANSACTIONABLE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function transactionable()
    {
        return $this->morphTo();
    }
}
