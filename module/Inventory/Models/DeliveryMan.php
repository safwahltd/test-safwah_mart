<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Area;
use App\Models\District;
use App\Models\User;
use Module\Inventory\Models\TimeSlot;
use Module\Inventory\Models\DeliveryManTimeSlot;
use App\Traits\AutoCreatedUpdated;

class DeliveryMan extends Model
{

    protected $table = 'inv_delivery_mans';

    protected $guarded = [];



    public function delivery_man_time_slots()
    {
        return $this->hasMany(DeliveryManTimeSlot::class);
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function district()
    {
        return $this->belongsTo(District::class);
    }



    public function area()
    {
        return $this->belongsTo(Area::class);
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER METHOD
     |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->hasMany(Order::class);
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


}
