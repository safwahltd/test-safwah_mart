<?php

namespace Module\WebsiteCMS\Models;

use Module\WebsiteCMS\Models\MenuCategory;

class Post extends Model
{

    protected $table = 'web_posts';

    protected $guarded = [];



    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }



    public function post_categories()
    {
        return $this->belongsToMany(MenuCategory::class, 'post_categories','post_id','category_id');
    }
}
