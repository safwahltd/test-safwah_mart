<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Page;
use App\Http\Controllers\Controller;
use App\Traits\FileSaver;
use Module\WebsiteCMS\Models\AppointmentBooking;
use Module\WebsiteCMS\Models\PageSection;

class AppointmentBookingController extends Controller
{
    private $service;

    use FileSaver;

    public function __construct()
    {}






    //--------------------------------------------------------------------------//
    //                               INDEX METHOD                               //
    //--------------------------------------------------------------------------//
    public function index()
    {
        $data['appointmentBooking'] = AppointmentBooking::paginate(50);
        return view('appointment-booking/index', $data);
    }






    //--------------------------------------------------------------------------//
    //                               CREATE METHOD                               //
    //--------------------------------------------------------------------------//
    public function create()
    {
        $data = [];
        return view('', $data);
    }






    //--------------------------------------------------------------------------//
    //                               STORE METHOD                               //
    //--------------------------------------------------------------------------//
    public function store(Request $request)
    {}





    //--------------------------------------------------------------------------//
    //                               SHOW METHOD                                //
    //--------------------------------------------------------------------------//
    public function show($id)
    {
        $data['item'] = AppointmentBooking::find($id);

        return view('appointment-booking/view', $data);
    }






    //--------------------------------------------------------------------------//
    //                               EDIT METHOD                                //
    //--------------------------------------------------------------------------//
    public function edit($id)
    {}






    //--------------------------------------------------------------------------//
    //                              UPDATE METHOD                               //
    //--------------------------------------------------------------------------//
    public function update(Request $request)
    {}





    //--------------------------------------------------------------------------//
    //                             DESTROY METHOD                               //
    //--------------------------------------------------------------------------//
    public function destroy($id)
    {
        AppointmentBooking::find($id)->delete();
        return redirect()->back()->withMessage('Data has been deleted Successfully');
    }


}
