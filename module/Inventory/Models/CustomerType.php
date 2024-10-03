<?php

namespace Module\Inventory\Models;

use App\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerType extends Model
{
    use HasFactory;

    protected $table = 'acc_customer_types';

    protected $guarded = [];






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
     | CUSTOMERS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }



    public function scopeApiQuery($query)
    {
        $query;
    }


}
