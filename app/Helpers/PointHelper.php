<?php

use App\Models\PointConfig;
use App\Models\PointSetting;

function getPoint($amount)
{
    $pointConfig    = PointConfig::query()
                    ->where('min_purchase_amount','<=', $amount)
                    ->where('max_purchase_amount','>=', $amount)
                    ->select('point', 'status')
                    ->first();

    $point = 0;

    if ($pointConfig) {
        $point = $pointConfig->status == 1 ? $pointConfig->point : 0;
    }
    
    return $point;
}


function requirePoint($amount)
{
    $pointSetting = PointSetting::find(1);

    $requirePoint = 0;

    if ($pointSetting) {
        $requirePoint = $amount / $pointSetting->value;
    }

    return $requirePoint;
}

