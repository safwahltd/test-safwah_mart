<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Blog;
use App\Traits\FileSaver;
use Module\WebsiteCMS\Models\Service;
use Module\WebsiteCMS\Models\SubscribersContent;

class ServicesController extends Controller
{
    use FileSaver;

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['services']      = Service::query()
                                ->searchByField('title')
                                ->latest()
                                ->paginate(30);

        $data['table']      = Service::getTableName();

        return view('services.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('services.create');
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

                if($request->iconOrimage == 'image'){
                    $services = Service::create([
                        'name'              => $request->name,
                        'image'             => 'default.png',
                        'description'       => $request->description,
                        'status'            => !empty($request->status) ? 1 : 0,
                        'created_by'        => auth()->id()

                    ]);

                    // $this->uploadFileWithResize($request->image, $services, 'image', 'images/services', 20, 20);
                    $this->upload_file($request->image, $services, 'image', 'images/services');
                }
                else{
                    $services = Service::create([
                        'name'              => $request->name,
                        'description'       => $request->description,
                        'icon'              => $request->icon,
                        'status'            => !empty($request->status) ? 1 : 0,
                        'created_by'        => auth()->id()

                    ]);
                }



            });

            return redirect()->route('website.services.index')->withMessage('Service Successfully Created');

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
        $data['service']      = Service::findOrFail($id);


        return view('services.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {

        $services = Service::find($id);

        try {

            DB::transaction(function () use ($request, $services) {

                if($request->iconOrimage == 'image'){
                    $services->update([
                        'name'              => $request->name,
                        'description'       => $request->description,
                        'image'             => $services->image,
                        'status'            => !empty($request->status) ? 1 : 0,
                        'updated_by'        => auth()->id()
                    ]);

                    // $this->uploadFileWithResize($request->image, $services, 'image', 'images/services', 20, 20);
                    $this->upload_file($request->image, $services, 'image', 'images/services');
                }
                else{

                    $services->update([
                        'name'              => $request->name,
                        'description'       => $request->description,
                        'icon'              => $request->icon,
                        'status'            => !empty($request->status) ? 1 : 0,
                        'updated_by'        => auth()->id()
                    ]);
                }


            });

            return redirect()->route('website.services.index')->withMessage('Service Successfully Updated');

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
        $services = Service::find($id);

        if(file_exists($services->image))
        {
            unlink($services->image);
        }

        $services->destroy($id);

        return redirect()->route('website.services.index')->withMessage('Service Successfully Deleted!');
    }





}
