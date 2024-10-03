<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Area;
use App\Models\District;

class OrderCustomerInfo extends Model
{

    protected $table = 'inv_order_customer_infos';





    /*
     |--------------------------------------------------------------------------
     | ORDER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }





    /*
     |--------------------------------------------------------------------------
     | DISTRICT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }





    /*
     |--------------------------------------------------------------------------
     | AREA (RELATION)
     |--------------------------------------------------------------------------
    */
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }






    /*
     |--------------------------------------------------------------------------
     | RECEIVER DISTRICT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function receiverDistrict()
    {
        return $this->belongsTo(District::class, 'receiver_district_id');
    }





    /*
     |--------------------------------------------------------------------------
     | RECEIVER AREA (RELATION)
     |--------------------------------------------------------------------------
    */
    public function receiverArea()
    {
        return $this->belongsTo(Area::class, 'receiver_area_id');
    }
}
