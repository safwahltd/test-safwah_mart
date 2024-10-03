<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class ReturnReason extends Model
{
    use AutoCreatedUpdated;
    
    protected $table = 'inv_return_reasons';
}
