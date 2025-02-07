<?php

namespace App\Http\Controllers;

use App\Models\SaleRequisition;
use App\Models\SaleRequisitionProduct;
use App\Models\Product;
use App\Models\Customer;
use App\Models\PurchaseProduct;
use App\Models\PurchaseReturn;
use App\Models\SaleProduct;
use App\Models\SaleReturn;
use App\Models\Unit;
use App\Models\Discount;
use App\Models\SampleRequestProduct;
use App\Models\SampleReturn;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class SaleRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 50;
        $currentUserId = Auth::user()->id;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
            $userIds = User::where(function ($query) {
                $userId = Auth::user()->id;
                $query->where('head_id', $userId)
                    ->orWhere('subhead_id', $userId);
            })->pluck('id');

            $all_requisition = SaleRequisition::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } elseif(Auth::user()->role_id == 1) {
            $all_requisition = SaleRequisition::orderBy('id', 'desc')->paginate($perPage);
        }else {
            $all_requisition = SaleRequisition::where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
        }

        
        $search = '';


        return view('backend.sale.requisition.list', compact('all_requisition', 'search', 'startingSerial'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $currentUserId = Auth::user()->id;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if ($request->searchDataLength >= 0) {
            if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
                $userIds = User::where(function ($query) use ($currentUserId) {
                    $query->where('head_id', $currentUserId)
                          ->orWhere('subhead_id', $currentUserId);
                })->pluck('id');
            
                $all_requisition = SaleRequisition::where(function ($query) use ($request) {
                        $query->where('requisition_number', 'LIKE', '%' . $request->search . '%');
                    })
                    ->where(function ($query) use ($currentUserId, $userIds) {
                        $query->where('creator_id', $currentUserId)
                              ->orWhereIn('creator_id', $userIds);
                    })
                    ->orderBy('id', 'desc')
                    ->paginate($perPage);
            }elseif (Auth::user()->role_id == 6 || Auth::user()->role_id == 11) {
                $all_requisition = SaleRequisition::where('requisition_number', 'LIKE', '%' . $request->search . '%')->where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
            } else {
                $all_requisition = SaleRequisition::where('requisition_number', 'LIKE', '%' . $request->search . '%')->orderBy('id', 'desc')->paginate($perPage);
            }
        } else {
            return back();
        }
        return view('backend.sale.requisition.list', compact('all_requisition', 'search', 'startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role_id == 1) {
            $customers = Customer::get();
        } else {
            $customers = Customer::where('creator_id', Auth::user()->id)->get();
        }
        $units = Unit::get();
        $discount = Discount::where('user_id', Auth::user()->id)->first();
        $users = User::get();
        return view('backend.sale.requisition.create', compact('customers', 'units', 'discount','users'));
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

            if ($request->customer_id == 0) {
                $customer_update = Customer::orderBy('id', 'desc')->select('id')->first();
                if (!$customer_update) {
                    $customer_update = 1;
                } else {
                    $customer_update = $customer_update->id + 1;
                }
                $customer_id = (substr($request->customer_name, 0, 3)) . $customer_update;

                if ($request->customer_name) {
                    $customer_create = [
                        'customer_name' => $request->customer_name,
                        'phone'         => $request->phone ? $request->phone : '',
                        'customer_id'   => $customer_id,
                        'creator_id'    => Auth::user()->id,
                    ];

                    $customer_save = Customer::create($customer_create);
                    $customer_id = $customer_save['id'];
                } else {
                    return back()->with('error', 'Please Insert Customer Name');
                }
            } else {
                $customer_id = $request->customer_id;
            }

            $last_requisition = SaleRequisition::orderBy('id', 'desc')->select('id')->first();
            $number = $last_requisition ? $last_requisition->id + 1 : 1;
            $numberString = (string) $number;
            $length = strlen($numberString);
            $zerosToAdd = 4 - $length;
            $requisitionNumber = str_pad($numberString, $length + $zerosToAdd, '0', STR_PAD_LEFT);

            $currentDate = date("Y-m-d");
            $month = date("m", strtotime($currentDate));
            $date = date("d", strtotime($currentDate));
            $year = date("y", strtotime($currentDate));

            if($request->user_id)
            {
                $creator_name = User::where('id', $request->user_id)->select('name')->first();
                $creator_id = $request->user_id;
            }else{
                $creator_name = User::where('id', Auth::user()->id)->select('name')->first();
                $creator_id = Auth::user()->id;
            }

            $requisition_information = [
                'date'              => $request->date,
                'creator_id'        => $creator_id,
                'customer_id'       => $customer_id,
                'requisition_number' => 'SQ' . '-' . $requisitionNumber . '/' . $month . $date . $year . '/' . $creator_name->name,
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
                'trams_condition'   => $request->trams_condition,
                'show_terms'        => $request->show_terms ? $request->show_terms : '0',
            ];

            $save = SaleRequisition::create($requisition_information);
            $requisition_ids = $save['id'];

            // dd($request->all());

            //requisition Product
            $requisition_product_data = [];
            for ($key = 0; $key < count($request_data['product_id']); $key++) {
                if ($request_data['amount'][$key] == 0) {
                    $discountPercentage = 0;
                    $discountedAmount = 0;
                } else {
                    $discountPercentage = round(($request->subtotal - $request->total_amount) / $request->total_amount, 1);
                    $discountedAmount = $request_data['unit_price'][$key] - ($request_data['unit_price'][$key] * $discountPercentage);
                }

                $requisition_product_data[] = [
                    'requisition_id'  => $requisition_ids,
                    'product_id'      => $request_data['product_id'][$key],
                    'des_show'        => $request_data['des_show'][$key],
                    'description'     => $request_data['description'][$key],
                    'unit_id'         => $request_data['unit_id'][$key],
                    'purchase_price'  => $request_data['purchase_price'][$key],
                    'sale_price'      => $request_data['unit_price'][$key],
                    'qty'             => $request_data['buying_qty'][$key],
                    'amount'          => $request_data['amount'][$key],
                    'discount_amount' => $request_data['buying_qty'][$key] * $discountedAmount,
                ];
            }
            SaleRequisitionProduct::insert($requisition_product_data);

            DB::commit();
            return redirect()->route('sale.requisition.index')->with('message', 'Sale Quotation successfully');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Sale Quotation failed. Try another');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleRequisition  $saleRequisition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requisition = SaleRequisition::findOrFail($id);
        $products = SaleRequisitionProduct::where('requisition_id', $id)->orderBy('id', 'asc')->get();
        return view('backend.sale.requisition.invoice', compact('requisition', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleRequisition  $saleRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requisition = SaleRequisition::with('requisitionProduct')->findOrFail($id);

        $customer = Customer::where('id', $requisition->customer_id)->first();
        $units = Unit::get();
        $discount = Discount::where('user_id', Auth::user()->id)->first();

        return view('backend.sale.requisition.edit', compact('customer', 'units', 'discount', 'requisition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleRequisition  $saleRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'product_id' => 'required',
            ]);
            $request_data = $request->all();

            if ($request->customer_id == 0) {
                $customer_update = Customer::orderBy('id', 'desc')->select('id')->first();
                if (!$customer_update) {
                    $customer_update = 1;
                } else {
                    $customer_update = $customer_update->id + 1;
                }
                $customer_id = (substr($request->customer_name, 0, 3)) . $customer_update;

                if ($request->customer_name) {
                    $customer_create = [
                        'customer_name' => $request->customer_name,
                        'phone'         => $request->phone ? $request->phone : '',
                        'customer_id'   => $customer_id,
                    ];

                    $customer_save = Customer::create($customer_create);
                    $customer_id = $customer_save['id'];
                } else {
                    return back()->with('error', 'Please Insert Customer Name');
                }
            } else {
                $customer_id = $request->customer_id;
            }

            $requisition = SaleRequisition::findOrFail($request->requisition_main);

            $check_requisition = SaleRequisition::where('duplicate_requ', $request->requisition_main)->count();

            if ($check_requisition <= 0) {
                $requisition_number = $requisition->requisition_number . '/' . 1;
            } else {
                $requisition_number = $requisition->requisition_number . '/' . ($check_requisition + 1);
            }

            $requisition_information = [
                'date'              => $request->date,
                'editor_id'         => Auth::user()->id,
                'creator_id'        => $request->creator_id,
                'customer_id'       => $customer_id,
                'requisition_number' => $requisition_number,
                'subtotal'          => $request->subtotal,
                'discount'          => $request->discount,
                'percentage'        => $request->percentage,
                'discount_price'    => $request->discount_price,
                'vat'               => $request->vat,
                'tax'               => $request->tax,
                'ait'               => $request->ait,
                'vat_amount'        => $request->vat_amount,
                'tax_amount'        => $request->tax_amount,
                'ait_amount'        => $request->ait_amount,
                'total_amount'      => $request->total_amount,
                'trams_condition'   => $request->trams_condition,
                'show_terms'        => $request->show_terms ? $request->show_terms : '0',
                'duplicate_requ'    => $request->requisition_main,
            ];

            $save = SaleRequisition::create($requisition_information);
            $requisition_ids = $save['id'];

            //requisition Product
            $requisition_product_data = [];
            for ($key = 0; $key < count($request_data['product_id']); $key++) {
                $discountPercentage = round(($request->subtotal - $request->total_amount) / $request->total_amount, 1);

                $discountedAmount = $request_data['unit_price'][$key] - ($request_data['unit_price'][$key] * $discountPercentage);

                $requisition_product_data[] = [
                    'requisition_id'  => $requisition_ids,
                    'product_id'      => $request_data['product_id'][$key],
                    'des_show'        => $request_data['des_show'][$key],
                    'description'     => $request_data['description'][$key],
                    'unit_id'         => $request_data['unit_id'][$key],
                    'purchase_price'  => $request_data['purchase_price'][$key] ? $request_data['purchase_price'][$key] : 0,
                    'sale_price'      => $request_data['unit_price'][$key],
                    'qty'             => $request_data['buying_qty'][$key],
                    'amount'          => $request_data['amount'][$key],
                    'discount_amount' => $request_data['buying_qty'][$key] * $discountedAmount,
                ];
            }
            SaleRequisitionProduct::insert($requisition_product_data);

            DB::commit();
            return redirect()->route('sale.requisition.index')->with('message', 'Sale Quotation successfully');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Sale Quotation failed. Try another');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleRequisition  $saleRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = SaleRequisition::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Sale Quotation Successfully Deleted');
    }

    public function requisitionActive(Request $request, $id)
    {
        $requisition = SaleRequisition::findOrFail($id)->update([
            'status' => 1,
        ]);

        return back()->with('message', 'Sale Quotation Status updated successfully!');
    }


    public function requisitionDeActive(Request $request, $id)
    {
        $requisition = SaleRequisition::findOrFail($id)->update([
            'status' => 2,
        ]);

        return back()->with('message', 'Sale Quotation Status updated successfully!');
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

        $available_stock = $purchase_stock - $purchase_return_stock - $sale_stock + $sale_return_stock - $sample_request_stock + $sample_request_return_stock;

        $product = Product::where('id', $request->product_id)->first();

        $responseData = [
            'purchase_product' => $purchase_product,
            'available_stock' => $available_stock,
            'product' => $product
        ];

        return response()->json($responseData, 200);
    }

    public function getRequisitionId(Request $request)
    {
        $data['requisition'] = SaleRequisition::with('requisitionProduct')->findOrFail($request->id);
        return response()->json($data);
    }

    public function getData($id)
    {
        $lists = SaleRequisition::findOrFail($id);
        return response()->json($lists, 201);
    }
}
