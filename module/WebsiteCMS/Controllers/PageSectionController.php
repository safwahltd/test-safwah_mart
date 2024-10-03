<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Page;
use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Module\WebsiteCMS\Models\PageSection;

class PageSectionController extends Controller
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
        $data['pageSections']    = PageSection::get();
        $data['table']           = PageSection::getTableName();

        return view('page-sections/index', $data);
    }






    //--------------------------------------------------------------------------//
    //                               CREATE METHOD                               //
    //--------------------------------------------------------------------------//
    public function create()
    {
        $data['pages'] = Page::select('id','name')->orderBy('name','ASC')->get();

        return view('page-sections/create', $data);
    }






    //--------------------------------------------------------------------------//
    //                               STORE METHOD                               //
    //--------------------------------------------------------------------------//
    public function store(Request $request)
    {
        // return $request->all();
        try {
            $PageSection = PageSection::create([
                        'page_id'               => $request->page_id,
                        'title'                 => $request->title,
                        'short_description'     => $request->short_description,
                        'status'                => !empty($request->status) ? 1 : 0,

                        'show_quantity'         => $request->show_quantity,
                        'button_name'           => $request->button_name,
                        'button_slug'           => $request->button_slug,
                        'button_status'         => !empty($request->button_status) ? 1 : 0,
                        'background_image'      => NULL,
                        'created_by'            => auth()->id(),
                    ]);

            $this->uploadFileWithResize($request->background_image, $PageSection, 'background_image', 'page-section','500','400');

        } catch (\Throwable $th) {

            throw $th;

        }
        return redirect()->route('website.page-sections.index')->withMessage('Success');
    }





    //--------------------------------------------------------------------------//
    //                               SHOW METHOD                                //
    //--------------------------------------------------------------------------//
    public function show($id)
    {}






    //--------------------------------------------------------------------------//
    //                               EDIT METHOD                                //
    //--------------------------------------------------------------------------//
    public function edit($id)
    {
        $data['pages']              = Page::select('id','name')->orderBy('name','ASC')->get();
        $data['PageSection']        = PageSection::find($id);

        return view('page-sections/edit', $data);
    }






    //--------------------------------------------------------------------------//
    //                              UPDATE METHOD                               //
    //--------------------------------------------------------------------------//
    public function update($id, Request $request)
    {
        try {
            $PageSection = PageSection::find($id);
            $PageSection->update([
                'page_id'               => $request->page_id,
                'title'                 => $request->title,
                'status'                => !empty($request->status) ? 1 : 0,
                'short_description'     => $request->short_description,

                'show_quantity'         => $request->show_quantity,
                'button_name'           => $request->button_name,
                'button_slug'           => $request->button_slug,
                'button_status'         => !empty($request->button_status) ? 1 : 0,
                'updated_by'            => auth()->id(),
            ]);

            if($request->background_image){
                $this->uploadFileWithResize($request->background_image, $PageSection, 'background_image', 'page-section','500','400');
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('website.page-sections.index')->withMessage('Success');
    }





    //--------------------------------------------------------------------------//
    //                             DESTROY METHOD                               //
    //--------------------------------------------------------------------------//
    public function destroy($id)
    {
        $data = PageSection::find($id);
        $data->delete();
        return redirect()->back()->withMessage('Success');
    }


}
