<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{

    public function index()
    {
        return redirect()->route('home');
//        return view('front-end.index');
    }


    public function testCustomer(Request $request){
        return $request->all();
    }


}
