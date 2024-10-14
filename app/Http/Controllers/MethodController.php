<?php

namespace App\Http\Controllers;

use App\Models\Method;
use Illuminate\Http\Request;
use File;
use Str;

class MethodController extends Controller
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

        $all_method = Method::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.account.method.list', compact('all_method','search','startingSerial'));
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
        $validated = $request->validate([
            'method_name' => 'nullable|unique:methods',
        ]);

        $method = new Method();
        $requested_data = $request->all();
        $save = $method->fill($requested_data)->save();
        if($save){
            return redirect()->route('method.index')->with('message','Method Added Successfully');
        }else{
            return back()->with('error','Method Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_method = Method::where('method_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_method = Method::paginate(15);
        }
        return view('backend.account.method.list', compact('all_method','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $method = Method::findOrFail($id);
        return response()->json($method, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Method::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('method.index')->with('message','Method Updated Successfully');
        }else{
            return back()->with('error','Method Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Method::where('id', $id)->firstorfail()->delete();
        return back()->with('message','Method Successfully Deleted');
    }
}
