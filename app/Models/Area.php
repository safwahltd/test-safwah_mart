<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Model;
use Module\Inventory\Models\OrderCustomerInfo;
use Module\Inventory\Models\WarehouseArea;

class Area extends Model
{
    use HasFactory;


    protected $table   = 'areas';

    protected $guarded = [];


    public function warehouse_areas(){
        return $this->hasMany(WarehouseArea::class);
    }


    public function customers(){
        return $this->hasMany(Customer::class, 'customer_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }





    public function delivery_mans()
    {
        return $this->hasMany(DeliveryMan::class);
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





    public function scopeApiQuery($query)
    {
        $query;
    }



    public function customerAreas()
    {
        return $this->hasMany(OrderCustomerInfo::class, 'area_id');
    }



    public function receiverAreas()
    {
        return $this->hasMany(OrderCustomerInfo::class, 'receiver_area_id');
    }
}
