<?php

namespace Module\Inventory\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Module\Inventory\Models\MedicineType;

class MedicineTypeExport implements FromCollection, WithHeadings, ShouldAutoSize
{




    /*
     |--------------------------------------------------------------------------
     | COLLECTION METHOD
     |--------------------------------------------------------------------------
    */
    public function collection()
    {
        return MedicineType::select(
            'id',
            'name',
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
            'Status',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
}
