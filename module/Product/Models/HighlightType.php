<?php

namespace Module\Product\Models;

use App\Model;

class HighlightType extends Model
{

    protected $table = 'pdt_highlight_types';

    protected $guarded = [];




    /*
     |--------------------------------------------------------------------------
     | PRODUCT HIGHLIGHT TYPES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productHighlightTypes()
    {
        return $this->hasMany(ProductHighlightType::class);
    }




    
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
