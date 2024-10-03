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

class OldApiController extends Controller
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
     | BLOGS METHOD
     |--------------------------------------------------------------------------
    */
    public function getBlogs()
    {

        try{

            $data['blogs']       = Blog::active()->paginate(10);
            $data['page']        = Page::where('slug', 'blog')->first();

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
     | TESTIMONIALS METHOD
     |--------------------------------------------------------------------------
    */
    public function getTestimonials()
    {
        return $this->jsonResponseService->get(Testimonial::query(), 'testimonials');
    }



    /*
     |--------------------------------------------------------------------------
     | SOCIAL LINKS METHOD
     |--------------------------------------------------------------------------
    */
    public function getSocialLinks()
    {
        return $this->jsonResponseService->get(SocialLink::query(), 'socialLinks');
    }





    /**
     * =============================================
     * SLIDER
     * =============================================
     **/
    public function getSliders()
    {
        return $this->jsonResponseService->get(Slider::query(), 'sliders');
    }




    /*
     |-----------------------------------------------
     | PAGES
     |-----------------------------------------------
    */
    public function getPages()
    {
        return $this->jsonResponseService->get(Slider::query(), 'sliders');
    }




    /*
     |-----------------------------------------------
     | BANNERS
     |-----------------------------------------------
    */
    public function getBanners()
    {
        return $this->jsonResponseService->get(Banner::query(), 'banners');
    }




    /*
     |-----------------------------------------------
     | ADD TO WISHLIST
     |-----------------------------------------------
    */
    public function addToWishlist(Request $request)
    {
        Wishlist::firstOrCreate([
            'user_id'               => auth()->id(),
            'product_id'            => $request->product_id,
            'product_variation_id'  => $request->product_variation_id,
        ]);

        return response()->json([
            'data'      => "Success",
            'status'    => 1,
        ]);

    }











    /*
     |-----------------------------------------------
     | GET WISHLIST
     |-----------------------------------------------
    */
    public function getWishlist($user_id)
    {
        try{

            $data['wishlists']  = Wishlist::query()->withCount('user as total_wishlist')->with('product')->where('user_id', $user_id)->get();
            $data['page']       = Page::where('slug', 'wishlist')->first();

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
     |-----------------------------------------------
     | DELETE FROM WISHLIST
     |-----------------------------------------------
    */
    public function deleteFromWishlist($id)
    {
        Wishlist::find($id)->delete();

        return response()->json([
            'data'      => "Success",
            'status'    => 1,
        ]);
    }









    /*
     |-----------------------------------------------
     |  GET HOME PAGE DATA
     |-----------------------------------------------
    */

    public function getHomepageData()
    {
        try{
            $data['sliders']             = Slider::active()->get();

            $data['categories']          = Category::where('parent_id', null)
                                            ->with('childCategories')
                                            ->active()
                                            ->get();

            $data['brands']              = Brand::active()->withCount('products as total_products')->get();

            $data['blogs']               = Blog::active()->get();

            $data['testimonials']        = Testimonial::active()->get();

            $data['highlightTypes']      = HighlightType::active()->get();


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

    public function getCheckoutPageData(){

        $data['districts']   = District::active()->orderBy('name','ASC')->get();

        $data['categories']  = Category::where('parent_id', null)
                                ->with('childCategories')
                                ->active()
                                ->get();

        $data['brands']       = Brand::active()->withCount('products as total_products')->get();

        return $data;
    }



    public function getCommonSectionData($page, $user_id = null)
    {
        $data['company']     = Company::first();
        
        $data['page']        = Page::where('slug', $page)->first();


        $data['categories']  = Category::where('parent_id', null)
                                ->with('childCategories')
                                ->withCount('products as total_products')
                                ->active()
                                ->get();
        $data['districts']   = District::active()->orderBy('name','ASC')->get();
        $data['time_slots']  = TimeSlot::active()->get();




        $data['total_wishlist']    = 0;

        if($user_id != null)
        {
            $data['total_wishlist']    = Wishlist::where('user_id', $user_id)->count('id');
        }

        return $data;


    }



}
