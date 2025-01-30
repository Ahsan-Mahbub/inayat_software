<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Sale;
use App\Models\Unit;
use App\Models\User;
use App\Models\Method;
use App\Models\Account;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\SaleReturn;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Models\PurchaseReturn;
use App\Models\PurchaseProduct;
use App\Models\SaleRequisition;
use App\Models\SaleTransaction;
use App\Models\Schedule;
use App\Models\SampleRequestProduct;
use App\Models\SampleReturn;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
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


        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11) {
            $all_sale = Sale::orderBy('id', 'desc')->paginate($perPage);
        } else {
            $all_sale = Sale::where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
        }


        $search = '';
        return view('backend.sale.sale.list', compact('all_sale', 'search', 'startingSerial'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if ($request->searchDataLength >= 0) {
            if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
                $all_sale = Sale::where('invoice', 'LIKE', '%' . $request->search . '%')->orderBy('id', 'desc')
                ->paginate($perPage);
            }else{
                $all_sale = Sale::where('invoice', 'LIKE', '%' . $request->search . '%')->where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->orderBy('id', 'desc')
                ->paginate($perPage);
            }
        }else{
            return back();
        }
        return view('backend.sale.sale.list', compact('all_sale', 'search', 'startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        $methods = Method::get();
        $units = Unit::get();
        $discount = Discount::where('user_id', Auth::user()->id)->first();
        $users = User::get();
        return view('backend.sale.sale.create', compact('customers', 'methods', 'units', 'discount', 'users'));
    }

    public function createRequisition()
    {
        $customers = Customer::get();
        $methods = Method::get();
        $sale_requisitions = Sale::whereNotNull('requisition_id')->pluck('requisition_id');

        $currentUserId = Auth::user()->id;
        if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
            $userIds = User::where(function ($query) {
                $userId = Auth::user()->id;
                $query->where('head_id', $userId)
                    ->orWhere('subhead_id', $userId);
            })
                ->pluck('id');

            $requisitions = SaleRequisition::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                
                ->whereNotIn('id', $sale_requisitions)->where('status', 1)->get();
        }elseif (Auth::user()->role_id == 1) {
            $requisitions = SaleRequisition::whereNotIn('id', $sale_requisitions)->where('status', 1)->get();
        } else {
            $requisitions = SaleRequisition::where('creator_id', Auth::user()->id)->whereNotIn('id', $sale_requisitions)->where('status', 1)->get();
        }
        $users = User::get();
        $discount = Discount::where('user_id', Auth::user()->id)->first();
        return view('backend.sale.sale.requisition-sale', compact('customers', 'methods', 'requisitions', 'discount','users'));
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
            $request_data = $request->all();

            if ($request->requisition_id) {
                $requisition = SaleRequisition::findOrFail($request->requisition_id);
                $customer_id = $requisition->customer_id;
                $requisition_id = $request->requisition_id;

                $order_id = $request->order_id;
                
                //Generate Invoice
                $last_sale = Sale::orderBy('id', 'desc')->select('id')->first();
                $number = $last_sale ? $last_sale->id + 1 : 1;
                $numberString = (string) $number;
                $length = strlen($numberString);
                $zerosToAdd = 5 - $length;
                $invoiceNumber = str_pad($numberString, $length + $zerosToAdd, '0', STR_PAD_LEFT);

                $sale_information = [
                    'date'              => $request->date,
                    'creator_id'        => Auth::user()->id,
                    'customer_id'       => $customer_id,
                    'invoice'           => 'SI' . '-' . $invoiceNumber,
                    'challan'           => 'challan' . '-' . $invoiceNumber,
                    'requisition_id'    => $requisition_id,
                    'subtotal'          => $request->subtotal,
                    'discount'          => $request->discount,
                    'percentage'        => $request->discount ? 1 : 0,
                    'discount_price'    => $request->discount_price,
                    'vat'               => $request->vat,
                    'tax'               => $request->tax,
                    'ait'               => $request->ait,
                    'vat_amount'        => $request->vat_amount,
                    'tax_amount'        => $request->tax_amount,
                    'ait_amount'        => $request->ait_amount,
                    'total_amount'      => $request->total_amount,
                    'paid_amount'       => $request->paid_amount,
                    'due_amount'        => $request->total_amount,
                    'payment_date'      => $request['payment_date'] ? json_encode($request['payment_date']) : null,
                    'payment_amount'    => $request['payment_amount'] ? json_encode($request['payment_amount']) : null,
                ];
            } else {
                if ($request->customer_id == 0) {
                    $customer_update = Customer::orderBy('id', 'desc')->select('id')->first();
                    if (!$customer_update) {
                        $customer_update = 1;
                    } else {
                        $customer_update = $customer_update->id + 1;
                    }

                    $customer_id = (substr($request->customer_name, 0, 3)) . $customer_update;

                    if ($request->customer_name) {
                        $customer = [
                            'customer_name' => $request->customer_name,
                            'phone'         => $request->phone ? $request->phone : '',
                            'customer_id'   => $customer_id,
                        ];

                        $customer_save = Customer::create($customer);
                        $customer_id = $customer_save['id'];
                    } else {
                        return back()->with('error', 'Please Insert Customer Name');
                    }
                } else {
                    $customer_id = $request->customer_id;
                }
                $order_id = $request->order_id;
                //Generate Invoice
                $last_sale = Sale::orderBy('id', 'desc')->select('id')->first();
                $number = $last_sale ? $last_sale->id + 1 : 1;
                $numberString = (string) $number;
                $length = strlen($numberString);
                $zerosToAdd = 5 - $length;
                $invoiceNumber = str_pad($numberString, $length + $zerosToAdd, '0', STR_PAD_LEFT);

                if($request->user_id)
                {
                    $creator_id = $request->user_id;
                }else{
                    $creator_id = Auth::user()->id;
                }

                $sale_information = [
                    'date'              => $request->date,
                    'customer_id'       => $customer_id,
                    'invoice'           => 'SI' . '-' . $invoiceNumber,
                    'challan'           => 'challan' . '-' . $invoiceNumber,
                    'creator_id'        => $creator_id,
                    'subtotal'          => $request->subtotal,
                    'discount'          => $request->discount,
                    'percentage'        => 1,
                    'discount_price'    => $request->discount_price,
                    'vat'               => $request->vat,
                    'tax'               => $request->tax,
                    'ait'               => $request->ait,
                    'vat_amount'        => $request->vat_amount,
                    'tax_amount'        => $request->tax_amount,
                    'ait_amount'        => $request->ait_amount,
                    'total_amount'      => $request->total_amount,
                    'paid_amount'       => $request->paid_amount,
                    'due_amount'        => $request->total_amount,
                    'payment_date'      => $request['payment_date'] ? json_encode($request['payment_date']) : null,
                    'payment_amount'    => $request['payment_amount'] ? json_encode($request['payment_amount']) : null,
                ];
            }

            $save = Sale::create($sale_information);
            $sale_ids = $save['id'];

            //Sale Product
            $sale_product_data = [];
            for ($key = 0; $key < count($request_data['product_id']); $key++) {

                if($request_data['amount'][$key] == 0)
                {
                    $discountPercentage = 0;
                
                    $discountedAmount = 0;
                }else{
                    $discountPercentage = round(($request->subtotal - $request->total_amount) / $request->total_amount, 1);
                
                    $discountedAmount = $request_data['unit_price'][$key] - ($request_data['unit_price'][$key] * $discountPercentage);   
                }

                $sale_product_data[] = [
                    'date'          => $request->date,
                    'sale_id'       => $sale_ids,
                    'product_id'    => $request_data['product_id'][$key],
                    'unit_id'       => $request_data['unit_id'][$key],
                    'purchase_price' => $request_data['purchase_price'][$key] ? $request_data['purchase_price'][$key] : 0,
                    'qty'           => $request_data['buying_qty'][$key],
                    'amount'        => $request_data['amount'][$key],
                    'discount_amount' => $request_data['buying_qty'][$key] * $discountedAmount,
                    'total_profit_amount' => ($request_data['buying_qty'][$key] * $discountedAmount) - ($request_data['buying_qty'][$key] * $request_data['purchase_price'][$key]),
                    'per_profit_amount' => $discountedAmount - $request_data['purchase_price'][$key],
                ];
            }
            SaleProduct::insert($sale_product_data);

            //Schedule
            $schedule = [];
            for ($key = 0; $key < count($request_data['payment_date']); $key++) {

                $schedule[] = [
                    'sale_id'       => $sale_ids,
                    'customer_id'   => $request->customer_id,
                    'date'          => $request_data['payment_date'][$key],
                    'amount'        => $request_data['payment_amount'][$key],
                ];
            }
            Schedule::insert($schedule);

            //Customer Amount
            $customer = Customer::where('id', $customer_id)->first();
            $customer_amount = [
                'total_amount'   => $customer->total_amount + $request->total_amount,
            ];
            Customer::where('id', $customer->id)->update($customer_amount);

            if ($request->total_amount > 0 && $request->sent_message == 1 && strlen($customer->phone) == 11) {
                $number = "88" . $customer->phone;
                $message = "Dear " . $customer->customer_name . ",\n";
                $message .= "Your purchase amount is  ৳ " . number_format($request->total_amount, 2) . ".\n";
                $message .= "Thank you for choosing INAYAT!";
    
                $message_url="https://sms.rapidsms.xyz/request.php?user_id=200501&password=11111111&number=".$number."&message=".urlencode($message);
                $curl = curl_init();
                curl_setopt ($curl, CURLOPT_URL, $message_url);
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                $resultdata = curl_exec ($curl);
                curl_close ($curl);
                $resultArray=json_decode($resultdata, true);
            }

            DB::commit();
            return redirect()->route('sale.index')->with('message', 'Product sale successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Product sale failed. Try another');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function schedule($id)
    {
        $sale = Sale::findOrFail($id);
        $payment_dates = json_decode($sale->payment_date, true);
        $payment_amounts = json_decode($sale->payment_amount, true);
        return view('backend.sale.sale.schedule', compact('sale', 'payment_dates', 'payment_amounts'));
    }

    public function show($id)
    {
        $sale = Sale::findOrFail($id);
        $products = SaleProduct::where('sale_id', $id)->orderBy('id', 'asc')->get();
        $sale_transaction = SaleTransaction::where('sale_id', $id)->get();
        $account = User::where('id', 14)->first();
        return view('backend.sale.sale.invoice', compact('sale', 'products', 'account','sale_transaction'));
    }

    public function challan($id)
    {
        $sale = Sale::findOrFail($id);
        $products = SaleProduct::where('sale_id', $id)->orderBy('id', 'asc')->get();
        $account = User::where('id', 14)->first();
        return view('backend.sale.sale.challan', compact('sale', 'products', 'account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::where('id', $id)->first();
        $sale_transactions = SaleTransaction::where('sale_id', $id)->get();
        if(count($sale_transactions) > 0)
        {
            foreach ($sale_transactions as $transaction) {
                $account = Account::where('id', $transaction->account_id)->first();
                
                if ($account) {
                    $account->total_amount -= $transaction->amount; 
                    $account->current_amount -= $transaction->amount; 
                    $account->save();
                }
            }
            $customer = Customer::where('id', $sale->customer_id)->first();
            $sale_return_amount = SaleReturn::where('sale_id', $id)->sum('amount');
            if ($customer) {
                $customer->total_amount -= $sale->total_amount; 
                $customer->paid_amount -= $sale->paid_amount; 
                $customer->return_amount -= $sale_return_amount; 
                $customer->save();
            }
        }
        SaleReturn::where('sale_id', $id)->delete();
        SaleTransaction::where('sale_id', $id)->delete();
        Sale::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Sale Successfully Deleted');
    }

    public function getSearchProduct(Request $request)
    {

        if ($request->searchDataLength >= 1) {

            $searchTerm = $request->search;
            $products = Product::with('category')->where('product_name', 'like', '%' . $searchTerm . '%')->get();
            if ($products->isEmpty()) {
                $products = Product::with('category')->where('sku', 'like', '%' . $searchTerm . '%')->get();
            }
        } else {
            $products = "";
        }
        $rand = mt_rand(1000000, 9999999);
        return response()->json([
            'products' => $products,
            'rand' => $rand,
        ]);
    }

    public function getProductDetails(Request $request)
    {
        $rand = rand(100000, 999999);
        $productDetails = Product::where('id', $request->product_id)->first();
        return response()->json(['productDetails' => $productDetails, 'rand' => $rand]);
    }

    public function getSaleProduct(Request $request)
    {
        $purchase_product = PurchaseProduct::with('product')->where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->latest('id')->first();
        $purchase_stock = PurchaseProduct::where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->sum('qty');
        $purchase_return_stock = PurchaseReturn::where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->sum('qty');
        $sale_stock = SaleProduct::where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->sum('qty');
        $sale_return_stock = SaleReturn::where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->sum('qty');

        $sample_request_stock = SampleRequestProduct::where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->sum('qty');
        $sample_request_return_stock = SampleReturn::where('product_id', $request->product_id)->where('unit_id', $request->unit_id)->sum('qty');

        $product = Product::where('id', $request->product_id)->first();

        $available_stock = $purchase_stock - $purchase_return_stock - $sale_stock + $sale_return_stock - $sample_request_stock + $sample_request_return_stock;

        $responseData = [
            'purchase_product' => $purchase_product,
            'available_stock' => $available_stock,
            'product' => $product
        ];

        return response()->json($responseData, 200);
    }
}
