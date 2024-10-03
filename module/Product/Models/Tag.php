<?php

namespace Module\Product\Models;

use App\Model;

class Tag extends Model
{
    protected $table = 'pdt_tags';

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




    public function scopeApiQuery($query)
    {
        $query;
    }


}
