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
use App\Models\MetaInfo;
use Module\WebsiteCMS\Models\Banner;
use Module\WebsiteCMS\Models\Slider;
use Module\Inventory\Models\TimeSlot;
use Module\WebsiteCMS\Models\Wishlist;
use Module\Product\Models\HighlightType;
use Module\Product\Models\StockRequest;
use Module\WebsiteCMS\Models\Contact;
use Module\WebsiteCMS\Models\InstructionNote;
use Module\WebsiteCMS\Models\PageSection;
use Module\WebsiteCMS\Models\Service;
use Module\WebsiteCMS\Models\SocialLink;
use Module\WebsiteCMS\Models\Subscriber;
use Module\WebsiteCMS\Models\SubscribersContent;
use Module\WebsiteCMS\Models\Testimonial;
use Module\WebsiteCMS\Services\JsonResponseService;
use Illuminate\Support\Str;

class ApiController extends Controller
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

        try {

            $data['blogs']       = Blog::active()->paginate(10);
            $data['page']        = Page::where('slug', 'blog')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }



    /*
     |--------------------------------------------------------------------------
     | SUBMIT CONTACT FORM METHOD
     |--------------------------------------------------------------------------
    */
    public function submitContactForm(Request $request)
    {
        Contact::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'subject'   => $request->subject,
            'message'   => $request->message,
        ]);
    }



    /*
     |--------------------------------------------------------------------------
     | SUBMIT SUBSCRIBER EMAIL METHOD
     |--------------------------------------------------------------------------
    */
    public function submitSubscriberEmail(Request $request)
    {
        Subscriber::create([
            'email'       => $request->email,
            'status'      => 1,
            'created_by'  => 1,
        ]);
    }




    /*
     |--------------------------------------------------------------------------
     | HIGHLIGHTED BLOGS METHOD
     |--------------------------------------------------------------------------
    */
    public function getLatestHighlightedBlogs()
    {
        return $this->jsonResponseService->get(Blog::query()->latest()->take(2)->active(), 'blogs');
    }






    /*
     |--------------------------------------------------------------------------
     | HIGHLIGHTED BLOGS METHOD
     |--------------------------------------------------------------------------
    */
    public function getHighlightedBlogs()
    {
        return $this->jsonResponseService->get(Blog::query()->active(), 'blogs');
    }







    /*
     |--------------------------------------------------------------------------
     | TESTIMONIALS METHOD
     |--------------------------------------------------------------------------
    */
    public function getTestimonials()
    {
        return $this->jsonResponseService->get(Testimonial::query()->active(), 'testimonials');
    }



    /*
     |--------------------------------------------------------------------------
     | SOCIAL LINKS METHOD
     |--------------------------------------------------------------------------
    */
    public function getSocialLinks()
    {
        return $this->jsonResponseService->get(SocialLink::query()->active(), 'socialLinks');
    }



    /*
     |--------------------------------------------------------------------------
     | SUBSCRIBER CONTENT METHOD
     |--------------------------------------------------------------------------
    */
    public function getSubscribersContent()
    {
        try {

            $data['subscribers_content']       = SubscribersContent::first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }


    /*
     |--------------------------------------------------------------------------
     | SERVICES METHOD
     |--------------------------------------------------------------------------
    */
    public function getServices()
    {
        return $this->jsonResponseService->get(Service::query()->active()->orderBy('id', 'DESC')->take(4), 'services');
    }



    /**
     * =============================================
     * SLIDER
     * =============================================
     **/
    public function getSliders()
    {
        return $this->jsonResponseService->get(Slider::query()->active(), 'sliders');
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
     | PAGE SECTIONS SECTION
     |-----------------------------------------------
    */
    public function PageSections()
    {
        try {

            $data['page_sections']       = PageSection::where('page_id', 15)->select('id', 'page_id', 'title', 'status')->get();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }






    /*
     |-----------------------------------------------
     | GET INSTRUCTION NOTES
     |-----------------------------------------------
    */
    public function getInstructionNotes($slug)
    {
        try {


            $data['instruction_notes']  = InstructionNote::where('slug', $slug)->first();
            $data['seoInfo']            = MetaInfo::where('page_title', 'like', '%' . Str::headline($slug) . '%')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }




    /*
     |-----------------------------------------------
     | SINGLE PAGE SECTION
     |-----------------------------------------------
    */
    public function getPageSection($slug)
    {
        try {

            $page = Page::where('slug', $slug)->first();

            $data['pageSection']       = PageSection::where('page_id', $page->id)->with('page')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }






    /*
     |-----------------------------------------------
     | SINGLE PAGE
     |-----------------------------------------------
    */
    public function getPage($slug)
    {
        try {

            $data['page']       = Page::where('slug', $slug)->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
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
     | PROMO PART ONE
     |-----------------------------------------------
    */
    public function getPromoPartOne()
    {
        return $this->jsonResponseService->get(Banner::query()->promoPartOne(), 'promoPartOne');
    }





    /*
     |-----------------------------------------------
     | PROMO PART TWO
     |-----------------------------------------------
    */
    public function getPromoPartTwo()
    {
        return $this->jsonResponseService->get(Banner::query()->promoPartTwo(), 'promoPartTwo');
    }







    /*
     |-----------------------------------------------
     | PROMO PART ONE
     |-----------------------------------------------
    */
    public function getPromoPartOneThreeBanner()
    {
        return $this->jsonResponseService->get(Banner::query()->promoPartOneThreeBanner(), 'promoPartOne');
    }





    /*
     |-----------------------------------------------
     | PROMO PART TWO
     |-----------------------------------------------
    */
    public function getPromoPartTwoOneBanner()
    {
        return $this->jsonResponseService->get(Banner::query()->promoPartTwoOneBanner(), 'promoPartTwo');
    }



    /*
     |-----------------------------------------------
     | PROMO PART THREE
     |-----------------------------------------------
    */
    public function getPromoPartThreeThreeBanner()
    {
        return $this->jsonResponseService->get(Banner::query()->promoPartThreeThreeBanner(), 'promoPartThree');
    }



    /*
     |-----------------------------------------------
     | PROMO PART THREE
     |-----------------------------------------------
    */
    public function getPromoPartFourThreeBanner()
    {
        return $this->jsonResponseService->get(Banner::query()->promoPartFourThreeBanner(), 'promoPartFour');
    }

    /*
     |-----------------------------------------------
     | ADD TO WISHLIST
     |-----------------------------------------------
    */
    public function addToWishlist(Request $request)
    {
        Wishlist::firstOrCreate([
            'user_id'               => $request->user_id,
            'product_id'            => $request->product_id,
            'product_variation_id'  => $request->product_variation_id,
        ]);

        $wishlistCount = Wishlist::where('user_id', $request->user_id)->count();

        return response()->json([
            'data'          => "Success",
            'status'        => 1,
            'wishlistCount' => $wishlistCount,
        ]);
    }











    /*
     |-----------------------------------------------
     | GET CUSTOMER WISHLIST BY PRODUCT
     |-----------------------------------------------
    */
    public function getCustomerWishlistByProduct($user_id, $product_id)
    {
        try {

            $data['product_wishlists']  = Wishlist::query()
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->select(['id', 'user_id', 'product_id'])
                ->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }







    /*
     |-----------------------------------------------
     | GET WISHLIST
     |-----------------------------------------------
    */
    public function getWishlist($user_id)
    {
        try {

            $data['wishlists']  = Wishlist::query()
                ->where('user_id', $user_id)
                ->withCount('user as total_wishlist')
                ->with(['product' => function ($query) {
                    $query->with('discount')
                        ->withSum('stockSummaries as current_stock', 'balance_qty')
                        ->with('unitMeasure:id,name');
                }])
                ->get();

            $data['page']       = Page::where('slug', 'wishlist')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

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
        $wishlist = Wishlist::find($id);
        $user_id = $wishlist->user_id;

        $wishlist->delete();

        $wishlistCount = Wishlist::where('user_id', $user_id)->count();

        return response()->json([
            'data'          => "Success",
            'status'        => 1,
            'wishlistCount' => $wishlistCount,
        ]);
    }









    /*
     |-----------------------------------------------
     | DELETE FROM STOCK REQUST
     |-----------------------------------------------
    */
    public function deleteFromStockRequest($id)
    {
        $stockRequest = StockRequest::where('id', $id)->first();

        $stockRequest->delete();

        return response()->json([
            'data'          => "Success",
            'message'       => "Deleted",
            'status'        => 1,
        ]);
    }









    /*
     |-----------------------------------------------
     |  GET HOME PAGE DATA
     |-----------------------------------------------
    */

    public function getHomepageData()
    {
        try {
            $data['sliders']            = Slider::active()->get();

            $data['categories']         = Category::where('parent_id', null)
                ->with('childCategories')
                ->active()
                ->get();

            $data['brands']             = Brand::active()
                ->inRandomOrder()
                ->whereHas('products')
                ->withCount('products as total_products')
                ->get();

            $data['blogs']              = Blog::active()
                ->inRandomOrder()
                ->get();

            $data['testimonials']       = Testimonial::active()
                ->inRandomOrder()
                ->get();

            $data['highlightTypes']     = HighlightType::active()
                ->whereHas('productHighlightTypes')
                ->get();

            // $data['page_sections']       = PageSection::where('page_id',50)->select('id','page_id','title')->get();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }

    public function getCheckoutPageData()
    {

        $data['districts']   = District::active()->orderBy('name', 'ASC')->get();

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
        $data['districts']   = District::active()->orderBy('name', 'ASC')->get();
        $data['time_slots']  = TimeSlot::active()->get();




        $data['total_wishlist']    = 0;

        if ($user_id != null) {
            $data['total_wishlist']    = Wishlist::where('user_id', $user_id)->count('id');
        }

        return $data;
    }
}
