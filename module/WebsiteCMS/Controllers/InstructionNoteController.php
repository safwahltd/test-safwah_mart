<?php

namespace Module\WebsiteCMS\Controllers;

use Illuminate\Http\Request;
use Module\WebsiteCMS\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use Module\WebsiteCMS\Models\InstructionNote;

class InstructionNoteController extends Controller
{


    /**
     * =============================================
     * INDEX METHOD
     * =============================================
     **/
    public function index()
    {

        $data['instruction_notes']      = InstructionNote::query()
                                        ->searchByField('name')
                                        ->orderBy('id', 'DESC')
                                        ->paginate(25);

        $data['table']      = InstructionNote::getTableName();

        return view('instruction-notes/index', $data);
    }







    /**
     * =============================================
     * Created Method
     * =============================================
     **/
    public function create()
    {
        $serial_no = InstructionNote::orderBy('id', 'DESC')->first();
        $next_serial_no = $serial_no ? $serial_no->serial_no + 1 : 1;

        return view('pages/create', compact('next_serial_no'));
    }




    /**
     * =============================================
     * Store a newly created resource in storage.
     * =============================================
     **/
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|unique:web_instruction_notes',
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:web_instruction_notes',
            'serial_no' => 'required|unique:web_instruction_notes',
        ]);


        try {
            DB::transaction(function () use ($request){
                $instruction_note = InstructionNote::create([
                    'name'                     => $request->name,
                    'description'              => $request->description,
                    'slug'                     => $request->slug,
                    'seo_title'                => $request->seo_title,
                    'seo_description'          => $request->seo_description,
                    'serial_no'                => $request->serial_no,
                    'show_in_quick_links'      => !empty($request->show_in_quick_links) ? 1 : 0,
                    'status'                   => !empty($request->status) ? 1 : 0,
                ]);

                // $this->uploadFileWithResize($request->image, $instruction_note, 'image', 'images/page/image', '450');

                $this->uploadFileWithResize($request->banner_image, $instruction_note, 'banner_image', 'images/page/banner-image', '1200', '500');
            });
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }


        return redirect()->route('website.instruction-notes.index')->withMessage('Page has been created successfully');
    }





    /**
     * =============================================
     * SHOW METHOD
     * =============================================
     **/
    public function show($id)
    {

        $data['instruction_note'] = InstructionNote::find($id);

        return view('instruction-notes/view', $data);
    }





    /**
     * =============================================
     * EDIT METHOD
     * =============================================
     **/
    public function edit(InstructionNote $instruction_note)
    {
        return view('instruction-notes/edit', compact('instruction_note'));
    }






    /**
     * =============================================
     * UPDATE METHOD
     * =============================================
     **/
    public function update(Request $request, $id)
    {
        $instruction_note = InstructionNote::find($id);

        $request->validate([
            'name'      => 'required|unique:web_instruction_notes,name,'.$instruction_note->id,
            'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:web_instruction_notes,slug,'.$instruction_note->id,
        ]);

        try {

            $instruction_note->update([
                'name'                     => $request->name,
                'slug'                     => $request->slug,
                'description'              => Purifier::clean($request->description),
                'status'                   => !empty($request->status) ? 1 : 0,
            ]);

        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }


        return redirect()->route('website.instruction-notes.index')->withMessage('Data has been updated successfully');
    }






    /**
     * =============================================
     * DESTROY/DELETE METHOD
     * =============================================
     **/
    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {
                $instruction_note = InstructionNote::find($id);

                $instruction_note->delete();
            });

        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }


        return redirect()->back()->withMessage('Data has been deleted successfully!');
    }
}
