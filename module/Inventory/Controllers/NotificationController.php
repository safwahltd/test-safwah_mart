<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Module\Inventory\Models\Purchase;

class NotificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PO VERIFICATIONS METHOD
    |--------------------------------------------------------------------------
    */
    public function poVerifications()
    {
        $purchases = Purchase::with(['supplier' => function ($query) {
            $query->select('id', 'name');
        }])->whereStatus('Pending')->latest()->get();

        return view('notification.p-o-verifications', compact('purchases'));
    }
}
