<?php

namespace Module\WebsiteCMS\Models;

use App\Traits\AutoCreatedUpdated;

class Faq extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'web_faqs';

    protected $guarded = [];


}
