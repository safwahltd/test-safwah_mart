<?php

namespace Module\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Module\Product\Exports\ProductTypeExport;
use Module\Product\Models\ProductType;

class ProductTypeController extends Controller
{
    use FileSaver;




    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['productTypes'] = ProductType::orderBy('id', 'ASC')->get();

        $data['table']          = ProductType::getTableName();

        return view('product-type/index', $data );
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        return view('product-type.edit', ['productType' => ProductType::findOrFail($id)]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $productType = ProductType::find($id);

        $request->validate([
            'name'  => 'required|unique:pdt_product_types,name,'.$productType->id,
            'slug'  => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_product_types,slug,'.$productType->id,
            'image' => 'image',
        ]);

        try {

            DB::transaction(function () use ($request, $productType) {

                $productType->update([
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'image'             => $productType->image,
                    'description'       => $request->description,
                    'status'            => !empty($request->status) ? 1 : 0
                ]);

                $this->uploadFileWithResize($request->image, $productType, 'image', 'images/product/type', 400, 180);

            });

            return redirect()->route('product-types.index')->withMessage('Product Type Successfully Updated');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | PRODUCT TYPE EXPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function productTypeExport()
    {
        // return Excel::download(new ProductTypeExport, 'product-type-collection.xlsx');
    }
}
