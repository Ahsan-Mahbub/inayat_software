<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleTransaction;
use App\Models\Method;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;
use DB;

class SaleTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $customer = Customer::findOrFail($id);
        $methods = Method::get();
        $sales = Sale::where('customer_id', $id)->get();
        $transactions = SaleTransaction::where('customer_id', $id)->get();
        return view('backend.sale.transaction.index', compact('customer','methods','transactions','sales'));
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
            $request_data = $request->all();
            if($request->total_amount > 0)
            {

                //Sale Transaction  Data
                foreach ($request_data['sale_id'] as $key => $sale_id) {
                    if($request_data['amount'][$key] > 0){
                        SaleTransaction::create([
                            'customer_id' => $request->customer_id,
                            'amount'      => $request_data['amount'][$key],
                            'method_id'   => $request->method_id,
                            'account_id'  => $request->account_id,
                            'date'        => $request->date,
                            'sale_id'     => $request_data['sale_id'][$key],
                        ]);
                    }
                }
                

                //Customer Information
                $customer = Customer::where('id', $request->customer_id)->first();
                $customer_amount = [
                    'paid_amount' => $customer->paid_amount + $request->total_amount,
                    'adjustment_amount' => $customer->adjustment_amount + $request->total_adjustment_amount,
                ];
                Customer::where('id', $customer->id)->update($customer_amount);

                //Account
                $account = Account::where('id',$request->account_id)->first();
                $data = [
                    'total_amount'   => $account->total_amount + $request->total_amount,
                    'current_amount' => $account->current_amount + $request->total_amount,
                ];
                Account::where('id', $account->id)->update($data);

                //Invoice Data
                foreach ($request_data['sale_id'] as $key => $sale_id) {
                    $sale = Sale::where('id', $sale_id)->first();
                    $sale->update([
                        'paid_amount' => $sale->paid_amount + $request_data['amount'][$key],
                        'due_amount'  => $sale->due_amount - $request_data['amount'][$key],
                        'adjustment_amount' => $sale->adjustment_amount + $request_data['adjustment'][$key],
                    ]);
                }

                DB::commit();
                return back()->with('message','Due Collection Successfully');
            }else{
                return back()->with('error','Amount must be Greater than 0!!');
            }
        }catch (\Exception $e) {
            dd($e);
            return back()->with('error','Due Collection failed. Try another');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleTransaction  $saleTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(SaleTransaction $saleTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleTransaction  $saleTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleTransaction $saleTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\saleTransaction  $saleTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, saleTransaction $saleTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\saleTransaction  $saleTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale_transaction = SaleTransaction::where('id', $id)->first();
        if($sale_transaction)
        {
            $account = Account::where('id', $sale_transaction->account_id)->first();
            if ($account) {
                $account->total_amount -= $sale_transaction->amount; 
                $account->current_amount -= $sale_transaction->amount; 
                $account->save();
            }
            $sale = Sale::where('id', $sale_transaction->sale_id)->first();
            if ($sale) {
                $sale->paid_amount -= $sale_transaction->amount; 
                $sale->due_amount += $sale_transaction->amount;
                $sale->save();
            }
            $customer = Customer::where('id', $sale_transaction->customer_id)->first();
            if ($customer) {
                $customer->paid_amount -= $sale_transaction->amount;
                $customer->adjustment_amount -= $sale_transaction->amount;
                $customer->save();
            }
        }
        SaleTransaction::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Sale Transaction Successfully Deleted');
    }
}
