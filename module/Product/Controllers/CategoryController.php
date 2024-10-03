<?php

namespace Module\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Module\Product\Exports\CategoryExport;
use Module\Product\Models\Category;
use Module\Product\Models\ProductType;
use Module\Product\Models\Product;
use Module\Product\Import\CategoryUploadCSV;
use App\Traits\CheckPermission;

class CategoryController extends Controller
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
        $this->hasAccess("categories.index");

        $data['table']              = Category::getTableName();
        $data['categories']         = Category::query()
                                            ->searchByField('name')
                                            ->searchByField('parent_id')
                                            ->with('parentCategories')
                                            ->orderBy('id', 'DESC')
                                            ->paginate(50);



        return view('category/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $this->hasAccess("categories.create");

        $data['productTypes']       = ProductType::select('id', 'name')->get();

        $data['categories']         = Category::query()
                                            ->where('parent_id', null)
                                            ->with('productType:id,name')
                                            ->with('childCategories')
                                            ->get(['id', 'name', 'product_type_id']);

        return view('category/create', $data);
    }








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        if($request->csv_file) {

            Excel::import(new CategoryUploadCSV(), $request->file('csv_file'));
            return redirect()->route('pdt.categories.index')->withMessage('Category Successfully Created');
        }

        $this->storeValidation($request);

        try {

            DB::transaction(function () use ($request) {

                $category = Category::create([

                    'product_type_id'  => $request->product_type_id,
                    'parent_id'        => $request->parent_id,
                    'name'             => $request->name,
                    'slug'             => $request->slug,
                    'title'            => $request->title,
                    'alt_text'         => $request->alt_text,
                    'meta_title'       => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'icon'             => null,
                    'image'            => null,
                    'banner_image'     => null,
                    'show_on_menu'     => !empty($request->show_on_menu) ? 'Yes' : 'No',
                    'is_highlight'     => !empty($request->is_highlight) ? 'Yes' : 'No',
                    'status'           => !empty($request->status) ? 1 : 0,
                    'serial_no'        => $request->serial_no,

                ]);

                $this->uploadFileWithResize($request->image,        $category,  'image',        'images/product/category',              220, 200);
                $this->uploadFileWithResize($request->banner_image, $category,  'banner_image', 'images/product/category/banner-image', 580, 210);
                $this->uploadFileWithResize($request->icon,         $category,  'icon',         'images/product/category/icon',         40, 40);

            });

            return redirect()->route('pdt.categories.index')->withMessage('Category Successfully Created');

        } catch(\Exception $ex) {
            
            return redirect()->back()->withInput()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("categories.edit");

        $data['productTypes']   = ProductType::select('id', 'name')->get();
        $data['category']       = Category::find($id);
        $data['categories']     = Category::query()
                                    ->where('parent_id', null)
                                    ->with('productType:id,name')
                                    ->with('childCategories')
                                    ->get(['id', 'name','product_type_id']);



        return view('category/edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $request->validate([

            'name'      => 'required|unique:pdt_categories,name,'.$category->id,
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_categories,slug,'.$category->id,
            'title'     => 'nullable',
            // 'image'     => 'image',
        ]);

        try {

            DB::transaction(function () use ($request, $category) {

                $category->update([

                    'product_type_id'  => $request->product_type_id,
                    'name'             => $request->name,
                    'parent_id'        => $request->parent_id,
                    'slug'             => $request->slug,
                    'title'            => $request->title,
                    'alt_text'         => $request->alt_text ?? $category->alt_text,
                    'meta_title'       => $request->meta_title ?? $category->meta_title,
                    'meta_description' => $request->meta_description ?? $category->meta_description,
                    'icon'             => $category->icon ?? '',
                    'image'            => $category->image ?? '',
                    'banner_image'     => $category->banner_image ?? '',
                    'show_on_menu'     => !empty($request->show_on_menu) ? 'Yes' : 'No',
                    'is_highlight'     => !empty($request->is_highlight) ? 'Yes' : 'No',
                    'status'           => !empty($request->status) ? 1 : 0,
                    'serial_no'        => $request->serial_no,
                ]);

                $this->uploadFileWithResize($request->image,        $category, 'image',         'images/product/category',              220, 200);
                $this->uploadFileWithResize($request->banner_image, $category, 'banner_image',  'images/product/category/banner-image', 580, 210);
                $this->uploadFileWithResize($request->icon,         $category, 'icon',          'images/product/category/icon',         40, 40);

            });

            return redirect()->route('pdt.categories.index')->withMessage('Category Successfully Created');

        } catch(\Exception $ex) {
            return redirect()->back()->withInput()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("categories.delete");

        try {
            $category = Category::find($id);
            // $product  = $this->isProductEmpty($id);

            if(file_exists($category->image))
            {
                unlink($category->image);
            }

            if(file_exists($category->banner_image))
            {
                unlink($category->banner_image);
            }

            $category->destroy($id);

        } catch(\Exception $ex) {
            return redirect()->back()->withWarning('You can not delete this Category');
        }

        return redirect()->route('pdt.categories.index')->withMessage('Category Successfully Deleted!');
    }




    /*
     |--------------------------------------------------------------------------
     | CATEGORY EXPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function categoryExport()
    {
        return Excel::download(new CategoryExport, 'category-collection.xlsx');
    }




   /*
     |--------------------------------------------------------------------------
     | CHECK PRODUCT AVAILABLE BEFORE DELETE
     |--------------------------------------------------------------------------
    */

    public function isProductEmpty($parentId){

        $product = 0;
        $childs = Category::where('parent_id',$parentId)->pluck('id');

        foreach($childs as $child){
            $product = Product::where('category_id', $child)->count();
            if($product>0){
                break;
            }
        }
        return $product;
    }


    /*
     |--------------------------------------------------------------------------
     | STORE VALIDATION METHOD
     |--------------------------------------------------------------------------
    */
    public function storeValidation($request)
    {
        $request->validate([

            'name'              => 'required|unique_with:pdt_categories,name,parent_id',
            'slug'              => 'required|regex:/^[a-zA-Z0-9-]+$/|unique_with:pdt_categories,slug,parent_id',
            'image'             => 'nullable|file|mimes:jpg,jpeg,png,webp,gif',
        ]);
    }



    /*
     |--------------------------------------------------------------------------
     | STORE VALIDATION METHOD
     |--------------------------------------------------------------------------
    */
    public function categoryUpload()
    {
        return view('category/bulk-create');
    }



}
