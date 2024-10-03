<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class UnitController extends Controller
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

        $all_unit = Unit::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.file.unit.list', compact('all_unit','search','startingSerial'));
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
            'unit_name' => 'nullable|unique:units',
        ]);
        $requested_data = $request->all();

        if($request->ajax()){
            if($validator->passes()){
                Unit::create([
                    'unit_name' => $requested_data['unit_name'],
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Unit Created Successfully!',
                ]); 
            }
            else{
                return response()->json(['status'=>'error', 'errors'=>$validator->messages()]);
            }             
        }else{
            $unit = new Unit();
            $save = $unit->fill($requested_data)->save();
            if($save){
                return redirect()->route('unit.index')->with('message','Unit Added Successfully');
            }else{
                return back()->with('error','Unit Added Failed!!');
            }
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_unit = Unit::where('unit_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_unit = Unit::paginate(15);
        }
        return view('backend.file.unit.list', compact('all_unit','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Unit::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('unit.index')->with('message','Unit Updated Successfully');
        }else{
            return back()->with('error','Unit Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Unit::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Unit Successfully Deleted');
    }
}
