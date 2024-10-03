<?php

namespace Module\Permission\Controllers;

use App\Http\Controllers\Controller;

use Module\Permission\Models\ParentPermission;
use Module\Permission\Models\Submodule;
use Exception;
use Illuminate\Http\Request;

class ParentPermissionController extends Controller
{







    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $parentPermissions = ParentPermission::with('submodule')->orderByDesc('id')->paginate(30000);

        $submodules = Submodule::query()->orderByDesc('id')->pluck('name', 'id');

        return view('parent_permission', compact('submodules', 'parentPermissions'));
    }

   
    








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([

            'name'         => 'required|unique:parent_permissions,name',
            'submodule_id' => 'required'
        ]);

        try {

            ParentPermission::create($data);

            return redirect()->route('parent-permissions.index')->with('message', 'Parent Permission Create Successfull');

        } catch (Exception $ex) {
            
            return redirect()->back()->with('error', 'Some error, please check');

        }
    }




    







    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit(ParentPermission $parentPermission)
    {
        $submodules        = Submodule::orderBy('name')->pluck('name', 'id');

        $parentPermissions = ParentPermission::with('submodule')->orderBy('name')->paginate(30);

        return view('parent_permission', compact('submodules', 'parentPermissions', 'parentPermission'));
    }



    







    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, ParentPermission $parentPermission)
    {
        $data = $request->validate([

            'name'         => 'required|unique:parent_permissions,name,' . $parentPermission->id,
            'submodule_id' => 'required'
        ]);

        try {
            $parentPermission->update($data);

            return redirect()->route('parent-permissions.index')->with('message', 'Parent Permission Update Successfull');

        } catch (Exception $ex) {

            return redirect()->route('parent-permissions.index')->with('error', 'Some error, please check');

        }
    }



    







    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {

            ParentPermission::destroy($id);

            return redirect()->back()->with('message', 'Data deleted successfully');

        } catch (Exception $ex) {
            
            return redirect()->back()->with('error', 'Some error, please check');
            
        }

    }
}
