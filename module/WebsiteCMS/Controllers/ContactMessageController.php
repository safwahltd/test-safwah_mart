<?php

namespace Module\WebsiteCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Contact;

class ContactMessageController extends Controller
{


    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['contactMessages'] = Contact::paginate(50);
        return view('contact-message.index', $data);
    }




    public function show($id)
    {
        $data['item'] = Contact::find($id);

        return view('contact-message.view', $data);
    }


    //--------------------------------------------------------------------------//
    //                             DESTROY METHOD                               //
    //--------------------------------------------------------------------------//
    public function destroy($id)
    {
        Contact::find($id)->delete();
        return redirect()->back()->withMessage('Data has been deleted Successfully');
    }




}
