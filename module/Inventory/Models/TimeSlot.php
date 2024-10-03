<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Inventory\Models\DeliveryManTimeSlot;

class TimeSlot extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'time_slots';





    public function scopeApiQuery($query)
    {
        $query->active();
    }
    




    public function deliveryManTimeSlots()
    {
        return $this->hasMany(DeliveryManTimeSlot::class);
    }
    


    

    /*
     |--------------------------------------------------------------------------
     | GET TABLE NAME
     |--------------------------------------------------------------------------
    */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }



    public function orders()
    {
        return $this->hasMany(Order::class, 'time_slot_id');
    }
}
