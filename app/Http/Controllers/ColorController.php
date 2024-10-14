<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        $all_color = Color::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.file.color.list', compact('all_color','search','startingSerial'));
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
            'color_name' => 'nullable|unique:colors',
        ]);
        $requested_data = $request->all();

        if($request->ajax()){
            if($validator->passes()){
                Color::create([
                    'color_name' => $requested_data['color_name'],
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Color Created Successfully!',
                ]); 
            }
            else{
                return response()->json(['status'=>'error', 'errors'=>$validator->messages()]);
            }             
        }else{
            $color = new Color();
            $save = $color->fill($requested_data)->save();
            if($save){
                return redirect()->route('color.index')->with('message','Color Added Successfully');
            }else{
                return back()->with('error','Color Added Failed!!');
            }
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_color = Color::where('color_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_color = Color::paginate(15);
        }
        return view('backend.file.color.list', compact('all_color','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return response()->json($color, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Color::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('color.index')->with('message','Color Updated Successfully');
        }else{
            return back()->with('error','Color Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Color::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Color Successfully Deleted');
    }
}
