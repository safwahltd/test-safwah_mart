<?php

namespace Module\Product\Import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Product\Models\ProductDetailUpload;

class ProductUploadDetailCSV implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new ProductDetailUpload([
                'product_upload_id'         => trim($row['product_upload_id']),
                'name'                => trim($row['name']),
                'sku'                 => generateSKU(),
                'purchase_price'      => trim($row['purchase_price']),
                'sale_price'          => trim($row['sale_price']),
                'opening_stock'       => trim($row['opening_quantity'] ?? 0),
                'warehouse_id'        => trim($row['warehouse_id']),

            ]);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
