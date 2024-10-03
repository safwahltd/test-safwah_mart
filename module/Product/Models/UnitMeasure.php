<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class UnitMeasure extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_unit_measures';

    protected $guarded = [];




    /*
    |--------------------------------------------------------------------------
    | PRODUCTS METHOD
    |--------------------------------------------------------------------------
    */
    public function products()
    {
        return $this->hasMany(Product::class);
    }




    /*
    |--------------------------------------------------------------------------
    | UNIT MEASURE NAME METHOD
    |--------------------------------------------------------------------------
    */
    public static function unitMeasureName($id)
    {
        $unitMeasure = UnitMeasure::select('name')->whereId($id)->first();
        !empty($unitMeasure) ? $unitMeasureName = UnitMeasure::select('name')->whereId($id)->first()->toArray() : $unitMeasureName = '';
        return $unitMeasureName;
    }

}
