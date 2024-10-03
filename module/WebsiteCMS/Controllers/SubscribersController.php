<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Subscriber;

class SubscribersController extends Controller
{


    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['subscribers'] = Subscriber::query()
                                          ->searchByField('email')
                                          ->latest()
                                          ->paginate(30);

        $data['table']     = Subscriber::getTableName();

        return view('subscribers.index', $data);
    }




    /*
     |-------------------------------------------------------
     |             CREATE METHOD
     |-------------------------------------------------------
    */
    public function create()
    {
        return view('subscribers.create');
    }





    /*
     |-------------------------------------------------------
     |             STORE METHOD
     |-------------------------------------------------------
    */
    public function store(Request $request)
    {

        try {
                Subscriber::create([
                        'email'          => $request->email,
                        'status'        => !empty($request->status) ? 1 : 0,
                        'created_by'    => auth()->id()
                ]);

        } catch (\Throwable $th) {

            throw $th;

        }
        return redirect()->route('website.subscribers.index')->withMessage('Success');

    }





    /*
     |-------------------------------------------------------
     |             SHOW METHOD
     |-------------------------------------------------------
    */
    public function show($id)
    {
        //
    }





    /*
     |-------------------------------------------------------
     |             EDIT METHOD
     |-------------------------------------------------------
    */
    public function edit($id)
    {
        $subscribe  = Subscriber::find($id);
        return view('subscribers.edit', compact('subscribe'));
    }




    /*
     |-------------------------------------------------------
     |             UPDATE METHOD
     |-------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        try {
            $subscribe = Subscriber::find($id);
            $subscribe->update([
                'email'                    => $request->email,
                'status'                   => !empty($request->status) ? 1 : 0,
                'updated_by'               => auth()->id()
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('website.subscribers.index')->withMessage('Success');

    }





    /*
     |-------------------------------------------------------
     |             DESTROY METHOD
     |-------------------------------------------------------
    */
    public function destroy($id)
    {
        Subscriber::destroy($id);
        return redirect()->back()->withMessage('Successfully Deleted!');
    }




}
