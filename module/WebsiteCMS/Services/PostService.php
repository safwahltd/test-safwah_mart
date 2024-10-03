<?php

namespace Module\WebsiteCMS\Services;

use App\Traits\FileSaver;
use Illuminate\Support\Str;
use Module\WebsiteCMS\Models\Post;

class PostService
{

    use FileSaver;

    public $post;
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
    public function storeOrUpdate($id=null)
    {
        $request = $this->request;

        $this->post = Post::updateOrCreate([
            'id'                => $id,
        ],[
            'title'             => $request->title,
            'short_desc'        => $request->short_desc,
            'content'           => $request->content,
            'seo_title'         => $request->seo_title,
            'seo_description'   => $request->seo_description,
            'format_type'       => $request->format_type,
            'author_id'         => $request->author_id ?? auth()->id(),
            'slug'              => $request->slug ?? Str::slug($request->title),
        ]);

        
        $this->upload_file($request->feature_image,$this->post,'feature_image','Post/Image');

    }


    public function postCategories()
    {
        // foreach ($this->request->category_id ?? [] as $key => $category_id) {
            $this->post->post_categories()->sync($this->request->category_id);
        // }
    }
}
