<?php

namespace Module\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeePasswordChangeController extends Controller
{






    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        return view('employee.password-changes.index');
    }







    /*
     |--------------------------------------------------------------------------
     | CHANGE PASSWORD
     |--------------------------------------------------------------------------
    */
    public function changePassword(Request $request)
    {
        $request->validate([

            'current_password'      => ['required', new MatchOldPassword],
            'new_password'          => ['required'],
            'new_confirm_password'  => ['same:new_password'],
        ]);
        

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->back()->withMessage('Password Successfully Changed');

    }
}
