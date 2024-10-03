<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class OrderAmountWiseShippingCostDiscount extends Model
{
    use AutoCreatedUpdated;
    
    protected $table = 'inv_order_amount_wise_shipping_cost_discounts';


    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_cost_discount_id');
    }
}
