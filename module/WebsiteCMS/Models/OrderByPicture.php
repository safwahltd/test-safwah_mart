<?php

namespace Module\WebsiteCMS\Models;

use App\Model;

class OrderByPicture extends Model
{
    protected $table = 'web_order_by_pictures';

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
