<?php

namespace Module\Product\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\BookProduct;
use Module\Product\Models\Tag;
use App\Traits\CheckPermission;

class ProductTagController extends Controller
{

    use CheckPermission;


    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("product-tags.index");

        $data['productTags']     = Tag::query()
                                    ->likeSearch('name')
                                    ->latest()
                                    ->paginate(50);

        $data['table']      = Tag::getTableName();

        return view('product-tags.index', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("product-tags.create");

        return view('product-tags/create');
    }




    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:pdt_tags',
        ]);

        try {

            DB::transaction(function () use ($request) {

                Tag::create([

                    'name'            => $request->name,
                    'slug'            => $request->slug,
                    'status'          => !empty($request->status) ? 1 : 0,
                    'created_by'      => auth()->id(),
                ]);

            });

            return redirect()->route('pdt.product-tags.index')->withMessage('Product Tag Successfully Created');

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
        $this->hasAccess("product-tags.edit");

        $data['productTag'] = Tag::find($id);
        return view('product-tags/edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $productTag = Tag::find($id);

        $request->validate([
            'name' => 'required|unique:pdt_tags,name,'.$productTag->id,
        ]);

        try {

            DB::transaction(function () use ($request, $productTag) {

                $productTag->update([
                    'name'            => $request->name,
                    'slug'            => $request->slug,
                    'status'          => !empty($request->status) ? 1 : 0,
                    'updated_by'      => auth()->id(),
                ]);

            });

            return redirect()->route('pdt.product-tags.index')->withMessage('Product Tag Successfully Updated');

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
        $this->hasAccess("product-tags.delete");

        $productTag = Tag::find($id);

        $productTag->destroy($id);

        return redirect()->back()->withMessage('Product Tag Successfully Deleted!');
    }





}
