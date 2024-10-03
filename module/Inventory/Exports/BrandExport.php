<?php

namespace Module\Inventory\Exports;

use Module\Product\Models\Brand;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BrandExport implements FromCollection, WithHeadings, ShouldAutoSize
{




    /*
     |--------------------------------------------------------------------------
     | COLLECTION METHOD
     |--------------------------------------------------------------------------
    */
    public function collection()
    {
        return Brand::select('id', 'name', 'slug', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at')->get();
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
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
}
