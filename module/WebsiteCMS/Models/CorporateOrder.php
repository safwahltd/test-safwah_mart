<?php

namespace Module\WebsiteCMS\Models;

use App\Model;


class CorporateOrder extends Model
{
    protected $table = 'web_corporate_orders';

    protected $guarded = [];



    public function scopeApiQuery($query)
    {
        $query;
    }




    public static function getTableName()
    {
        return with(new static)->getTable();
    }



}
