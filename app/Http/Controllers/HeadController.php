<?php

namespace App\Http\Controllers;

use App\Models\Head;
use Illuminate\Http\Request;

class HeadController extends Controller
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

        $all_head = Head::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.office-expense.head.list', compact('all_head','search','startingSerial'));
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
            'head_name' => 'nullable|unique:heads',
        ]);

        $head = new Head();
        $requested_data = $request->all();
        $save = $head->fill($requested_data)->save();
        if($save){
            return redirect()->route('head.index')->with('message','Head Added Successfully');
        }else{
            return back()->with('error','Head Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_head = Head::where('head_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_head = Head::paginate(15);
        }
        return view('backend.office-expense.head.list', compact('all_head','search','startingSerial')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $head = Head::findOrFail($id);
        return response()->json($head, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Head::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('head.index')->with('message','Head Updated Successfully');
        }else{
            return back()->with('error','Head Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Head::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Head Successfully Deleted');
    }
}
