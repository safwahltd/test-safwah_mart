<?php

namespace Module\WebsiteCMS\Models;

use App\Model;

class Banner extends Model
{

    protected $table = 'web_banners';

    protected $guarded = [];



    public function scopeApiQuery($query)
    {
        $query->active();
    }



    public function scopePromoPartOne($query)
    {
        $query->whereIn('id', [1, 2]);
    }



    public function scopePromoPartTwo($query)
    {
        $query->whereIn('id', [3, 4, 5]);
    }


    public function scopePromoPartOneThreeBanner($query)
    {
        $query->whereIn('id', [1, 2]);
    }



    public function scopePromoPartTwoOneBanner($query)
    {
        $query->whereIn('id', [4]);
    }



    public function scopePromoPartThreeThreeBanner($query)
    {
        $query->whereIn('id', [5, 6, 7]);
    }

  public function scopePromoPartFourThreeBanner($query)
    {
        $query->whereIn('id', [8, 9, 10]);
    }


}
