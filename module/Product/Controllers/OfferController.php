<?php

namespace Module\Product\Controllers;

use App\Traits\FileSaver;
use Illuminate\Http\Request;
use Module\Product\Models\Offer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\CheckPermission;

class OfferController extends Controller
{
    use FileSaver;
    use CheckPermission;





    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
       $this->hasAccess("product-offer.index");

       $data['offers']  = Offer::query()
                        ->orderBy('id', 'DESC')
                        ->likeSearch('name')
                        ->withCount('productDiscounts as total_product')
                        ->paginate(30);
                        
        $data['table']  = Offer::getTableName();

        return view('offer/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("product-offer.index");

        $serial_no = Offer::orderBy('id', 'DESC')->first();
        $next_serial_no = $serial_no ? $serial_no->serial_no + 1 : 1;

        return view('offer/create', compact('next_serial_no'));
    }




    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->hasAccess("product-offer.index");

        $request->validate([ 
            'name'      => 'required|unique:pdt_offers',
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_offers',
            'serial_no' => 'required|unique:pdt_offers',
            // 'image'     => 'nullabled|mimes:jpg,jpeg,png,gif,jfif,webp'
        ]);

        try {

            DB::transaction(function () use ($request) {
                $offer = Offer::create([
                    'name'          => $request->name,
                    'slug'          => $request->slug,
                    'serial_no'     => $request->serial_no,
                    // 'banner_image'  => 'default.png',
                    'status'        => !empty($request->status) ? 1 : 0,
                ]);
                
                // $this->uploadFileWithResize($request->banner_image, $offer, 'banner_image', 'images/offer', 450);
            });

            return redirect()->route('pdt.offers.index')->withMessage('Offer has been successfully created');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("product-offer.index");

        return view('offer/edit', [ 'offer' => Offer::find($id) ]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);
       
        $request->validate([ 
            'name'      => 'required|unique:pdt_offers,name,'.$offer->id,
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_offers,slug,'.$offer->id,
            'serial_no' => 'required|unique:pdt_offers,serial_no,'.$offer->id,
            // 'image'     => 'nullabled|mimes:jpg,jpeg,png,gif,jfif,webp'
        ]);

        try {

            DB::transaction(function () use ($offer, $request) {
                $offer->update([
                    'name'          => $request->name,
                    'slug'          => $request->slug,
                    'serial_no'     => $request->serial_no,
                    // 'banner_image'  => $offer->banner_image,
                    'status'        => !empty($request->status) ? 1 : 0,
                ]);
                
                // $this->uploadFileWithResize($request->banner_image, $offer, 'banner_image', 'images/offer', 450);
            });

            return redirect()->route('pdt.offers.index')->withMessage('Offer has been updated successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("product-offer.index");

        try {

            $offer = Offer::where('id', $id)->with('productDiscounts')->first();

            if(file_exists($offer->banner_image))
            {
                unlink($offer->banner_image);
            }

            $offer->productDiscounts()->delete();
            $offer->delete();

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Offer has been deleted successfully');
    }
}
