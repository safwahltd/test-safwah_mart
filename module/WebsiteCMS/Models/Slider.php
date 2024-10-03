<?php

namespace Module\WebsiteCMS\Models;

use App\Traits\AutoCreatedUpdated;

class Slider extends Model
{
    use AutoCreatedUpdated;


    protected $table = 'web_sliders';

    protected $guarded = [];


    public function scopeApiQuery($query)
    {
        $query->active();
    }




    public function getImageAttribute()
    {
        $image = $this->attributes['image'];

        if (file_exists(public_path($image))) {
            return $image;
        }else{
            return './default-slider.webp';
        }

    }
}
