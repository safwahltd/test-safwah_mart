<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\HighlightType;
use App\Traits\CheckPermission;

class HighlightTypeController extends Controller
{
    use CheckPermission;

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("highlight-types.index");

        $data['highlightTypes']      = HighlightType::query()
                                        ->searchByField('name')
                                        ->latest()
                                        ->paginate(30);

        $data['table']      = HighlightType::getTableName();

        return view('highlight-types.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("highlight-types.create");

        return view('highlight-types.create');
    }








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        try {

            DB::transaction(function () use ($request) {

                HighlightType::create([
                    'name'              => $request->name,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'created_by'        => auth()->id(),

                ]);

            });

            return redirect()->route('pdt.highlight-types.index')->withMessage('Highlight Types Successfully Created');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("highlight-types.edit");

        $data['highlightType']      = HighlightType::findOrFail($id);


        return view('highlight-types.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $highlightType = HighlightType::find($id);

        try {

            DB::transaction(function () use ($request, $highlightType) {

                $highlightType->update([
                    'name'              => $request->name,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'updated_by'        => auth()->id()
                ]);

            });

            return redirect()->route('pdt.highlight-types.index')->withMessage('Highlight Types Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("highlight-types.delete");

        $highlightType = HighlightType::find($id);

        $highlightType->destroy($id);

        return redirect()->route('pdt.highlight-types.index')->withMessage('Highlight Types Successfully Deleted!');
    }





}
