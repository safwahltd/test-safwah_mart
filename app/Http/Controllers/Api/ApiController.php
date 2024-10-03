<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use App\Models\Company;
use App\Models\District;
use App\Models\EcomSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Module\WebsiteCMS\Services\JsonResponseService;

class ApiController extends Controller
{
    private $jsonResponseService;








    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT
     |--------------------------------------------------------------------------
    */
    public function __construct(JsonResponseService $jsonResponseService)
    {
        $this->jsonResponseService = $jsonResponseService;
    }









    //------------------------------------------------------------------//
    //                      GET SOCIALITE USER                          //
    //------------------------------------------------------------------//
    public function getSocialiteUser($social_provider)
    {

        try{

            $data = User::where('social_provider', $social_provider)->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }

    }





     /*
     |--------------------------------------------------------------------------
     | COMPANY INFO
     |--------------------------------------------------------------------------
    */
    public function getCompany()
    {
        return $this->jsonResponseService->find(Company::query(), 'company');
    }







     /*
     |--------------------------------------------------------------------------
     | GET PAGE SECTION ECOM SETTINGS
     |--------------------------------------------------------------------------
    */
    public function getPageSectionEcomSettings()
    {
        return $this->jsonResponseService->get(EcomSetting::query()->whereBetween('id',[6,32])->orWhere('id',35)->orWhere('id',53)->select('id','title','value'), 'pageSectionEcomSettings');
    }








     /*
     |--------------------------------------------------------------------------
     | GET ECOM SETTINGS
     |--------------------------------------------------------------------------
    */
    public function getEcomSettings()
    {
        return $this->jsonResponseService->get(EcomSetting::query()->whereBetween('id',[1,5])->orWhere('id',33)->select('id','title','value'), 'ecomSettings');
    }







     /*
     |--------------------------------------------------------------------------
     | COMPANY INFO
     |--------------------------------------------------------------------------
    */
    public function getDritricts()
    {
    //    return $this->jsonResponseService->get(District::query()->orderBy('name','ASC'), 'districts');
       $data['districts'] = $this->jsonResponseService->get(District::query()->orderBy('name','ASC'), 'districts');

       $data['ecom'] = $this->jsonResponseService->find(EcomSetting::query()->where('id', 1), 'ecom');
       return $data;

    }





      /*
     |--------------------------------------------------------------------------
     | COMPANY INFO
     |--------------------------------------------------------------------------
    */
    public function getAreas($district_id)
    {
        return $this->jsonResponseService->get(Area::query()->where('district_id', $district_id)->select('id','district_id','name','min_purchase_amount','free_delivery_amount')->orderBy('name','ASC'), 'areas');
    }
}
