<?php

namespace Module\WebsiteCMS\Models;


use Illuminate\Database\Eloquent\Model as BaseModel;
use Skycoder\QueryShorter\QueryShorter;

class Model extends BaseModel
{
    protected $guarded = [];





    /*
     |--------------------------------------------------------------------------
     | ACTIVE SCOPE
     |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        $query->where('status', 1);
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
