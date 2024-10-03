<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\SocialLink;
use Module\WebsiteCMS\Models\Testimonial;

class SocialLinkController extends Controller
{


    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['links']  = SocialLink::latest()->get();
        $data['table']  = SocialLink::getTableName();

        return view('social-links/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {

        return view('social-links/create');
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(Request $request)
    {
        try {
            $this->storeOrUpdate($request);
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('website.social-links.index')->withMessage('Success');
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
        $social_link  = SocialLink::find($id);
        return view('social-links/edit', compact('social_link'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(Request $request, $id)
    {
        try {
            $this->storeOrUpdate($request, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('website.social-links.index')->withMessage('Success');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        $data = SocialLink::find($id);
        $data->delete();
        return redirect()->back()->withMessage('Success');
    }



    public function storeOrUpdate($request, $id = null)
    {
        return SocialLink::updateOrCreate([
            'id'    => $id,
        ], [
            'name'  => $request->name,
            'url'   => $request->url,
            'icon'  => $request->icon,
        ]);
    }
}
