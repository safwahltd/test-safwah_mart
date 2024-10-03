<?php

namespace Module\Product\Controllers;

use App\Traits\FileSaver;
use Illuminate\Http\Request;
use Module\Product\Models\Brand;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Product;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Module\Product\Models\ProductType;
use Module\Product\Exports\BrandExport;
use App\Traits\CheckPermission;

class BrandController extends Controller
{
    use FileSaver;
    use CheckPermission;




    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("brands.index");

        $brands = Product::select('brand_id', 'product_type_id')->distinct('brand_id')->orderBy('brand_id', 'ASC')->where('brand_id', '!=', null)->get();

        foreach($brands as $brand) {
            $brandUpdate = Brand::find($brand->brand_id);

            if($brandUpdate) {
                $brandUpdate->update([
                    'product_type_id' => $brand->product_type_id,
                ]);
            }
        }


        $data['table']      = Brand::getTableName();
        $data['brands']     = Brand::query()
                                    ->likeSearch('name')
                                    ->latest()
                                    ->paginate(50);


        return view('brand/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("brands.create");

        $productTypes = ProductType::select('id', 'name')->get();

        return view('brand/create', ['productTypes'=>$productTypes]);
    }




    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:pdt_brands',
            'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_brands',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $brand = Brand::create([

                    'name'             => $request->name,
                    'product_type_id'  => $request->product_type_id,
                    'slug'             => $request->slug,
                    'title'            => $request->title,
                    'position'         => $request->position,
                    'alt_text'         => $request->alt_text,
                    'meta_title'       => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'logo'             => 'default.png',
                    'is_highlight'     => !empty($request->is_highlight) ? 'Yes' : 'No',
                    'status'           => !empty($request->status) ? 1 : 0,
                ]);

                $this->upload_file($request->logo, $brand, 'logo', 'uploads/images/product/brand');
                // $this->uploadFileWithResize($request->logo, $brand, 'logo', 'images/product/brand', 140, 140);

            });

            return redirect()->route('pdt.brands.index')->withMessage('Manufacturer Successfully Created');

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
        $this->hasAccess("brands.edit");

        $productTypes = ProductType::select('id', 'name')->get();
        return view('brand/edit', ['brand' => Brand::findOrFail($id), 'productTypes'=>$productTypes]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);


        $request->validate([
            'name' => 'required|unique:pdt_brands,name,'.$brand->id,
            'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_brands,slug,'.$brand->id,
        ]);

        try {

            DB::transaction(function () use ($request, $brand) {

                $brand->update([
                    'name'             => $request->name,
                    'product_type_id'  => $request->product_type_id,
                    'slug'             => $request->slug,
                    'title'            => $request->title,
                    'position'         => $request->position,
                    'alt_text'         => $request->alt_text ?? $brand->alt_text,
                    'meta_title'       => $request->meta_title ?? $brand->meta_title,
                    'meta_description' => $request->meta_description ?? $brand->meta_description,
                    'logo'             => $brand->logo,
                    'is_highlight'     => !empty($request->is_highlight) ? 'Yes' : 'No',
                    'status'           => !empty($request->status) ? 1 : 0,
                ]);

                $this->upload_file($request->logo, $brand, 'logo', 'uploads/images/product/brand');
                // $this->uploadFileWithResize($request->logo, $brand, 'logo', 'images/product/brand', 140, 140);
            });

            return redirect()->route('pdt.brands.index')->withMessage('Manufacturer Successfully Updated');

        } catch(\Exception $ex) {

            return redirect()->back()->withInput()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE STATUS METHOD
     |--------------------------------------------------------------------------
    */
    public function updateStatus1(Request $request)
    {
        if ($request->ajax()) {

            if ($request->status == 'Active') {
                $status = 0;
            }else {
                $status = 1;
            }

            Brand::whereId($request->brand_id)->update(['status' => $status]);
            return response()->json(['status' => $status, 'brand_id' => $request->brand_id]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("brands.delete");

        try {

            $brand = Brand::find($id);

            $logo = $brand->logo;

            $brand->destroy($id);

            if(file_exists($logo)) {
                unlink($brand->logo);
            }
            return redirect()->back()->withMessage('Brand Successfully Deleted!');

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | BRAND EXPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function brandExport()
    {
        return Excel::download(new BrandExport, 'manufacturer-collection.xlsx');
    }
}
