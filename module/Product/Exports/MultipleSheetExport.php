<?php

namespace Module\Product\Exports;

use Module\Product\Models\Brand;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class MultipleSheetExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            0 => new BrandExport(),
            1 => new CategoryExport(),
            2 => new UnitMeasureExport(),
        ];
    }

}
