<?php

namespace Module\Inventory\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Inventory\Models\ProductUpload;

class ProductImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {

        return new ProductUpload([
            'product_type_id'                       => trim($row['product_type_id']),
            'category_id'                           => trim($row['category_id']),
            'sub_category_id'                       => trim($row['sub_category_id']),
            'brand_id'                              => trim($row['manufacturer_id']),
            'medicine_type_id'                      => trim($row['form_id']),
            'generic_name_id'                       => trim($row['generic_name_id']),
            'power_id'                              => trim($row['power_id']),
            'medicine'                              => trim($row['medicine']),
            'name'                                  => trim($row['brand_name']),
            'slug'                                  => trim($row['slug']),
            'sku'                                   => trim($row['sku']),
            'purchase_price'                        => trim($row['purchase_price']),
            'purchase_discount_in_percentage'       => trim($row['purchase_discount_in_percentage']),
            'sales_price'                           => trim($row['sales_price']),
            'sales_discount_in_percentage'          => trim($row['sales_discount_in_percentage']),
            'vat_applicable'                        => trim($row['vat_applicable']),
            'pcs_per_stips'                         => trim($row['pcs_per_stips']),
            'stips_per_box'                         => trim($row['stips_per_box']),
            'alert_quantity'                        => trim($row['alert_quantity']),
            'refundable'                            => trim($row['refundable']),
            'barcode'                               => trim($row['barcode']),
            'status'                                => trim($row['status']),
            'description'                           => trim($row['description']),
            'safety_advises'                        => trim($row['safety_advises']),
            'medicine_overview'                     => trim($row['medicine_overview']),
            'quick_tips'                            => trim($row['quick_tips']),
            'disclaimer'                            => trim($row['disclaimer']),
            'country_id'                            => trim($row['country_id']),
            'mfg_date'                              => trim($row['mfg_date']),
            'mfg_licence_no'                        => trim($row['mfg_licence_no']),
            'dar_ma_product_licence'                => trim($row['dar_ma_product_licence']),
            'expiry_date'                           => trim($row['expiry_date']),
            'quantity'                              => trim($row['quantity']),
            'small_unit'                            => trim($row['small_unit']),
            'big_unit'                              => trim($row['big_unit']),
            'created_by'                            => trim($row['created_by']),
            'updated_by'                            => trim($row['updated_by']),
        ]);
    }
}
