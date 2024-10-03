<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Blog;
use App\Traits\FileSaver;

class BlogController extends Controller
{
    use FileSaver;

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['table']      = Blog::getTableName();
        $data['blogs']      = Blog::query()
                                ->searchByField('name')
                                ->latest()
                                ->paginate(30);


        return view('blogs.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('blogs.create');
    }








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        try {

            DB::transaction(function () use ($request) {

                $blog = Blog::create([
                    'name'             => $request->name,
                    'slug'             => $request->slug,
                    'image'            => 'default.png',
                    'description'      => $request->description,
                    'alt_text'         => $request->alt_text,
                    'meta_title'       => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'status'           => !empty($request->status) ? 1 : 0,
                    'created_by'       => auth()->id()
                ]);

                $this->uploadFileWithResize($request->image, $blog, 'image', 'images/blog', 550, 350);

            });

            return redirect()->route('website.blogs.index')->withMessage('Blog Successfully Created');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $data['blog'] = Blog::findOrFail($id);

        return view('blogs.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        try {

            DB::transaction(function () use ($request, $blog) {

                $blog->update([
                    'name'             => $request->name,
                    'slug'             => $request->slug,
                    'image'            => $blog->image,
                    'description'      => $request->description,
                    'description'      => $request->description ?? $blog->description,
                    'alt_text'         => $request->alt_text ?? $blog->alt_text,
                    'meta_title'       => $request->meta_title ?? $blog->meta_title,
                    'status'           => !empty($request->status) ? 1 : 0,
                    'updated_by'       => auth()->id()
                ]);

                $this->uploadFileWithResize($request->image, $blog, 'image', 'images/blog', 550, 350);

            });

            return redirect()->route('website.blogs.index')->withMessage('Blog Successfully Updated');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if(file_exists($blog->image)) {
            unlink($blog->image);
        }

        $blog->destroy($id);

        return redirect()->route('website.blogs.index')->withMessage('Blog Successfully Deleted!');
    }





}
