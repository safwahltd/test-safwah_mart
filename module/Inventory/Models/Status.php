<?php

namespace Module\Inventory\Models;

use App\Model;

class Status extends Model
{
    protected $table = 'inv_statuses';


    public function order_status(){
        return $this->hasMany(OrderStatus::class);
    }
    
}
