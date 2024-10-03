<?php

namespace Module\WebsiteCMS\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Module\WebsiteCMS\Services\MenuService;
use Module\WebsiteCMS\Services\MenuCategoryService;

class MenuRequest extends FormRequest
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
        $service = new MenuService();

        $service->storeOrUpdate();

        return $service->menu;
    }




    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function update($id)
    {
        $service = new MenuService;

        $service->storeOrUpdate($id);

        return $service->menu;
    }
}
