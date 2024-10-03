<?php

namespace Module\WebsiteCMS\Models;

use App\Traits\AutoCreatedUpdated;

class SocialLink extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'web_social_links';

    protected $guarded = [];


    public function scopeApiQuery($query)
    {
        $query->active();
    }
}
