<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\FileSaver;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Testimonial;
use Module\WebsiteCMS\Requests\TestimonialRequest;

class TestimonialController extends Controller
{

    use FileSaver;

    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['testimonials']   = Testimonial::latest()->paginate(25);
        $data['table']          = Testimonial::getTableName();

        return view('testimonials/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {
        $countries = Country::all();
        return view('testimonials/create', compact('countries'));
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(TestimonialRequest $request)
    {
        

        try {
            // $request->store();
            DB::transaction(function () use ($request) {

                $testimonial = Testimonial::create([
                    'name'              => $request->name,
                    'designation'       => $request->designation,
                    'country_id'        => $request->country_id,
                    'description'       => $request->description,
                    'ratings'           => $request->ratings,
                    'image'             => 'default.png',
                    'status'            => !empty($request->status) ? 1 : 0,
                    'created_by'        => auth()->id(),
                ]);

                $this->uploadFileWithResize($request->image, $testimonial, 'image', 'images/testimonial', 300, 300);

            });

        }catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
        // catch (\Throwable $th) {
        //     throw $th;
        // }


        return redirect()->route('website.testimonials.index')->withMessage('Testimonial Successfully Added');

        // return to_route('website.testimonials.index')->withMessage('Success');
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
    public function edit(Testimonial $testimonial)
    {
        $countries = Country::all();

        return view('testimonials.edit', compact('testimonial','countries'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(TestimonialRequest $request, $id)
    {
        // try {
        //     $request->update($id);
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
        // return to_route('website.testimonials.index')->withMessage('Success');
        $testimonial = Testimonial::find($id);

        try {

            DB::transaction(function () use ($request, $testimonial) {

                $testimonial->update([
                    'name'              => $request->name,
                    'designation'       => $request->designation,
                    'country_id'        => $request->country_id,
                    'description'       => $request->description,
                    'ratings'           => $request->ratings,
                    'image'             => $testimonial->image,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'updated_by'        => auth()->id(),
                ]);

                $this->uploadFileWithResize($request->image, $testimonial, 'image', 'images/testimonial', 300, 300);

            });

            return redirect()->route('website.testimonials.index')->withMessage('Testimonial Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {

        try {

            $testimonial = Testimonial::find($id);
            if (file_exists($testimonial->image)) {
                unlink($testimonial->image);
            }
            $testimonial->delete();
        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Testimonial deleted successfully!');

    }
}
