<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class WeightWiseExtraShippingCost extends Model
{
    use AutoCreatedUpdated;
    
    protected $table = 'inv_weight_wise_extra_shipping_costs';


    public function orders()
    {
        return $this->hasMany(Order::class, 'extra_shipping_cost_id');
    }
}
