<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Module\WebsiteCMS\Models\Testimonial;

class Country extends Model
{
    protected $fillable = ['id', 'name'];




    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

}
