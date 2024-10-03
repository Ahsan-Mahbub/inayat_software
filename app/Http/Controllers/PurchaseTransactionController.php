<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseTransaction;
use App\Models\Method;
use App\Models\Account;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;

class PurchaseTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $supplier = Supplier::findOrFail($id);
        $methods = Method::get();
        $transactions = PurchaseTransaction::where('supplier_id', $id)->get();
        return view('backend.purchase.transaction.index', compact('supplier','methods','transactions'));
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
        DB::beginTransaction();

        try {
            if($request->total_amount > 0)
            {
                $item_data=[
                    'supplier_id' => $request->supplier_id,
                    'amount'      => $request->total_amount,
                    'method_id'   => $request->method_id,
                    'account_id'  => $request->account_id,
                    'date'        => $request->date,
                ];
                PurchaseTransaction::insert($item_data);

                //Supplier Information
                $supplier = Supplier::where('id', $request->supplier_id)->first();
                $supplier_amount = [
                    'paid_amount' => $supplier->paid_amount + $request->total_amount,
                ];
                Supplier::where('id', $supplier->id)->update($supplier_amount);

                //Account
                $account = Account::where('id',$request->account_id)->first();
                $data = [
                    'total_amount'   => $account->total_amount - $request->total_amount,
                    'current_amount' => $account->current_amount - $request->total_amount,
                ];
                Account::where('id', $account->id)->update($data);

                DB::commit();
                return back()->with('message','Due Paid Successfully');
            }else{
                return back()->with('error','Amount must be Greater than 0!!');
            }
        }catch (\Exception $e) {
            dd($e);
            return back()->with('error','Due paid failed. Try another');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseTransaction $purchaseTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseTransaction $purchaseTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseTransaction $purchaseTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseTransaction $purchaseTransaction)
    {
        //
    }
}
