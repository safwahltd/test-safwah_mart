<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Area;
use App\Traits\AutoCreatedUpdated;

class WarehouseArea extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_warehouse_areas';






    /*
     |--------------------------------------------------------------------------
     | AREA (RELATION)
     |--------------------------------------------------------------------------
    */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }



    /*
     |--------------------------------------------------------------------------
     | WAREHOUSE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }




    /*
     |--------------------------------------------------------------------------
     | DISTRICT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function district()
    {
        return $this->belongsTo(District::class);
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
