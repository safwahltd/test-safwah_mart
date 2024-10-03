<?php

namespace App\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Product\Models\StockSummary;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use AutoCreatedUpdated, HasFactory;

    protected $table = 'products';

    protected $guarded = [];

    public function stockSummaries()
    {
        return $this->hasMany(StockSummary::class);
    }
}
