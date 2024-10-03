<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Publisher;
use Module\Product\Models\Writer;

class PublisherController extends Controller
{
    use FileSaver;

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['publishers']      = Publisher::query()
                                ->searchByField('name')
                                ->latest()
                                ->paginate(30);

        $data['table']      = Publisher::getTableName();

        return view('publishers.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('publishers.create');
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

                $publishers = Publisher::create([
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'title'             => $request->title,
                    'phone'             => $request->phone,
                    'email'             => $request->email,
                    'address'           => $request->address,
                    'description'       => $request->description,
                    'logo'              => 'default.png',
                    'cover_photo'       => 'default-cover.png',
                    'created_by'        => auth()->id(),

                ]);

                $this->uploadFileWithResize($request->logo, $publishers, 'logo', 'images/publishers/logo', 250, 360);
                $this->uploadFileWithResize($request->cover_photo, $publishers, 'cover_photo', 'images/publishers/cover_photo', 250, 360);

            });

            return redirect()->route('pdt.publishers.index')->withMessage('Publisher Successfully Created');

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
        $data['publisher']      = Publisher::findOrFail($id);


        return view('publishers.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $publisher = Publisher::find($id);

        try {

            DB::transaction(function () use ($request, $publisher) {

                $publisher->update([
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'title'             => $request->title,
                    'phone'             => $request->phone,
                    'email'             => $request->email,
                    'address'           => $request->address,
                    'description'       => $request->description,
                    'logo'              => $publisher->logo,
                    'cover_photo'       => $publisher->cover_photo,
                    'updated_by'        => auth()->id()
                ]);

                $this->uploadFileWithResize($request->logo, $publisher, 'logo', 'images/publishers/logo', 250, 360);
                $this->uploadFileWithResize($request->cover_photo, $publisher, 'cover_photo', 'images/publishers/cover_photo', 250, 360);

            });

            return redirect()->route('pdt.publishers.index')->withMessage('Publisher Successfully Updated');

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
        $publisher = Publisher::find($id);

        if(file_exists($publisher->logo))
        {
            unlink($publisher->logo);
        }

        if(file_exists($publisher->cover_photo))
        {
            unlink($publisher->cover_photo);
        }

        $publisher->destroy($id);

        return redirect()->route('pdt.publishers.index')->withMessage('Publisher Successfully Deleted!');
    }





}
