<?php

namespace Module\WebsiteCMS\Requests;



use Illuminate\Foundation\Http\FormRequest;
use Module\WebsiteCMS\Services\PostService;
use Module\WebsiteCMS\Services\MenuCategoryService;

class PostRequest extends FormRequest
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
            'title'         => 'required',
            'short_desc'    => 'required',
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
        $service = new PostService();

        $service->storeOrUpdate();
        $service->postCategories();

        return $service->post;
    }




    /**
     * =============================================
     * STORE METHOD
     * =============================================
     **/
    public function update($id)
    {
        $service = new PostService();

        $service->storeOrUpdate($id);
        $service->postCategories();

        return $service->post;
    }
}
