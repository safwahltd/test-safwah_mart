<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\MenuCategory;
use Module\WebsiteCMS\Requests\MenuCategoryRequest;

class MenuCategoryController extends Controller
{



    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['categories']     = MenuCategory::latest()->get();
        $data['table']          = MenuCategory::getTableName();

        return view('menu/categories/index', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(MenuCategoryRequest $request)
    {

        try {
            $request->store();
        } catch (\Throwable $th) {

            return redirect()->back()->withInput($request->all())->withError($th->getMessage());
        }

        return redirect()->back()->withMessage('Category created successfully!');
    }








    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(MenuCategoryRequest $request, $id)
    {
        try {

            $request->update($id);
        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Category updated successfully!');
    }







    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy(MenuCategory $category)
    {
        try {

            $category->delete();
        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Category deleted successfully!');
    }
}
