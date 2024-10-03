<?php

namespace Module\WebsiteCMS\Models;
use App\Traits\AutoCreatedUpdated;
use App\Model;
use Module\WebsiteCMS\Models\PageSection;

class Page extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'web_pages';

    public function scopeShowInQuickLinks($query)
    {
        $query->where('show_in_quick_links', 1);
    }


    public function page_section()
    {
        return $this->hasOne(PageSection::class);
    }


}
