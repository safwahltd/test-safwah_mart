<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;

use App\Models\EcomSetting;
use App\Traits\FileSaver;
use Illuminate\Http\Request;

class EcomSettingController extends Controller
{

    use FileSaver;


    public function updateEcomSetting(Request $request)
    {

        try {


            $ecomSettings = $request->except('_token','_method');
            foreach ($ecomSettings['id'] as $idKey => $ecomId) {

                if (isset($ecomSettings['value'][$ecomId])) {

                    if ($ecomId == 1) {
                        EcomSetting::find(1)->update([ 'value' => $ecomSettings['value'][1] ]);
                    }
                    elseif ($ecomId == 33) {
                        EcomSetting::find(33)->update([ 'value' => $ecomSettings['value'][33] ]);
                    }
                    elseif ($ecomId == 2) {
                        EcomSetting::find(2)->update([ 'value' => $ecomSettings['value'][2] ]);
                    }
                    elseif ($ecomId == 34) {
                        EcomSetting::find(34)->update([ 'value' => $ecomSettings['value'][34] ]);
                    }
                    elseif ($ecomId == 3) {
                        EcomSetting::find(3)->update([ 'value' => 'on' ]);
                        EcomSetting::find(4)->update([ 'value' => 'off' ]);
                    }
                    elseif ($ecomId == 4) {
                        EcomSetting::find(4)->update([ 'value' => 'on' ]);
                        EcomSetting::find(3)->update([ 'value' => 'off' ]);
                    }
                    elseif ($ecomId == 5) {
                        $loaderImage = EcomSetting::find(5);
                        $this->upload_file($ecomSettings['value'][5], $loaderImage, 'value', 'images/loader-img');
                    }
                    else{
                        EcomSetting::find($ecomId)->update([ 'value' => 'on' ]);
                    }
                }
                else{
                    if($ecomId == 1 || $ecomId == 2 || $ecomId == 3 || $ecomId == 4 || $ecomId == 5){
                        continue;
                    }
                    else{
                        EcomSetting::find($ecomId)->update([ 'value' => 'off' ]);
                    }
                }

            }


            return redirect()->back()->withMessage('Ecom Setting Successfully Updated');

        } catch(\Exception $ex) {


            return redirect()->back()->withError($ex->getMessage());
        }
    }


}
