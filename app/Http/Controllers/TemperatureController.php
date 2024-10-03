<?php

namespace App\Http\Controllers;

use App\Models\Temperature;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class TemperatureController extends Controller
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

        $all_temperature = Temperature::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.file.temperature.list', compact('all_temperature','search','startingSerial'));
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
            'temperature_name' => 'nullable|unique:temperatures',
        ]);
        $requested_data = $request->all();

        if($request->ajax()){
            if($validator->passes()){
                Temperature::create([
                    'temperature_name' => $requested_data['temperature_name'],
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Temperature Created Successfully!',
                ]); 
            }
            else{
                return response()->json(['status'=>'error', 'errors'=>$validator->messages()]);
            }             
        }else{
            $temperature = new Temperature();
            $save = $temperature->fill($requested_data)->save();
            if($save){
                return redirect()->route('temperature.index')->with('message','Temperature Added Successfully');
            }else{
                return back()->with('error','Temperature Added Failed!!');
            }
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_temperature = Temperature::where('temperature_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_temperature = Temperature::paginate(15);
        }
        return view('backend.file.temperature.list', compact('all_temperature','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $temperature = Temperature::findOrFail($id);
        return response()->json($temperature, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Temperature::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('temperature.index')->with('message','Temperature Updated Successfully');
        }else{
            return back()->with('error','Temperature Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Temperature::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Temperature Successfully Deleted');
    }
}
