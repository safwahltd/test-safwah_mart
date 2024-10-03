<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Menu;
use App\Http\Controllers\Controller;
use Module\WebsiteCMS\Models\Faq;
use Module\WebsiteCMS\Models\MenuCategory;
use Module\WebsiteCMS\Requests\MenuRequest;

class FaqController extends Controller
{






    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {
        $data['faqs']   = Faq::latest()->paginate(25);
        $data['table']  = Faq::getTableName();

        return view('faqs/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {

        return view('faqs/create');
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(Request $request)
    {
        try {
            $this->storeOrUpdate($request);
        } catch (\Throwable $th) {
            throw $th;
        }
        // return to_route('website.faqs.index')->withMessage('Faq Created Success');
        return redirect()->route('website.faqs.index')->withMessage('Faq Successfully Added');
    }





    /**
     * =============================================
     * SHOW METHOD
     * =============================================
     **/
    public function show($id)
    {

    }





    /**
     * =============================================
     * EDIT METHOD
     * =============================================
     **/
    public function edit($id)
    {
        $faq = Faq::find($id);
        return view('faqs/edit', compact('faq'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(Request $request, $id)
    {
        try {
            $this->storeOrUpdate($request, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
        // return to_route('website.faqs.index')->withMessage('Faq update successfully');
        return redirect()->route('website.faqs.index')->withMessage('Faq Successfully Updated');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        // return $this->deleteItem(Faq::class, $id, 'website.faqs.index');

        try {

            $faq = Faq::find($id);

            $faq->delete();

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Faqs deleted successfully!');

    }




    

    /**
     * =============================================
     * STORE OR UPDATE METHOD
     * =============================================
     **/
    public function storeOrUpdate($request, $id = null)
    {
        return Faq::updateOrCreate([
            'id'            => $id,
        ], [
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => $request->status ?? 1,
        ]);
    }


}
