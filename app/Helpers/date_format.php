<?php
use Carbon\Carbon;
function fdate($value, $format = null)
{
    if ($value == '') {
        return '';
    }

    if ($format == null) {
        $format = 'Y-m-d';
    }
    return \Carbon\Carbon::parse($value)->format($format);
}

function totalDaysInMonth($month)
{
    return Carbon::parse($month)->addMonth(1)->subDay(1)->format('d');
    // return cal_days_in_month(CAL_GREGORIAN, Carbon::parse($month)->format('m'), Carbon::parse($month)->format('Y'));
}
