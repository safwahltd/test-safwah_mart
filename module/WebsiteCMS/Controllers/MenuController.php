<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Menu;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\MenuCategory;
use Module\WebsiteCMS\Requests\MenuRequest;

class MenuController extends Controller
{






    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['menus']  = Menu::with('menu_category')->latest()->paginate(25);
        $data['table']  = Menu::getTableName();

        return view('menu/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {
        $data['categories']     = MenuCategory::pluck('name', 'id');
        $data['parent_menus']   = Menu::whereNull('parent_id')->pluck('name', 'id');

        return view('menu/create', $data);
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(MenuRequest $request)
    {
        try {
            $request->store();
        } catch (\Throwable $th) {
            throw $th;
        }
        // return to_route('website.widget-menus.index')->withMessage('Success');
        return redirect()->route('website.widget-menus.index')->withMessage('Menu Successfully Added');
    }





    /**
     * =============================================
     * SHOW METHOD
     * =============================================
     **/
    public function show($id)
    {
        //
    }





    /**
     * =============================================
     * EDIT METHOD
     * =============================================
     **/
    public function edit($id)
    {
        $data['categories']     = MenuCategory::pluck('name', 'id');
        $data['parent_menus']   = Menu::whereNull('parent_id')->pluck('name', 'id');
        $data['menu']           = Menu::find($id);

        return view('menu/edit', $data);
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(MenuRequest $request, $id)
    {
        try {
            $request->update($id);
        } catch (\Throwable $th) {
            throw $th;
        }
        // return to_route('website.widget-menus.index')->withMessage('Success');
        return redirect()->route('website.widget-menus.index')->withMessage('Menu Successfully Updated');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        return $this->deleteItem(Menu::class, $id, 'website.widget-menus.index');
    }
}
