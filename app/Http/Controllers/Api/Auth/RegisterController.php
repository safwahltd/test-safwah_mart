<?php


namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\RegisterService;

use Illuminate\Support\Facades\Auth;
class RegisterController
{
    private $service;


    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct(RegisterService $registerService)
    {
        $this->service = $registerService;
    }





    public function socialRegister(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name'        =>  'required',
        //     'email'       =>  'required',
        // ]);

        // if ($validator->fails()) {

        //     return response()->json([
        //         'data'      => $validator->errors()->first(),
        //         'message'   => "Validation Error",
        //         'status'    => 0,
        //     ]);
        // }

        try{

            $user = $this->service->socialStore($request);

            $user = User::with(['customer' => function ($query) {
                $query->with('district:id,name')
                        ->with('area:id,name');
            }])->where('id', $user->id)->first();

            // create bearer token for authentication
            $data['token'] = $user->createToken('myapptoken')->plainTextToken;
            $data['user']  = $user;

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        } catch (\Exception $ex) {

            return response()->json([
                'data'      => $ex->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }


    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'phone'          =>  'required|unique:users',
            'password'       =>  'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'data'      => $validator->errors()->first(),
                'message'   => "Validation Error",
                'status'    => 0,
            ]);
        }

        try {

            $user = $this->service->store($request);

            $this->service->storeCustomer($request, $user->id);

            $user   = User::query()
                    ->with(['customer' => function ($q) {
                        $q->with('district:id,name')
                        ->with('area:id,name');
                    }])
                    ->where('id', $user->id)
                    ->first();

            // create bearer token for authentication
            $data['token'] = $user->createToken('myapptoken')->plainTextToken;
            $data['user']  = $user;

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        } catch (\Exception $ex) {

            return response()->json([
                'message'   => $ex->getMessage(),
                'status'    => 0,
            ]);

        }


    }

    public function accountCheck(Request $request)
    {
        $user   = User::query()
                ->where(function ($query) use ($request) {
                    $query->where('phone', $request->phone)
                        ->orWhere('email', $request->email ?? 'abcdefghijklmno.pqrst.uvwxyz12345567890@gmail.com');
                })
                ->with(['customer' => function ($query) {
                    $query->with('district:id,name')
                        ->with('area:id,name');
                }])
                ->first();

        if ($user) {

            if ($request->reset == 'true') {
                return response()->json([
                    'data'      => $user,
                    'message'   => "",
                    'status'    => 2,
                ]);
            }

            return response()->json([
                'data'      => $user,
                'message'   => "Already Registered",
                'status'    => 1,
            ]);
        }

        return response()->json([
            'data'      => '',
            'message'   => $request->phone ? 'Phone not found!' : 'Email not found!',
            'status'    => 0,
        ]);
     }




    public function updatePassword(Request $request)
    {
        User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'message'   => "Password has been changed successfully!",
            'status'    => 1,
        ]);
    }





    public function checkCurrentPassword(Request $request)
    {
        try{

            $user = User::where('id', $request->user_id)->first();

            if (!(Hash::check($request->current_password, $user->password))) {

                return response()->json([
                    'message'   => "Current password does not match!",
                    'status'    => 0,
                ]);
            }
            else{

                return response()->json([
                    'message'   => "Current password match!",
                    'status'    => 1,
                ]);
            }

        } catch (\Exception $ex) {

            return response()->json([
                'message'   => $ex->getMessage(),
                'status'    => 0,
            ]);
        }
    }




}
