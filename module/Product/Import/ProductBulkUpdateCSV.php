<?php

namespace Module\Product\Import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Product\Models\Product;

class ProductBulkUpdateCSV implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $product =  Product::where(function ($q) use ($row) {
                            $q->where('id', trim($row['id']))
                            ->orWhere('sku', trim($row['sku']));
                        })
                        ->first();

            $product->updateOrCreate(['id' => $product->id],[
                'purchase_price'    => trim($row['purchase_price']) ?? 0,
                'wholesale_price'   => trim($row['wholesale_price']) ?? 0,
                'sale_price'        => trim($row['sale_price']) ?? 0,
            ]);
            
            $product = $product->refresh();

            return $product;
            
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
