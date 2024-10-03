<?php

use Module\Product\Models\ProductVariation;






function generateSKU()
{
    $productVariation = ProductVariation::select('sku')->orderBy('id', 'DESC')->first();

    !empty($productVariation->sku)
    ? $newSKU = (int) $productVariation->sku + 1
    : $newSKU = 10000000;

    return $newSKU;
}
