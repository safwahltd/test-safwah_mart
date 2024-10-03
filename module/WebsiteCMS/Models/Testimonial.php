<?php

namespace Module\WebsiteCMS\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;


    protected $table = 'web_testimonials';

    protected $guarded = [];


    public function scopeApiQuery($query)
    {
        $query->active();
    }



    /*
     |--------------------------------------------------------------------------
     | country
     |--------------------------------------------------------------------------
    */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
