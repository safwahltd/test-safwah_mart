<?php

namespace App\Http\Controllers;

use App\Models\IdCardSetting;
use App\Models\Company;
use App\Traits\CheckPermission;
use App\Traits\FileSaver;
use Illuminate\Http\Request;

class IdCardSettingController extends Controller
{
    use CheckPermission, FileSaver;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->hasAccess("id.card.settings.index");     // check permission

        $idCardSettings = IdCardSetting::with('company')->get();

        return view('global.id-card-settings.index', compact('idCardSettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::userCompanies();

        return view('global.id-card-settings.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id'    => 'required|unique:id_card_settings,company_id',
            'mobile'        => 'required',
            'address'       => 'required',
            'logo'          => 'required',
            'signature'     => 'required',
        ]);

        try {

            $created = IdCardSetting::create($request->except(['logo', 'signature', 'group_logo']));

            $this->upload_file($request->logo, $created, 'logo', 'uploads/id-card-settings') ;
            $this->upload_file($request->signature, $created, 'signature', 'uploads/id-card-settings');
            $this->upload_file($request->group_logo, $created, 'group_logo', 'uploads/id-card-settings');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
        return redirect()->back()->with('message', 'Setting Created Successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IdCardSetting  $idCardSetting
     * @return \Illuminate\Http\Response
     */
    public function show(IdCardSetting $idCardSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IdCardSetting  $idCardSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(IdCardSetting $idCardSetting)
    {
        return view('global.id-card-settings.edit', compact('idCardSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IdCardSetting  $idCardSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdCardSetting $idCardSetting)
    {
        $request->validate([
            'mobile'        => 'required',
            'address'       => 'required',
        ]);

        try {

            $idCardSetting->update($request->except(['logo', 'signature', 'group_logo']));

            $this->upload_file($request->logo, $idCardSetting, 'logo', 'uploads/id-card-settings');
            $this->upload_file($request->signature, $idCardSetting, 'signature', 'uploads/id-card-settings');
            $this->upload_file($request->group_logo, $idCardSetting, 'group_logo', 'uploads/id-card-settings');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->back()->with('message', 'Setting Edited Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IdCardSetting  $idCardSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdCardSetting $idCardSetting)
    {
        //
    }
}
