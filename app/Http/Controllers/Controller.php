<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;









    /*
     |--------------------------------------------------------------------------
     | UPDATE STATUS METHOD
     |--------------------------------------------------------------------------
    */
    public function updateStatus(Request $request, $table, $column)
    {
        if ($request->ajax()) {

            $request->status == 'Active' ? $status = 0 : $status = 1;
            DB::table($table)->whereId($request->item_id)->update([$column => $status]);

            return response()->json(['status' => $status, 'item_id' => $request->item_id]);
        }
    }
}
