<?php

namespace Module\Product\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\BookProduct;
use App\Traits\CheckPermission;

class BookController extends Controller
{

    use CheckPermission;


    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {

        $this->hasAccess("product-book.index");

        $data['books']     = BookProduct::query()
                            ->likeSearch('publisher_id')
                            ->latest()
                            ->paginate(50);

        $data['table']      = BookProduct::getTableName();

        return view('books.index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        return redirect()->back()->withError('Delete Process is on Maintainance!');
    }



}
