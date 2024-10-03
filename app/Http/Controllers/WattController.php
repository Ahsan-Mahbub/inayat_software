<?php

namespace App\Http\Controllers;

use App\Models\Watt;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class WattController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        $all_watt = Watt::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.file.watt.list', compact('all_watt','search','startingSerial'));
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
        $validator = Validator::make($request->all(),[
            'watt_name' => 'nullable|unique:watts',
        ]);
        $requested_data = $request->all();

        $watt = new Watt();
        $save = $watt->fill($requested_data)->save();
        if($save){
            return redirect()->route('watt.index')->with('message','Watt Added Successfully');
        }else{
            return back()->with('error','Watt Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Watt  $watt
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_watt = Watt::where('watt_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_watt = Watt::paginate(15);
        }
        return view('backend.file.watt.list', compact('all_watt','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Watt  $watt
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $watt = Watt::findOrFail($id);
        return response()->json($watt, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Watt  $watt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Watt::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('watt.index')->with('message','Watt Updated Successfully');
        }else{
            return back()->with('error','Watt Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Watt  $watt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Watt::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Watt Successfully Deleted');
    }
}
