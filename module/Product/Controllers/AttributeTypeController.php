<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Product\Services\Crud\AttributeTypeService;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckPermission;

class AttributeTypeController extends Controller
{
    private $service;
    use CheckPermission;







    
    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct(AttributeTypeService $attributeTypeService)
    {
        $this->service = $attributeTypeService;           
    }







    
    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("attribute-types.index");

        $data = $this->service->attributeTypeIndex();

        return view('attribute-type/index', $data);
    }







    
    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("attribute-types.create");

        return view('attribute-type/create');

    }







    
    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pdt_attribute_types',
        ]);

        try {

            DB::transaction(function () use ($request) {
                $this->service->attributeTypeStore($request);
            });

            return redirect()->route('pdt.attribute-types.index')->withMessage('Neck Successfully Created');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());

        }  
    }







    
    /*
     |--------------------------------------------------------------------------
     | SHOW METHOD
     |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        # code...
    }







    
    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("attribute-types.edit");

        $data = $this->service->attributeTypeEdit($id);

        return view('attribute-type/edit',$data);
    }








    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pdt_attribute_types,name,'.$id,
        ]);

        try {

            DB::transaction(function () use ($request,$id) {

                $this->service->attributeTypeUpdate($request, $id);
            });

            return redirect()->route('pdt.attribute-types.index')->withMessage('Neck Successfully Updated');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());

        } 
     }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("attribute-types.delete");

        try{

            $this->service->attributeTypeDelete($id);
            
            return redirect()->back()->withMessage('Successfully Deleted');

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());

        } 
   }
}
