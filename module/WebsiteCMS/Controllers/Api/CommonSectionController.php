<?php

namespace Module\WebsiteCMS\Controllers\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\District;
use Illuminate\Http\Request;
use Module\Product\Models\Brand;
use Module\WebsiteCMS\Models\Blog;
use Module\WebsiteCMS\Models\Page;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Banner;
use Module\WebsiteCMS\Models\Slider;
use Module\Inventory\Models\TimeSlot;
use Module\WebsiteCMS\Models\Wishlist;
use Module\Product\Models\HighlightType;
use Module\WebsiteCMS\Models\SocialLink;
use Module\WebsiteCMS\Models\Testimonial;
use Module\WebsiteCMS\Services\JsonResponseService;

class CommonSectionController extends Controller
{

    private $jsonResponseService;


    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT
     |--------------------------------------------------------------------------
    */
    public function __construct(JsonResponseService $jsonResponseService)
    {
        $this->jsonResponseService = $jsonResponseService;
    }



    /*
     |--------------------------------------------------------------------------
     | COMMON SECTION DATA
     |--------------------------------------------------------------------------
    */
    public function getCommonSectionData($user_id = null)
    {
        try{
            $data['company']            = Company::first();

            $data['pages']              = Page::active()->showInQuickLinks()->orderBy('serial_no', 'ASC')->get(['id', 'name', 'slug','serial_no']);

            $data['sidebarCategories']  = Category::query()
                                        ->where('parent_id', null)
                                        ->showOnMenu()
                                        // ->whereHas('products')
                                        ->with('childCategoriesShowOnMenu')
                                        ->withCount('products as total_products')
                                        ->active()
                                        ->orderBy('serial_no', 'ASC')
                                        ->get();

            $data['districts']          = District::orderBy('name', 'ASC')->active()->get(['id', 'name', 'shipping_cost']);

            $data['time_slots']         = TimeSlot::active()->get([ 'id', 'name', 'starting_time', 'ending_time', 'disable_at' ]);

            $data['total_wishlist']     = 0;

            if($user_id != null)
            {
                $data['total_wishlist'] = Wishlist::where('user_id', $user_id)->count('id');
            }
            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }



    }




    /*
     |--------------------------------------------------------------------------
     | COMMON SECTION DATA V2
     |--------------------------------------------------------------------------
    */
    public function getCommonSectionDataV2()
    {
        try{
            $data['company']            = Company::first();

            $data['pages']              = Page::active()->showInQuickLinks()->orderBy('serial_no', 'ASC')->get(['id', 'name', 'slug','serial_no']);

            $data['districts']          = District::orderBy('name', 'ASC')->active()->get(['id', 'name', 'shipping_cost']);

            $data['time_slots']         = TimeSlot::active()->get([ 'id', 'name', 'starting_time', 'ending_time', 'disable_at' ]);

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }

    }




    //-------------------------------------------//
    //              COMPANY INFO DATA
    //-------------------------------------------//
    public function getCompanyInfo()
    {
        try{
            $data['company']            = Company::first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }



    }





    //-------------------------------------------//
    //                  PAGES DATA
    //-------------------------------------------//
    public function getPagesShowOnQuickLinks()
    {
        try{
            $data['pages']          = Page::active()->showInQuickLinks()->orderBy('serial_no', 'ASC')->get(['id', 'name', 'slug','serial_no']);


            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }

    }



    //-------------------------------------------//
    //           SIDEBAR CATEGORIES DATA
    //-------------------------------------------//
    public function getSidebarCategoriesShowOnMenu()
    {
        try{

            $data['sidebarCategories']  = Category::query()
                                        ->where('parent_id', null)
                                        ->showOnMenu()
                                        ->with('childCategoriesShowOnMenu')
                                        ->active()
                                        ->orderBy('serial_no', 'ASC')
                                        ->get([ "id", "product_type_id", "parent_id", "name", "slug", "icon", "image"]);
            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }



    }





    //-------------------------------------------//
    //               DISTRICTS DATA
    //-------------------------------------------//
    public function getDistrictsData()
    {
        try{
            $data['districts']          = District::orderBy('name', 'ASC')->active()->get(['id', 'name', 'shipping_cost', 'min_purchase_amount', 'free_delivery_amount']);


            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }

    }






    //-------------------------------------------//
    //               TIMESLOTS DATA
    //-------------------------------------------//
    public function getTimeSlotsData()
    {
        try{
            $data['time_slots']         = TimeSlot::active()->get([ 'id', 'name', 'starting_time', 'ending_time', 'disable_at' ]);

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }

    }




    //-------------------------------------------//
    //            TOTAL WISHLISTS DATA
    //-------------------------------------------//
    public function getTotalWishlists($user_id = null)
    {
        try{
            $data['total_wishlist']     = 0;

            if($user_id != null)
            {
                $data['total_wishlist'] = Wishlist::where('user_id', $user_id)->count('id');
            }
            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }



    }





}
