<?php

namespace App\Models;

use App\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Module\Account\Models\Customer;
use Module\Inventory\Models\DeliveryMan;

class District extends Model
{
    use HasFactory;

    protected $table   = 'districts';

    protected $guarded = [];


    public function customers(){
        return $this->hasMany(Customer::class, 'customer_id');
    }


    public function areas()
    {
        return $this->hasMany(Area::class);
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

}
