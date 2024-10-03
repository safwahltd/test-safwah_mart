<?php

namespace Module\WebsiteCMS\Models;

use App\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class SubscribersContent extends Model
{
    use HasFactory;

    protected $table = 'web_subscribers_content';

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
