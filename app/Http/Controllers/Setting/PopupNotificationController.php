<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\PopupNotification;
use App\Http\Controllers\Controller;
use App\Traits\FileSaver;

class PopupNotificationController extends Controller
{
    use FileSaver;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popupNotifications = PopupNotification::get();

        return view('popup-notifications.index', compact('popupNotifications'));
    }

    public function getPopNotifications()
    {
        $popupNotifications = PopupNotification::query()->active()->get();

        return response()->json([
            "popupNotifications" => $popupNotifications,
            "time_limit"         => optional(\App\Models\EcomSetting::where('id', 34)->first())->value ?? 0
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('popup-notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'       => 'required',
        ]);

        $popupNotification = PopupNotification::create([
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => date('Y-m-d'),
            'status'      => 1
        ]);

        $this->upload_file($request->image, $popupNotification, 'image', 'popup-notifications');

        return redirect()->back()->withSuccess('Notification successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PopupNotification  $popupNotification
     * @return \Illuminate\Http\Response
     */
    public function show(PopupNotification $popupNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PopupNotification  $popupNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(PopupNotification $popupNotification)
    {
        return view('popup-notifications.edit', compact('popupNotification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PopupNotification  $popupNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PopupNotification $popupNotification)
    {

        $popupNotification->update([
            'status'      => $request->has('status') ? 1 : 0,
            'title'       => $request->title,
            'description' => $request->description,
        ]);


        $this->upload_file($request->image, $popupNotification, 'image', 'popup-notifications');


        return redirect()->back()->withSuccess('Notification successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PopupNotification  $popupNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PopupNotification $popupNotification)
    {
        try {

            $image = $popupNotification->image;

            $popupNotification->delete();
            if (file_exists($image)) {
                unlink($image);
            }

            return redirect()->back()->withSuccess('Notification successfully deleted');
        } catch (\Throwable $th) {

            return redirect()->back()->withError($th->getMessage());
        }
    }
}
