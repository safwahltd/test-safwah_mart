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
use Module\WebsiteCMS\Models\SocialLink;
use Module\WebsiteCMS\Models\Testimonial;
use Module\WebsiteCMS\Services\JsonResponseService;
use PhpOffice\PhpSpreadsheet\Writer\Ods\MetaInf;

class BlogController extends Controller
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

            $data['seoInfo']     = MetaInfo::where('page_title', 'Article')->first();
            $data['blogs']       = Blog::active()->paginate(100);
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
     | BLOGS METHOD
     |--------------------------------------------------------------------------
    */
    public function getBlogDetails($slug)
    {
        try{
            $data['seoInfo']    = MetaInfo::where('page_title', 'Article')->first();
            $data['blog']       = Blog::where('slug', $slug)->first();
            $data['page']       = Page::where('slug', 'blog-details')->first();

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
