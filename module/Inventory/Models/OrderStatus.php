<?php

namespace Module\Inventory\Models;
use App\Traits\AutoCreatedUpdated;

use App\Model;

class OrderStatus extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_order_statuses';

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
