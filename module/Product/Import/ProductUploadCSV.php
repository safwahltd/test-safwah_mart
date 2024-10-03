<?php

namespace Module\Product\Import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Product\Models\ProductUpload;

class ProductUploadCSV implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new ProductUpload([
                'product_type'          => trim($row['product_type']),
                'category'              => trim($row['category']),
                'brand'                 => trim($row['brand']),
                'unit_measure'          => trim($row['unit_measure']),
                'supplier'              => trim($row['supplier']),
                'country'               => trim($row['country']),
                'name'                  => trim($row['name']),
                'slug'                  => trim($row['slug']),
                'code'                  => trim($row['code']),
                'purchase_price'        => trim($row['purchase_price']),
                'sale_price'            => trim($row['sale_price']),

                'wholesale_price'       => trim($row['wholesale_price']),
                'alert_quantity'        => trim($row['alert_quantity']),
                'maximum_order_quantity'=> trim($row['maximum_order_quantity']),
                'video_link'            => trim($row['video_link']),

                'manufacture_barcode'   => trim($row['manufacture_barcode']),
                'manufacture_model_no'  => trim($row['manufacture_model_no']),
                'est_shipping_days'     => trim($row['est_shipping_days']),
                'barcode'               => trim($row['barcode']),

                'vat'                   => trim($row['vat']),
                'vat_type'              => trim($row['vat_type']),
                'stock_visible'         => trim($row['stock_visible']),
                'sku'                   => trim($row['sku']),

                'weight'                => trim($row['weight'] ?? 0),
                'is_variation'          => trim($row['is_variation']),
                'is_refundable'         => trim($row['is_refundable'] ?? 'No'),
                'opening_quantity'      => trim($row['opening_quantity']),
                'warehouse_id'          => trim($row['warehouse_id']),
            ]);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
