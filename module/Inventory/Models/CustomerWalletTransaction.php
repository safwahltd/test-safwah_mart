<?php

namespace Module\Inventory\Models;

use App\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Order'         => Order::class,
    'Order Return'  => OrderReturn::class,
]);


class CustomerWalletTransaction extends Model
{
    protected $table = 'customer_wallet_transactions';
    




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
