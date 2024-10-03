<?php

namespace Module\Product\Services;
use Module\Product\Models\Product;
use Module\Product\Models\NextBarcodeNo;

class NextBarcodeService
{


    /*
     |--------------------------------------------------------------------------
     | SET NEXT BARCODE NO
     |--------------------------------------------------------------------------
    */
    public function setNextBarcodeNo()
    {
        NextBarcodeNo::find(1)->increment('next_no');
    }









    /*
     |--------------------------------------------------------------------------
     | GET NEXT BARCODE NO
     |--------------------------------------------------------------------------
    */
    public function getNextBarcodeNo()
    {
        $nextId = optional(NextBarcodeNo::find(1))->next_no;

        if ($nextId == null){
            $nextId = NextBarcodeNo::create([
                'next_no'          => 1,
            ])->next_id;
        }

        return 1 . str_pad($nextId, 11, "0", STR_PAD_LEFT);
    }
}
