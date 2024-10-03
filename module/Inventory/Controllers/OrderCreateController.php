<?php

namespace Module\Inventory\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\Warehouse;

class OrderCreateController extends Controller
{
    private $service;


    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        
    }












    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        
        $data['warehouses']     = Warehouse::with(['ecomAccounts' => function ($q) {
                                    $q->where('status', 1)
                                    ->select('id', 'warehouse_id', 'name', 'account_no', 'is_default');
                                }])
                                ->get(['id', 'name']);


        $data['categories']     = Category::query()
                                ->where('parent_id', null)
                                ->with('childCategories')
                                ->get(['id', 'name']);


        $data['users']          = User::where('type', 'Admin')->get();

        return view('order-create/create', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
       $data['warehouses']     = Warehouse::with(['ecomAccounts' => function ($q) {
                                    $q->where('status', 1)
                                    ->select('id', 'warehouse_id', 'name', 'account_no', 'is_default');
                                }])
                                ->get(['id', 'name']);


        $data['categories']     = Category::query()
                                ->where('parent_id', null)
                                ->with('childCategories')
                                ->get(['id', 'name']);


        $data['users']          = User::where('type', 'Admin')->get();
        
        return view('order-create/create', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        # code...
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
        # code...
    }













    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id, Request $request)
    {
        # code...
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        # code...
    }
}
