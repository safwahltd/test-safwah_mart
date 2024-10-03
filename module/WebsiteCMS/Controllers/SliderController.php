<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Slider;
use Module\WebsiteCMS\Models\Testimonial;
use App\Traits\FileSaver;

class SliderController extends Controller
{
    use FileSaver;

    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['slider']  = Slider::latest()->get();
        $data['table']   = Slider::getTableName();

        return view('slider/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {

        return view('slider/create');
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(Request $request)
    {

        try {
            $slider = Slider::create([
                'name'             => $request->name,
                'slug'             => $request->slug,
                'status'           => !empty($request->status) ? 1 : 0,
                'alt_text'         => $request->alt_text,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'button_title'     => $request->button_title,
                'button_icon'      => $request->button_title,
                'button_url'       => $request->button_url,
                'button_status'    => !empty($request->button_status) ? 1 : 0,
                'image'            => 'deafult.jpg'
            ]);

            $this->upload_file($request->image, $slider, 'image', 'slider');
        } catch (\Throwable $th) {

            throw $th;
        }
        return redirect()->route('website.sliders.index')->withMessage('Success');
    }





    /**
     * =============================================
     * EDIT METHOD
     * =============================================
     **/
    public function edit($id)
    {
        $slider  = Slider::find($id);
        return view('slider/edit', compact('slider'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(Request $request, $id)
    {
        try {
            $slider = Slider::find($id);

            $slider->update([
                'name'             => $request->name,
                'slug'             => $request->slug,
                'status'           => !empty($request->status) ? 1 : 0,
                'alt_text'         => $request->alt_text,
                'meta_title'       => $request->meta_title ?? $slider->meta_title,
                'meta_description' => $request->meta_description ?? $slider->meta_title,
                'button_title'     => $request->button_title ?? $slider->meta_title,
                'button_icon'      => $request->button_title,
                'button_url'       => $request->button_url,
                'button_status'    => !empty($request->button_status) ? 1 : 0,
            ]);

            $this->upload_file($request->image, $slider, 'image', 'slider');

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }

        return redirect()->route('website.sliders.index')->withMessage('Success');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        $data = Slider::find($id);
        $data->delete();

        if (file_exists($data->image)) {
            unlink($data->image);
        }

        return redirect()->back()->withMessage('Success');
    }



    public function storeOrUpdate($request, $id = null)
    {
        return Slider::updateOrCreate([
            'id'    => $id,
        ], [
            'name'  => $request->name,
            'url'   => $request->url,
            'icon'  => $request->icon,
        ]);
    }
}
