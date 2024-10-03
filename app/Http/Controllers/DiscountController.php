<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
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

        $all_discount = Discount::orderBy('id','desc')->paginate($perPage);
        $search = '';
        $users = User::get();
        return view('backend.file.discount.list', compact('all_discount','search','startingSerial','users'));
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
            'user_id' => 'required|unique:discounts',
            'discount' => 'required',
        ]);

        $discount = new Discount();
        $requested_data = $request->all();
        $save = $discount->fill($requested_data)->save();
        if($save){
            return redirect()->route('discount.index')->with('message','Discount Added Successfully');
        }else{
            return back()->with('error','Discount Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_discount = Discount::where('discount', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_discount = Discount::paginate(15);
        }
        return view('backend.discount.discount.list', compact('all_discount','search','startingSerial')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return response()->json($discount, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Discount::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('discount.index')->with('message','Discount Updated Successfully');
        }else{
            return back()->with('error','Discount Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Discount::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Discount Successfully Deleted');
    }
}
