<?php

namespace App\Http\Controllers;

use App\Models\PointConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pointConfigs'] = PointConfig::orderBy('id', 'DESC')->paginate(30);
        $data['table']        = PointConfig::getTableName();

        return view('point-configs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('point-configs.create');
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
            'min_purchase_amount'   => 'required|unique_with:point_configs,min_purchase_amount,max_purchase_amount,point',
            'max_purchase_amount'   => 'required|unique_with:point_configs,min_purchase_amount,max_purchase_amount,point',
            'point'                 => 'required|unique_with:point_configs,min_purchase_amount,max_purchase_amount,point',
        ]);

        try {

            PointConfig::create([
                'title'                 => $request->title,
                'min_purchase_amount'   => $request->min_purchase_amount,
                'max_purchase_amount'   => $request->max_purchase_amount,
                'point'                 => $request->point,
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('point-configs.index')->withMessage('Point Config has been created successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('point-configs.edit', ['pointConfig' => PointConfig::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pointConfig = PointConfig::find($id);

        $request->validate([
            'min_purchase_amount'   => 'required|unique_with:point_configs,min_purchase_amount,max_purchase_amount,point,'.$pointConfig->id,
            'max_purchase_amount'   => 'required|unique_with:point_configs,min_purchase_amount,max_purchase_amount,point,'.$pointConfig->id,
            'point'                 => 'required|unique_with:point_configs,min_purchase_amount,max_purchase_amount,point,'.$pointConfig->id,
        ]);

        try {

            $pointConfig->update([
                'title'                 => $request->title,
                'min_purchase_amount'   => $request->min_purchase_amount,
                'max_purchase_amount'   => $request->max_purchase_amount,
                'point'                 => $request->point,
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('point-configs.index')->withMessage('Point Config has been updated successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            PointConfig::destroy($id);

            return redirect()->route('point-configs.index')->withMessage('Point Config has been deleted successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Point Config');
        }
    }
}
