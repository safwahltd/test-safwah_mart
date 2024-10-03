<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class Customer extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'acc_customers';





    /*
     |--------------------------------------------------------------------------
     | USER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }





    /*
     |--------------------------------------------------------------------------
     | REFFERED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function refferedBy()
    {
        return $this->belongsTo(User::class, 'reffered_by');
    }





    /*
     |--------------------------------------------------------------------------
     | CUSTOMER TYPE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customer_type()
    {
        return $this->belongsTo(CustomerType::class);
    }



    /*
     |--------------------------------------------------------------------------
     | WAREHOUSE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }



    public function scopeApiQuery($query)
    {
        $query->active();
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




    /*
     |--------------------------------------------------------------------------
     | ORDERS RELATION  
     |--------------------------------------------------------------------------
    */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
