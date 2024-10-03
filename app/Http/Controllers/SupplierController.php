<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseTransaction;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;
use File;
use Str;

class SupplierController extends Controller
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

        $all_supplier = Supplier::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.purchase.supplier.list', compact('all_supplier','search','startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        $purchases = Purchase::where('supplier_id', $id)->get();
        $returns = PurchaseReturn::where('supplier_id', $id)->get();
        $transactions = PurchaseTransaction::where('supplier_id', $id)->get();
        return view('backend.purchase.supplier.profile', compact('supplier','transactions','returns','purchases'));
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
            'phone' => 'nullable|unique:suppliers',
            'email' => 'nullable|unique:suppliers',
        ]);

        $supplier = new Supplier();
        $requested_data = $request->all();
        $supplier_update = Supplier::orderBy('id','desc')->select('id')->first();

        if(!$supplier_update){
            $supplier_update = 1;
        }else{
            $supplier_update = $supplier_update->id+1;
        }

        $supplier->supplier_id = 'SUP-' . (substr( $request->supplier_name, 0,3)). $supplier_update;

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/supplier/";
            $request->file('image')->move($path, $name);
            $requested_data['image'] = $path . $name;
        }
        $save = $supplier->fill($requested_data)->save();
        if($save){
            return back()->with('message','Supplier Added Successfully');
        }else{
            return back()->with('error','supplier Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_supplier = Supplier::where('supplier_name', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('supplier_id', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                    ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_supplier = Supplier::paginate(15);
        }
        return view('backend.purchase.supplier.list', compact('all_supplier','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Supplier::findOrFail($id);
        $formData = $request->all();

        if ($request->hasFile('image')) {
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/supplier/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('supplier.index')->with('message','Supplier Updated Successfully');
        }else{
            return back()->with('error','Supplier Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Supplier::where('id', $id)->firstorfail()->delete();
        return back()->with('message','Supplier Successfully Deleted');
    }
}
