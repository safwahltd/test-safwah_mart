<?php
use Carbon\Carbon;
use Module\Product\Models\ProductSaleDiscount;


function getVat($vat, $vat_type, $sale_price, $discount)
{
    $discount = ($discount * $sale_price)/100;
    
    if($vat_type == "Percentage"){
        $vatAmount = (($sale_price - $discount) * $vat)/100;
    }else{
        $vatAmount = $vat;
    }

    return $vatAmount;
}

function getVatPercent($vat, $vat_type, $sale_price, $discount)
{
    if($vat_type == "Percentage"){
        $vatPercent = $vat;
    }else{
        if($sale_price != 0){
            $vatPercent = (100 * $vat)/$sale_price;
        }else{
            return 0;
        }
    }

    return $vatPercent;
}

