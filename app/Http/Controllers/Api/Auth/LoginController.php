<?php


namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function login111(Request $request)
    {
        $res = ['status' => false, 'token' => '', 'message' => 'Sorry, email/employee id and password do not match'];

        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required|string'
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->email)->orWhere('employee_full_id', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                $user->device_token = $request->device_token;
                $user->api_token = $user->id .'t'. Str::random(70);
                $user->save();

                $res['status']              = true;
                $res['token']               = $user->api_token;
                $res['device_token']        = $user->device_token;
                $res['message']             = '';
                $res['company_id']          = $user->company_id;
                $res['user_id']             = $user->id;
                $res['employee_id']         = $user->employee_id;
                $res['employee_full_id']    = $user->employee_full_id;
                $res['is_active']           = $user->status == 1 ? true : false;
            }
        }

        return response()->json($res);
    }


    public function loggout(Request $request)
    {
        
        $res = ['status' => false, 'message' => 'Sorry, loggout not possible'];


        if ($request->filled('user_id') || $request->filled('api_token')) {

            $user = User::where('id', $request->user_id)->orWhere('api_token', $request->token)->first();

            if ($user) {
                $user->api_token = null;
                $user->device_token = null;
                $user->save();

                $res = ['status' => true, 'message' => 'You are successfully logged out!'];

            }
 
        } else {

            $res = ['status' => false, 'message' => 'User Id or Token Must be Required'];
        }

        return response()->json($res);
    }





    
    /*
     |--------------------------------------------------------------------------
     | LOGIN
     |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'          =>  'required',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'data'      => $validator->errors()->first(),
                'message'   => "Validation Error",
                'status'    => 0,
            ]);
        }



        // check phone
        //  $user = User::where('phone', $request->phone)->where('password', $request->password)->first();

        $user   = User::where(function($query) use ($request) {
                    $query->where('phone', $request->phone)
                        ->orWhere('email', $request->phone);
                })
                ->with(['customer' => function ($query) {
                    $query->with('district:id,name')
                        ->with('area:id,name');
                }])
                ->first();

        // check user is exist or not
        if (!$user) {
            return response()->json([

                'data'      => "Phone or Password is incorrect",
                'message'   => "Error",
                'status'    => 0,
            ]);
        }

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([

                'data'      => "Password Not Match",
                'message'   => "Validation Error",
                'status'    => 0,
            ]);
        }
        
        Auth::login($user);

        // create bearer token for authentication
        $data['token'] = $user->createToken('myapptoken')->plainTextToken;
        $data['user'] = $user;




        return response()->json([

            'data'      => $data,
            'message'   => "Success",
            'status'    => 1,
        ]);
    }

}
