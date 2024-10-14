<?php

namespace App\Http\Controllers;

use App\Models\Method;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
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

        $all_account = Account::orderBy('id','desc')->paginate($perPage);
        $search = '';
        $methods = Method::get();
        return view('backend.account.account.list', compact('all_account','search','startingSerial','methods'));
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
            'account_name' => 'nullable|unique:accounts',
        ]);

        $account = new Account();
        $requested_data = $request->all();
        if($request->total_amount > 0)
        {
            $account->current_amount = $request->total_amount;
        }
        $save = $account->fill($requested_data)->save();
        if($save){
            return redirect()->route('account.index')->with('message','Account Added Successfully');
        }else{
            return back()->with('error','Account Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_account = Account::where('account_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_account = Account::paginate(15);
        }
        return view('backend.account.account.list', compact('all_account','search','startingSerial')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return response()->json($account, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Account::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('account.index')->with('message','Account Updated Successfully');
        }else{
            return back()->with('error','Account Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Account::where('id', $id)->firstorfail()->delete();
        return back()->with('message','Account Successfully Deleted');
    }
}
