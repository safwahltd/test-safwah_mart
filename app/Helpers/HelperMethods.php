<?php

use App\Models\EcomSetting;
use Illuminate\Support\Str;
use NumberToWords\NumberToWords;
use Module\Account\Models\Transaction;
use Illuminate\Support\Facades\Storage;



function getFile($path = null)
    {
        if ($path == null) {
            return '';
        }
        try {
            // return '';
            return Storage::cloud()->url($path);
        } catch (\Exception $ex) {
            return '';
        }
    }

function oldSelect($field_name, $value, $defaultValue = null): string
{
    return old($field_name, $defaultValue) == $value ? 'selected' : '';
}

function requestSelect($field_name, $value, $defaultValue = null): string
{
    return request($field_name, $defaultValue) == $value ? 'selected' : '';
}

function currencyToWords($num): string
{
    return str_replace('-',' ',(new NumberToWords)->getCurrencyTransformer('en')->toWords(str_contains($num, '.') ? ((double)$num * 100) : $num, 'USD'));
}

function inWords($amount): string
{
    $f = new NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT );

    return ucwords(str_replace('-',' ', $f->format($amount)));
}

function updateEmploymentPosition($request, $model)
{
    $oldModel = clone($model);

    $data = $model->with('employee.active_employment')->latest()->take(300)->whereDoesntHave('position')->get();

    $count = 0;

    foreach ($data as $key => $item) {
        $item->update([
            'position_id' => optional(optional($item->employee)->active_employment)->id
        ]);
        $count++;
    }

    if ($count > 0) {
        $nextCount = $oldModel->whereDoesntHave('position')->count();
        $message = $count . ' Employment position updated. ';

        if ($nextCount > 300) {
            return $message . ' Reload for next 300 from ' . $nextCount;
        } else if($nextCount > 0) {
            return $message . ' Reload for last ' . $nextCount;
        }
    }

    return '';
}


function getValidationErrorMessage($name)
{
    return view('partials._error-message', ['name' => $name])->render();
}



function hasField($path)
{
    try {
        return config($path);
    } catch (\Exception $th) {
        return 1;
    }
}

function str_slug($title)
{
    return Str::slug($title);
}

function isSystemAdmin()
{
    return auth()->id() == 1;
}

function getOldValue($name)
{
    return request($name, old($name));
}






/*
 |--------------------------------------------------------------------------
 | GET VAT PERCENT
 |--------------------------------------------------------------------------
*/
function getVatPercent1()
{
    $ecomSetting    = EcomSetting::find(1);
    $vatPercent     = 0;

    if ($ecomSetting) {
        $vatPercent = $ecomSetting->value;
    }

    return $vatPercent;
}






/*
 |--------------------------------------------------------------------------
 | WAREHOUSE ID
 |--------------------------------------------------------------------------
*/
function warehouseId()
{
    return request()->warehouse_id ?? optional(auth()->user())->warehouse_id;
}




function isProductCreate()
{
    if (session()->has('productCreate') && session()->get('productCreate') == 'yes') {
        return 'yes';
    }

    return 'no';
}