<?php

namespace App\Http\Controllers;

use App\Models\SubHead;
use App\Models\Head;
use Illuminate\Http\Request;

class SubHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $heads = Head::get();
        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        $all_sub_head = SubHead::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.office-expense.sub-head.list', compact('all_sub_head','search','startingSerial','heads'));
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
            'subhead_name' => 'nullable|unique:sub_heads',
        ]);

        $sub_head = new SubHead();
        $requested_data = $request->all();
        $save = $sub_head->fill($requested_data)->save();
        if($save){
            return redirect()->route('sub-head.index')->with('message','Sub Head Added Successfully');
        }else{
            return back()->with('error','Sub Head Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubHead  $sub_head
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $heads = Head::get();
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_sub_head = SubHead::where('subhead_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_sub_head = SubHead::paginate(15);
        }
        return view('backend.office-expense.sub-head.list', compact('all_sub_head','search','startingSerial','heads')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubHead  $sub_head
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_head = SubHead::findOrFail($id);
        return response()->json($sub_head, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubHead  $sub_head
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = SubHead::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('sub-head.index')->with('message','Sub Head Updated Successfully');
        }else{
            return back()->with('error','Sub Head Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubHead  $sub_head
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubHead::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Sub Head Successfully Deleted');
    }
}
