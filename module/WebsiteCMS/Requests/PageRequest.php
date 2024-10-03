<?php

namespace Module\WebsiteCMS\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Module\WebsiteCMS\Services\PageService;

class PageRequest extends FormRequest
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
            'name'          => 'required',
            'content'       => 'required',
        ];
    }






    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function store()
    {
        $service = new PageService();

        $service->store();

        $service->uploadImage();

        return $service->page;
    }




    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function update($id)
    {
        $service = new PageService();

        $service->update($id);
        $service->uploadImage();

        return $service->page;
    }
}
