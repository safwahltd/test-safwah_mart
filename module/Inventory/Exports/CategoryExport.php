<?php

namespace Module\Inventory\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Module\Inventory\Models\Category;

class CategoryExport implements FromCollection, WithHeadings, ShouldAutoSize
{




    /*
     |--------------------------------------------------------------------------
     | COLLECTION METHOD
     |--------------------------------------------------------------------------
    */
    public function collection()
    {
        return Category::select(
            'id',
            'name',
            'slug',
            'title',
            'image',
            'is_highlight',
            'show_on_menu',
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
            'Image',
            'Is Highlight',
            'Show on Menu',
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
}
