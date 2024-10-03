<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Module\Inventory\Models\Order;
use Module\Product\Models\Product;
use Module\Account\Models\Customer;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data['customers']        = Customer::count();
        $data['totalOrders']      = Order::where('order_source', '!=', 'POS')->count();
        $data['todayOrders']      = Order::where('order_source', '!=', 'POS')->where('date', date('Y-m-d'))->count();
        $data['yesterdayOrders']  = Order::where('order_source', '!=', 'POS')->where('date', date('Y-m-d',strtotime("-1 days")))->count();
        $data['products']         = Product::count();
        $data['todaySells']       = Order::sum('grand_total');

        // $data['sells']            = Order::select('date', DB::raw('SUM(grand_total) as total'))->groupBy('date')->take(12)->get();

        // $amount = [];
        // for($i = 0; $i<12; $i++){
        //     if($data['sells'][0]->date ){

        //     }
        // }


        return view('home.dashboard', $data);
        return view('home.dashboard-v2', $data);
    }

    public function country()
    {
        $country = Country::paginate(20);

        return view('country',['country'=>$country]);
    }


    public function getCurrentMonthWiseDailySaleReport()
    {
        return Order::whereMonth('created_at', Carbon::now()->month)->get();
    }

}
