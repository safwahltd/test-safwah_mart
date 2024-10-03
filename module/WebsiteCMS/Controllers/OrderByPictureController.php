<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Page;
use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Module\WebsiteCMS\Models\OrderByPicture;
use Module\WebsiteCMS\Models\PageSection;

class OrderByPictureController extends Controller
{
    private $service;

    use FileSaver;

    public function __construct()
    {}






    //--------------------------------------------------------------------------//
    //                               INDEX METHOD                               //
    //--------------------------------------------------------------------------//
    public function index()
    {
        $data['orderByPictures'] = OrderByPicture::paginate(50);
        return view('orderby-picture/index', $data);
    }






    //--------------------------------------------------------------------------//
    //                               CREATE METHOD                               //
    //--------------------------------------------------------------------------//
    public function create()
    {
        $data = [];
        return view('', $data);
    }






    //--------------------------------------------------------------------------//
    //                               STORE METHOD                               //
    //--------------------------------------------------------------------------//
    public function store(Request $request)
    {}





    //--------------------------------------------------------------------------//
    //                               SHOW METHOD                                //
    //--------------------------------------------------------------------------//
    public function show($id)
    {
        $data['item'] = OrderByPicture::find($id);

        return view('orderby-picture/view', $data);
    }






    //--------------------------------------------------------------------------//
    //                               EDIT METHOD                                //
    //--------------------------------------------------------------------------//
    public function edit($id)
    {}






    //--------------------------------------------------------------------------//
    //                              UPDATE METHOD                               //
    //--------------------------------------------------------------------------//
    public function update(Request $request)
    {}





    //--------------------------------------------------------------------------//
    //                             DESTROY METHOD                               //
    //--------------------------------------------------------------------------//
    public function destroy($id)
    {
        OrderByPicture::find($id)->delete();
        return redirect()->back()->withMessage('Data has been deleted Successfully');
    }


}
