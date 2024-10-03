<?php

namespace App\Models;

use App\Models\CurrencyConversion;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name'];

    public function currency_conversions()
    {
        return $this->hasMany(CurrencyConversion::class);
    }
}
