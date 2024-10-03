<?php

namespace Module\WebsiteCMS\Models;

use App\Model;

class InstructionNote extends Model
{
    protected $table = 'web_instruction_notes';


    public function scopeApiQuery($query)
    {
        $query;
    }




    public static function getTableName()
    {
        return with(new static)->getTable();
    }



}
