<?php

namespace Module\Inventory\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Module\Inventory\Models\Tag;

class TagExport implements FromCollection, WithHeadings, ShouldAutoSize
{




    /*
     |--------------------------------------------------------------------------
     | COLLECTION METHOD
     |--------------------------------------------------------------------------
    */
    public function collection()
    {
        return Tag::select(
            'id',
            'name',
            'slug',
            'title',
            'is_highlight',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        )->get();
    }




    /*
     |--------------------------------------------------------------------------
     | HEADINGS METHOD
     |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Slug',
            'Title',
            'Is Highlight',
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
}
