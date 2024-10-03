<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Blog;
use App\Traits\FileSaver;
use Module\WebsiteCMS\Models\SubscribersContent;

class SubscribersContentController extends Controller
{
    use FileSaver;

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['subscribersContent']      = SubscribersContent::query()
                                            ->searchByField('title')
                                            ->latest()
                                            ->paginate(30);

        $data['table']      = SubscribersContent::getTableName();

        return view('subscribers-content.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('subscribers-content.create');
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

                $subscribersContent = SubscribersContent::create([
                    'title'             => $request->title,
                    'image'             => 'default.png',
                    'description'       => $request->description,
                    'placeholder'       => $request->placeholder,
                    'button'            => $request->button,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'created_by'        => auth()->id()

                ]);

                $this->uploadFileWithResize($request->image, $subscribersContent, 'image', 'images/subscribers-content', 1200, 120);

            });

            return redirect()->route('website.subscribers-content.index')->withMessage('Content Successfully Created');

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
        $data['subscriberContent']      = SubscribersContent::findOrFail($id);


        return view('subscribers-content.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $subscribersContent = SubscribersContent::find($id);

        try {

            DB::transaction(function () use ($request, $subscribersContent) {

                $subscribersContent->update([
                    'title'             => $request->title,
                    'description'       => $request->description,
                    'placeholder'       => $request->placeholder,
                    'button'            => $request->button,
                    'image'             => $subscribersContent->image,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'updated_by'        => auth()->id()
                ]);

                $this->uploadFileWithResize($request->image, $subscribersContent, 'image', 'images/subscribers-content', 1200, 120);

            });

            return redirect()->route('website.subscribers-content.index')->withMessage('Content Successfully Updated');

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
        $subscribersContent = SubscribersContent::find($id);

        if(file_exists($subscribersContent->image))
        {
            unlink($subscribersContent->image);
        }

        $subscribersContent->destroy($id);

        return redirect()->route('website.subscribers-content.index')->withMessage('Content Successfully Deleted!');
    }





}
