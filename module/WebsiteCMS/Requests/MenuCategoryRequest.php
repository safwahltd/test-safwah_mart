<?php

namespace Module\WebsiteCMS\Requests;


use Module\WebsiteCMS\Services\MenuCategoryService;
use Illuminate\Foundation\Http\FormRequest;

class MenuCategoryRequest extends FormRequest
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
        $service = new MenuCategoryService;

        $service->storeOrUpdate();

        return $service->menuCategory;
    }




    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function update($id)
    {
        $service = new MenuCategoryService;

        $service->storeOrUpdate($id);

        return $service->menuCategory;
    }
}
