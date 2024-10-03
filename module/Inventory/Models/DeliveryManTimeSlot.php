<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Module\Inventory\Models\DeliveryMan;
use Module\Inventory\Models\TimeSlot;

class DeliveryManTimeSlot extends Model
{
    use HasFactory;

    protected $table = 'delivery_man_time_slots';

    protected $guarded = [];




    /*
     |--------------------------------------------------------------------------
     | TIME SLOT
     |--------------------------------------------------------------------------
    */
    public function time_slot()
    {
        return $this->belongsTo(TimeSlot::class);
    }




    /*
     |--------------------------------------------------------------------------
     | DELIVERY MAN
     |--------------------------------------------------------------------------
    */
    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class);
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
