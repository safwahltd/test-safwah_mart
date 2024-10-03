<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Traits\CheckPermission;
use App\Traits\FileSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CompanySettingController extends Controller
{
    use CheckPermission, FileSaver;




    /*
     |--------------------------------------------------------------------------
     | UPDATE COMPANY SETTING METHOD
     |--------------------------------------------------------------------------
    */
    public function updateCompanySetting(Request $request, $id)
    {
        $request->validate([

            'name'          => 'required|min:2',
            'phone'         => 'required',
            // 'hotline'       => 'required',
            'email'         => 'required|email',
        ]);




        try {

            DB::transaction(function () use ($request, $id) {

                $company = Company::find($id);

                Company::whereId($id)->update([

                    'name'                      => $request->name,
                    'title'                     => $request->title,
                    'phone'                     => $request->phone,
                    'hotline'                   => $request->hotline,
                    'email'                     => $request->email,
                    'address'                   => $request->address,
                    'bill_footer'               => $request->bill_footer,
                    'logo'                      => $company->logo,
                    'favicon_icon'              => $company->favicon_icon,
                    'bin'                       => $request->bin,
                    'musak'                     => $request->musak,
                    'website'                   => $request->website,
                    'google_map_embed_code'     => $request->google_map_embed_code,
                    'app_link'                  => $request->app_link,
                    'ios_link'                  => $request->ios_link,
                    'meta_keyword'              => $request->meta_keyword,
                    'meta_description'          => $request->meta_description,
                    'logo_alt_text'             => $request->logo_alt_text,

                ]);

                if($request->filled('has_login_registration_meta')) {

                    Company::whereId($id)->update([
                        'login_alt_text'                => $request->login_alt_text,
                        'login_meta_title'              => $request->login_meta_title,
                        'login_meta_description'        => $request->login_meta_description,

                        'registration_alt_text'         => $request->registration_alt_text,
                        'registration_meta_title'       => $request->registration_meta_title,
                        'registration_meta_description' => $request->registration_meta_description
                    ]);
                }

                $this->uploadFileWithResize($request->logo, $company, 'logo', 'images', 220, 60);
                $this->uploadFileWithResize($request->favicon_icon, $company, 'favicon_icon', 'images/icon', 50, 50);

            });

            return redirect()->back()->withMessage('Company Setting Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
