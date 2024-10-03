<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleTransaction;
use Illuminate\Http\Request;
use File;
use Str;
use Auth;

class CustomerController extends Controller
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

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
            $all_customer = Customer::orderBy('id','desc')->paginate($perPage);
        }else{
            $all_customer = Customer::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }
        $search = '';
        return view('backend.sale.customer.list', compact('all_customer','search','startingSerial'));
    }

    public function dues(Request $request)
    {
        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
            $all_customer = Customer::orderBy('id','desc')->paginate($perPage);
        }else{
            $all_customer = Customer::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }
        $search = '';
        return view('backend.sale.customer.dues', compact('all_customer','search','startingSerial'));
    }

    public function dueSearch(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
                $all_customer = Customer::where('customer_name', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('customer_id', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
            }else{
                $all_customer = Customer::where('creator_id', Auth::user()->id)->where('customer_name', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('customer_id', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
            }
            
        }
        else {
            $all_customer = Customer::paginate(15);
        }
        return view('backend.sale.customer.dues', compact('all_customer','search','startingSerial')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $sales = Sale::where('customer_id', $id)->get();
        $returns = SaleReturn::where('customer_id', $id)->get();
        $transactions = SaleTransaction::where('customer_id', $id)->get();
        return view('backend.sale.customer.profile', compact('customer','transactions','returns','sales'));
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
            'phone' => 'nullable|unique:customers',
            'email' => 'nullable|unique:customers',
        ]);
        
        $customer = new Customer();
        $requested_data = $request->all();
        $customer->creator_id = Auth::user()->id;
        $customer_update = Customer::orderBy('id','desc')->select('id')->first();

        if(!$customer_update){
            $customer_update = 1;
        }else{
            $customer_update = $customer_update->id+1;
        }

        $customer->customer_id = 'CUS-' . (substr( $request->customer_name, 0,3)). $customer_update;

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/customer/";
            $request->file('image')->move($path, $name);
            $requested_data['image'] = $path . $name;
        }
        $save = $customer->fill($requested_data)->save();
        if($save){
            return back()->with('message','Client Added Successfully');
        }else{
            return back()->with('error','Client Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
                $all_customer = Customer::where('customer_name', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('customer_id', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
            }else{
                $all_customer = Customer::where('creator_id', Auth::user()->id)->where('customer_name', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('customer_id', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
            }
            
        }
        else {
            $all_customer = Customer::paginate(15);
        }
        return view('backend.sale.customer.list', compact('all_customer','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Customer::findOrFail($id);
        $formData = $request->all();

        if ($request->hasFile('image')) {
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/customer/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('customer.index')->with('message','Client Updated Successfully');
        }else{
            return back()->with('error','Client Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Customer::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Client Successfully Deleted');
    }
}
