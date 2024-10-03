<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Product\Models\AttributeType;
use Module\Product\Models\Attribute;
use Module\Product\Services\Crud\AttributeService;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckPermission;

class AttributeController extends Controller
{
    private $service;
    use CheckPermission;






    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct(AttributeService $attributeService)
    {
        $this->service = $attributeService;        
    }







    
    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("attributes.index");

         $data = $this->service->attributeIndex();

         return view('attribute/index', $data);
    }








    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("attributes.create");

        $data['attributeTypes'] = AttributeType::pluck('name','id');
        
        return view('attribute/create', $data);
    }








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique_with:pdt_attributes,name,attribute_type_id',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $this->service->attributeStore($request);
            });

            return redirect()->route('pdt.attributes.index')->withMessage('Attribute Successfully Created');

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
        $this->hasAccess("attributes.edit");

        $data = $this->service->attributeEdit($id);

        return view('attribute/edit',$data);
    }








    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|unique_with:pdt_attributes,name,attribute_type_id,'.$id,
        ]);

        try {

            DB::transaction(function () use ($request,$id) {

                $this->service->attributeUpdate($request, $id);
            });

            return redirect()->route('pdt.attributes.index')->withMessage('Attribute Successfully Updated');

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
        $this->hasAccess("attributes.delete");

        try{

            $this->service->attributeDelete($id);

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());

        }

    }

}
