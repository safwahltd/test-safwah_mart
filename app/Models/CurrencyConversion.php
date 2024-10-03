<?php

namespace App\Models;

use App\Model;
use App\Models\Currency;
use App\Traits\AutoCreatedUpdated;

class CurrencyConversion extends Model
{
    use AutoCreatedUpdated;

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
