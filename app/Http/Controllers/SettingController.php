<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Setting::first();
        return view('backend.file.setting.index', compact('info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Setting::findOrFail($id);
        $formData = $request->all();
        // if ($request->hasFile('image')) {
        //     if (File::exists($update->image)) {
        //         File::delete($update->image);
        //     }
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $name = 'image' . Str::random(5) . '.' . $extension;
        //     $path = "backend/assets/images/logo/";
        //     $request->file('image')->move($path, $name);
        //     $formData['image'] = $path . $name;
        // }
        $updated = $update->fill($formData)->save();
        if($updated){
            return back()->with('message','Information Updated Successfully');
        }else{
            return back()->with('error','Information Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
