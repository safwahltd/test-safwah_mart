<?php

namespace Module\WebsiteCMS\Services;


use App\Traits\FileSaver;
use Module\WebsiteCMS\Models\Testimonial;

class TestimonialService
{

    use FileSaver;

    public $testimonial;
    public $request;


    public function __construct()
    {
        $this->request = \request();
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrUpdate($id = null)
    {
        $request = $this->request;


        $this->testimonial = Testimonial::updateOrCreate([
            'id'                => $id,
        ], [
            'name'              => $request->name,
            'designation'       => $request->designation,
            'description'       => $request->description,
            'country'           => $request->country,
            'ratings'           => $request->ratings,
        ]);

        $this->uploadImage();
    }

    public function uploadImage()
    {
        $this->upload_file($this->request->image, $this->testimonial, 'image', 'Testimonial');
    }
}
