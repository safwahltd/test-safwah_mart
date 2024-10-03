<?php

namespace Module\WebsiteCMS\Models;

use App\Model;
use Module\WebsiteCMS\Models\Page;

class PageSection extends Model
{
    protected $table = 'web_page_sections';

    protected $guarded = [];



    public function scopeApiQuery($query)
    {
        $query;
    }




    public static function getTableName()
    {
        return with(new static)->getTable();
    }




    public function page()
    {
        return $this->belongsTo(Page::class);
    }




}
