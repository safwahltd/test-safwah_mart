<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MetaInfo;
use Illuminate\Support\Facades\DB;
use Module\WebsiteCMS\Models\Blog;
use App\Traits\FileSaver;
use PhpOffice\PhpSpreadsheet\Writer\Ods\MetaInf;
use App\Traits\CheckPermission;

class SeoInfoController extends Controller
{

    use CheckPermission;


     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create(Request $request, $page_title)
    {
        $this->hasAccess("website-cms.meta-tag");

        $previous_url = $this->getPreviousUrl($request);
        $seoInfo = MetaInfo::where('page_title', $page_title)->first();

        return view('seo-infos.create', compact('seoInfo', 'page_title', 'previous_url'));
    }








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request, $page_title)
    {
        try {

            MetaInfo::updateOrCreate(['page_title' => $page_title], [

                'alt_text'         => $request->alt_text,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            return redirect()->back()->withMessage('Seo Info Successfully Saved!');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }

    private function getPreviousUrl($request)
    {
        if($request->filled('previous_url')) {
            $data = [
                'discount' => route('discounts.index'),
                'offer'    => route('pdt.offers.index'),
                'category' => route('pdt.categories.index'),
                'brand'    => route('pdt.brands.index'),
                'blog'     => route('website.blogs.index'),
            ];

            if(isset($data[$request->previous_url])) {
                return $data[$request->previous_url];
            }
        }

        return url()->previous();
    }


    /*
    |--------------------------------------------------------------------------
    | BULK CREATE METHOD
    |--------------------------------------------------------------------------
   */
   public function bulkCreate(Request $request)
   {
       $this->hasAccess("website-cms.meta-tag");

       $seoInfos = MetaInfo::get();

       return view('seo-infos.bulk-create', compact('seoInfos'));
   }





   /*
    |--------------------------------------------------------------------------
    | BULK STORE METHOD
    |--------------------------------------------------------------------------
   */
   public function bulkStore(Request $request)
   {
       try {

            foreach ($request->titles as $key => $title) {
                MetaInfo::updateOrCreate(['page_title' => $title], [

                    'alt_text'         => $request->alt_texts[$key],
                    'meta_title'       => $request->meta_titles[$key],
                    'meta_description' => $request->meta_descriptions[$key],
                ]);
            }



            return redirect()->back()->withMessage('Seo Info Successfully Saved!');

       } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
       }
   }
}
