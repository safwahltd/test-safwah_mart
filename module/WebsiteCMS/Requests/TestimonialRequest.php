<?php

namespace Module\WebsiteCMS\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Module\WebsiteCMS\Services\TestimonialService;

class TestimonialRequest extends FormRequest
{




    /**
     * =============================================
     * AUTHORIZE
     * =============================================
     **/
    public function authorize()
    {
        return true;
    }





    /**
     * =============================================
     * REQUEST/VALIDATION RULES METHOD
     * =============================================
     **/
    public function rules()
    {
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            return [];
        }

        return [
            'name'      => 'required',
        ];
    }






    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function store()
    {
        $service = new TestimonialService();

        $service->storeOrUpdate();

        return $service->testimonial;
    }




    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function update($id)
    {
        $service = new TestimonialService;

        $service->storeOrUpdate($id);

        return $service->testimonial;
    }
}
