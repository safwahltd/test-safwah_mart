<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Writer;

class WriterController extends Controller
{
    use FileSaver;

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['writers']      = Writer::query()
                                ->searchByField('name')
                                ->latest()
                                ->paginate(30);

        $data['table']      = Writer::getTableName();

        return view('writers.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('writers.create');
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

                $writers = Writer::create([
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'title'             => $request->title,
                    'phone'             => $request->phone,
                    'email'             => $request->email,
                    'address'           => $request->address,
                    'description'       => $request->description,
                    'image'             => 'default.png',
                    'created_by'        => auth()->id(),

                ]);

                $this->uploadFileWithResize($request->image, $writers, 'image', 'images/writers', 250, 360);

            });

            return redirect()->route('pdt.writers.index')->withMessage('Writer Successfully Created');

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
        $data['writer']      = Writer::findOrFail($id);


        return view('writers.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $writer = Writer::find($id);

        try {

            DB::transaction(function () use ($request, $writer) {

                $writer->update([
                    'name'              => $request->name,
                    'slug'              => $request->slug,
                    'title'             => $request->title,
                    'phone'             => $request->phone,
                    'email'             => $request->email,
                    'address'           => $request->address,
                    'description'       => $request->description,
                    'image'             => $writer->image,
                    'updated_by'        => auth()->id()
                ]);

                $this->uploadFileWithResize($request->image, $writer, 'image', 'images/writers', 250, 360);

            });

            return redirect()->route('pdt.writers.index')->withMessage('Writer Successfully Updated');

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
        $writer = Writer::find($id);

        if(file_exists($writer->image))
        {
            unlink($writer->image);
        }

        $writer->destroy($id);

        return redirect()->route('pdt.writers.index')->withMessage('Writer Successfully Deleted!');
    }





}
