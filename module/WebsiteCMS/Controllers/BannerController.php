<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Banner;
use App\Traits\FileSaver;
use Exception;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    use FileSaver;

    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['banner']  = Banner::get();
        $data['table']   = Banner::getTableName();

        return view('banner/index', $data);
    }




    /**
     * =============================================
     * EDIT METHOD
     * =============================================
     **/
    public function edit($id)
    {
        $banner  = Banner::find($id);
        return view('banner/edit', compact('banner'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(Request $request, $id)
    {
        try {
            $banner = Banner::find($id);
            $banner->update([
                'alt_text'         => $request->alt_text ?? $banner->alt_text,
                'meta_title'       => $request->meta_title ?? $banner->alt_text,
                'meta_description' => $request->meta_description ?? $banner->alt_text,
                'url'              => $request->url,
                'status'           => !empty($request->status) ? 1 : 0,
            ]);

            if ($request->hasFile('image')) {
                $this->upload_file($request->image, $banner, 'image', 'banner');
            }
            return redirect()->route('website.banners.index')->withMessage('Success');
        } catch (Exception $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
        return redirect()->back()->withInput()->withMessage('Success');
    }
}
