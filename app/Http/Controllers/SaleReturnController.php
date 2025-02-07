<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleProduct;
use App\Models\SaleReturn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
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

        $currentUserId = Auth::user()->id;

        if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
            $userIds = User::where(function ($query) {
                $userId = Auth::user()->id;
                $query->where('head_id', $userId)
                    ->orWhere('subhead_id', $userId);
            })->pluck('id');

            $all_sale_return = SaleReturn::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } elseif (Auth::user()->role_id == 1 || Auth::user()->role_id == 11) {
            $all_sale_return = SaleReturn::orderBy('id','desc')->paginate($perPage);
        } else {
            $all_sale_return = SaleReturn::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }
        $search = '';
        return view('backend.sale.return.list', compact('all_sale_return','search','startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        return view('backend.sale.return.create', compact('customers'));
    }

    public function getInvoice($id)
    {
        $sales = Sale::where('customer_id', $id)->orderBy('id','desc')->get();
        return response()->json($sales, 200);
    }

    public function saleReturnInvoice(Request $request)
    {
        $sale = Sale::where('id', $request->sale_id)->first();
        $sale_products = SaleProduct::where('sale_id', $request->sale_id)->get();

        return view('backend.sale.return.return-invoice', compact('sale', 'sale_products'));
    }

    public function getSaleProduct(Request $request)
    {
        $sale_product = SaleProduct::with('product','saleReturn')->where('id', $request->sale_product_id)->first();
        return response()->json($sale_product, 200);
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
                $validated = $request->validate([
                    'product_id' => 'required',
                ]);
                $request_data=$request->all();
        
                //Return Product
                $sale_return_product_data=[];
                for ($key=0; $key < count($request_data['product_id']); $key++) {
                    if($request_data['qty'][$key] > 0){                        

                        $sale_product = SaleProduct::where('sale_id', $request->sale_id)->where('product_id', $request_data['product_id'][$key])->first();
                        
                        $sale_return_product_data[]=[
                            'date'                => $request->date,
                            'customer_id'         => $request->customer_id,
                            'creator_id'          => Auth::user()->id,
                            'sale_id'             => $request->sale_id,
                            'sale_product_id'     => $request_data['sale_product_id'][$key],
                            'product_id'          => $request_data['product_id'][$key],
                            'unit_id'             => $request_data['unit_id'][$key],
                            'qty'                 => $request_data['qty'][$key],
                            'amount'              => $request_data['amount'][$key],
                            'return_per_profit'   => $sale_product->per_profit_amount,
                        ];
                    }
                }
                SaleReturn::insert($sale_return_product_data);

                //Customer Amount
                $customer = Customer::where('id', $request->customer_id)->first();
                $customer_amount = [
                    'return_amount' => $customer->return_amount + $request->total_return_amount,
                ];
                Customer::where('id', $customer->id)->update($customer_amount);
        
                DB::commit();
                return redirect()->route('sale.return.index')->with('message','Product sale return successfully');
            } catch (\Exception $e) {
                dd($e);
                return back()->with('error','Product sale return failed. Try another');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\saleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function show(SaleReturn $saleReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\saleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleReturn $saleReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\saleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, saleReturn $saleReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\saleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleReturn $saleReturn)
    {
        //
    }
}
