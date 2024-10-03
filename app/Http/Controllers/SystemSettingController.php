<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systemSettings = SystemSetting::get(['id', 'key', 'value']);

        return view('global.system.index', compact('systemSettings'));
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
            'key.general_store_reference_title'     => 'nullable|max:191',
            'key.out_work_date_picker'              => 'nullable|numeric',
            'key.employee_summary_gross_salary_get' => 'nullable|numeric',
            'key.finger_id_get'                     => 'nullable|numeric',
            'key.employee_list_card_no'             => 'nullable|numeric',
            'key.custom_employee_full_id'           => 'nullable|numeric',
            'key.employee_login_option'             => 'nullable|numeric',
            'key.employee_attendance_chart'         => 'nullable|numeric',
            'key.dashboard'                         => 'nullable|numeric',
        ]);


        foreach ($request->key as $key => $value){

            SystemSetting::where('key', $key)->update([

                'value' => $value

            ]);

        }

        return redirect()->back()->with('message', 'System Setting Update Successful');

    }
}
