<?php

namespace App\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class EcomSetting extends Model
{
    use AutoCreatedUpdated;

    
    public function scopeApiQuery($query)
    {
        $query;
    }

}
