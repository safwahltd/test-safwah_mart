<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Post;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\MenuCategory;
use Module\WebsiteCMS\Requests\PostRequest;

class PostController extends Controller
{






    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['posts']  = Post::with('post_categories')->latest()->paginate(25);
        $data['table']  = Post::getTableName();

        return view('posts/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {
        $data['categories']     = MenuCategory::pluck('name', 'id');

        return view('posts/create', $data);
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(PostRequest $request)
    {
        try {
            $request->store();
        } catch (\Throwable $th) {
            throw $th;
        }
        return to_route('website.posts.index')->withMessage('Success');
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
    public function edit($id)
    {
        $data['categories']     = MenuCategory::pluck('name', 'id');
        $data['post']           = Post::find($id);

        return view('posts/edit', $data);
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(PostRequest $request, $id)
    {
        try {
            $request->update($id);
        } catch (\Throwable $th) {
            throw $th;
        }
        return to_route('website.posts.index')->withMessage('Post Update Successfully');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        try {

            $post = Post::find($id);
            if (file_exists($post->feature_image)) {
                unlink($post->feature_image);
            }
            $post->delete();
        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Post deleted successfully!');
    }
}
