<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Page;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Requests\PageRequest;
use App\Traits\FileSaver;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class PageController extends Controller
{

    use FileSaver;



    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['mainPages']  = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $data['pages']      = Page::query()
                                ->searchByField('name')
                                ->orderBy('id', 'DESC')
                                ->paginate(25);

        $data['table']      = Page::getTableName();

        return view('pages/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {
        $serial_no = Page::orderBy('id', 'DESC')->first();
        $next_serial_no = $serial_no ? $serial_no->serial_no + 1 : 1;

        return view('pages/create', compact('next_serial_no'));
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(Request $request)
    {
        $request->validate([ 
            'name'      => 'required|unique:web_pages',
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:web_pages',
            'serial_no' => 'required|unique:web_pages',
        ]);


        try {
            DB::transaction(function () use ($request){
                $page = Page::create([
                    'name'                     => $request->name,
                    'description'              => $request->description,
                    'slug'                     => $request->slug,
                    'seo_title'                => $request->seo_title,
                    'seo_description'          => $request->seo_description,
                    'serial_no'                => $request->serial_no,
                    'show_in_quick_links'      => !empty($request->show_in_quick_links) ? 1 : 0,
                    'status'                   => !empty($request->status) ? 1 : 0,
                ]);

                // $this->uploadFileWithResize($request->image, $page, 'image', 'images/page/image', '450');

                $this->uploadFileWithResize($request->banner_image, $page, 'banner_image', 'images/page/banner-image', '1200', '500');
            });
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
        
        
        return redirect()->route('website.pages.index')->withMessage('Page has been created successfully');
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
    public function edit(Page $page)
    {
        return view('pages/edit', compact('page'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(Request $request, $id)
    {
        $page = Page::find($id);
       
        $request->validate([ 
            'name'      => 'required|unique:web_pages,name,'.$page->id,
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:web_pages,slug,'.$page->id,
            'serial_no' => 'required|unique:web_pages,serial_no,'.$page->id,
        ]);

        try {
            
            $page->update([
                'name'                     => $request->name,
                'slug'                     => $request->slug,
                'description'              => Purifier::clean($request->description),
                'seo_title'                => $request->seo_title ?? $page->seo_title,
                'seo_description'          => $request->seo_description ?? $page->seo_title,
                'serial_no'                => $request->serial_no,
                'show_in_quick_links'      => !empty($request->show_in_quick_links) ? 1 : 0,
                'status'                   => !empty($request->status) ? 1 : 0,
            ]);

            // $this->uploadFileWithResize($request->image, $page, 'image', 'images/page/image', '450');

            $this->uploadFileWithResize($request->banner_image, $page, 'banner_image', 'images/page/banner-image', '1200', '500');

        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
        
        
        return redirect()->route('website.pages.index')->withMessage('Page has been updated successfully');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {
                $page = Page::find($id);

                if (file_exists($page->image)) {
                    unlink($page->image);
                }

                if (file_exists($page->banner_image)) {
                    unlink($page->banner_image);
                }

                $page->delete();
            });

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Page has been deleted successfully!');
    }
}
