<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use Module\Product\Models\Product;
use App\Http\Controllers\Controller;
use App\Traits\CheckPermission;

class BarcodeController extends Controller
{
    private $service;
    use CheckPermission;


    public function __construct()
    {}



    //-----------------------------------------------------------------//
    //                          INDEX METHOD                           //
    //-----------------------------------------------------------------//
    public function index()
    {
        // return view('barcode/new-barcode');

        $this->hasAccess("product-barcode.index");

        if(request()->ajax())
        {
            $data['name']           = request()->name;
            $data['variation_name'] = request()->variation_name;
            $data['barcode']        = request()->barcode;
            $data['price']          = request()->price;
            $data['quantity']       = request()->quantity;

            if(request()->printType == "All"){
                return view('barcode/all-barcode', $data);
            }else if(request()->printType == "Label"){
                return view('barcode/label-barcode', $data);
            }else{
                return '';
            }
        }

        $data['products'] = Product::with('productVariations')->get();

        return view('barcode/index', $data);
    }




    //-----------------------------------------------------------------//
    //                      ALL BARCODE METHOD                         //
    //-----------------------------------------------------------------//
    public function allBarcode()
    {

        $this->hasAccess("product-barcode.index");

        if(request()->ajax())
        {
            $data['name']       = request()->name;
            $data['barcode']    = request()->barcode;
            $data['price']      = request()->price;
            $data['quantity']   = request()->quantity;

            return view('barcode/all-barcode', $data);
        }

        $data['products'] = Product::with('productVariations')->get();

        return view('barcode/index', $data);
    }




    //-----------------------------------------------------------------//
    //                      LABEL BARCODE METHOD                       //
    //-----------------------------------------------------------------//
    public function labelBarcode()
    {

        $this->hasAccess("product-barcode.index");

        if(request()->ajax())
        {
            $data['name']       = request()->name;
            $data['barcode']    = request()->barcode;
            $data['price']      = request()->price;
            $data['quantity']   = request()->quantity;

            return view('barcode/label-barcode', $data);
        }

        $data['products'] = Product::with('productVariations')->get();

        return view('barcode/index', $data);
    }





}
