<?php

namespace Module\WebsiteCMS\Services;


use App\Traits\FileSaver;
use Illuminate\Support\Str;
use Module\WebsiteCMS\Models\Page;

class PageService
{

    use FileSaver;


    public $page;
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
    public function store()
    {
        $request = $this->request;

        $this->page = Page::create([
            'name'             => $request->name,
            'description'      => $request->description,
            'content'          => $request->content,
            'slug'             => $request->slug ?? Str::slug($request->title),
        ]);
    }


    public function uploadImage()
    {
        $this->upload_file($this->request->image, $this->page, 'image', 'Pages');
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id)
    {
        $request = $this->request;

        $this->page = Page::find($id);
        $this->page->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'content'          => $request->content,
            'slug'             => $request->slug ?? Str::slug($request->title),
        ]);
    }
}
