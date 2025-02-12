<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\RequisitionProduct;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\Models\Unit;
use App\Models\User;
Use Illuminate\Support\Facades\Auth;

class RequisitionController extends Controller
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

            $all_requisition = Requisition::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } elseif (Auth::user()->role_id == 1 || Auth::user()->role_id == 11) {
            $all_requisition = Requisition::orderBy('id', 'desc')->paginate($perPage);
        } else {
            $all_requisition = Requisition::where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
        }


        $search = '';
        return view('backend.purchase.requisition.list', compact('all_requisition','search','startingSerial'));
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
            
                $all_requisition = Requisition::where(function ($query) use ($request) {
                        $query->where('requisition_number', 'LIKE', '%' . $request->search . '%');
                    })
                    ->where(function ($query) use ($currentUserId, $userIds) {
                        $query->where('creator_id', $currentUserId)
                              ->orWhereIn('creator_id', $userIds);
                    })
                    ->orderBy('id', 'desc')
                    ->paginate($perPage);
            }
             elseif (Auth::user()->role_id == 6 || Auth::user()->role_id == 11) {
                $all_requisition = Requisition::where('requisition_number', 'LIKE', '%' . $request->search . '%')->where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
            } else {
                $all_requisition = Requisition::where('requisition_number', 'LIKE', '%' . $request->search . '%')->orderBy('id', 'desc')->paginate($perPage);
            }
        } else {
            return back();
        }
        return view('backend.purchase.requisition.list', compact('all_requisition','search','startingSerial')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $suppliers = Supplier::get();
        $units = Unit::get();
        return view('backend.purchase.requisition.create', compact('suppliers','categories','units'));
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
        
                if($request->supplier_id == 0)
                {
                    $supplier_update = Supplier::orderBy('id','desc')->select('id')->first();
                    if(!$supplier_update){
                        $supplier_update = 1;
                    }else{
                        $supplier_update = $supplier_update->id+1;
                    }
                    $supplier_id = (substr( $request->supplier_name, 0,3)). $supplier_update;

                    if($request->supplier_name){
                        $supplier_create = [
                            'supplier_name' => $request->supplier_name,
                            'phone'         => $request->phone ? $request->phone : '',
                            'supplier_id'   => $supplier_id,
                        ];
            
                        $supplier_save = Supplier::create($supplier_create);
                        $supplier_id = $supplier_save['id'];
                    }else{
                        return back()->with('error','Please Insert supplier Name');
                    }
                }else{
                    $supplier_id = $request->supplier_id;
                }

                $last_requisition = Requisition::orderBy('id','desc')->select('id')->first();
                $number = $last_requisition ? $last_requisition->id+1 : 1;
                $numberString = (string) $number;
                $length = strlen($numberString);
                $zerosToAdd = 4 - $length;
                $requisitionNumber = str_pad($numberString, $length + $zerosToAdd, '0', STR_PAD_LEFT); 

                $requisition_information = [
                    'date'              => $request->date,
                    'creator_id'        => Auth::user()->id,
                    'supplier_id'       => $supplier_id,
                    'requisition_number'=> 'PQ'.'-'.$requisitionNumber,
                    'subtotal'          => $request->subtotal,
                    'discount'          => $request->discount,
                    'percentage'        => $request->percentage,
                    'discount_price'    => $request->discount_price,
                    'vat'               => $request->vat,
                    'total_amount'      => $request->total_amount,
                ];
    
                $save = Requisition::create($requisition_information);
                $requisition_ids = $save['id'];
    
                //requisition Product
                $requisition_product_data=[];
                for ($key=0; $key < count($request_data['product_id']); $key++) {
                    if($request_data['amount'][$key] == 0)
                    {
                        $discountPercentage = 0;
                    
                        $discountedAmount = 0;
                    }else{
                        $discountPercentage = round(($request->subtotal - $request->total_amount) / $request->total_amount, 1);
                    
                        $discountedAmount = $request_data['unit_price'][$key] - ($request_data['unit_price'][$key] * $discountPercentage);   
                    }
                    
                    $requisition_product_data[]=[
                        'requisition_id'  =>$requisition_ids,
                        'product_id'      =>$request_data['product_id'][$key],
                        'unit_id'         =>$request_data['unit_id'][$key],
                        'qty'             =>$request_data['buying_qty'][$key],
                        'amount'          =>$request_data['amount'][$key],
                        'discount_amount' =>$request_data['buying_qty'][$key]*$discountedAmount,
                    ];
                }
                RequisitionProduct::insert($requisition_product_data);

                DB::commit();
                return redirect()->route('requisition.index')->with('message','Product Quotation successfully');
            } catch (\Exception $e) {
                return back()->with('error','Product Quotation failed. Try another');
            }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requisition = Requisition::findOrFail($id);
        $products=RequisitionProduct::where('requisition_id', $id)->orderBy('id', 'asc')->get();
        return view('backend.purchase.requisition.invoice', compact('requisition','products'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requisition = Requisition::with('requisitionProduct')->findOrFail($id);

        $supplier = Supplier::where('id', $requisition->supplier_id)->first();
        $units = Unit::get();

        return view('backend.purchase.requisition.edit', compact('supplier', 'units', 'requisition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisition  $requisition
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

            $supplier_id = $request->supplier_id;

            $requisition = Requisition::findOrFail($request->requisition_main);

            $check_requisition = Requisition::where('duplicate_requ', $request->requisition_main)->count();

            if ($check_requisition <= 0) {
                $requisition_number = $requisition->requisition_number . '/' . 1;
            } else {
                $requisition_number = $requisition->requisition_number . '/' . ($check_requisition + 1);
            }

            $requisition_information = [
                'date'              => $request->date,
                'editor_id'         => Auth::user()->id,
                'creator_id'        => $request->creator_id,
                'supplier_id'       => $supplier_id,
                'requisition_number'=> $requisition_number,
                'subtotal'          => $request->subtotal,
                'discount'          => 0,
                'percentage'        => 0,
                'discount_price'    => $request->subtotal,
                'vat'               => 0,
                'total_amount'      => $request->subtotal,
                'duplicate_requ'    => $request->requisition_main,
            ];

            $save = Requisition::create($requisition_information);
            $requisition_ids = $save['id'];

            //requisition Product
            $requisition_product_data = [];
            for ($key = 0; $key < count($request_data['product_id']); $key++) {

                $requisition_product_data[] = [
                    'requisition_id'  => $requisition_ids,
                    'product_id'      => $request_data['product_id'][$key],
                    'unit_id'         => $request_data['unit_id'][$key],
                    'qty'             => $request_data['buying_qty'][$key],
                    'amount'          => $request_data['amount'][$key],
                    'discount_amount' => $request_data['amount'][$key],
                ];
            }
            RequisitionProduct::insert($requisition_product_data);

            DB::commit();
            return redirect()->route('requisition.index')->with('message', 'Quotation successfully');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Quotation failed. Try another');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Requisition::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Purchase Quotation Successfully Deleted');
    }

    public function requisitionActive(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id)->update([
            'status' => 1,
        ]);

        return back()->with('message', 'Quotation Status updated successfully!');
    }


    public function requisitionDeActive(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id)->update([
            'status' => 2,
        ]);

        return back()->with('message', 'Quotation Status updated successfully!');
    }

    public function getSearchProduct(Request $request){
        if ($request->searchDataLength >= 1) {
                        
            $searchTerm = $request->search;
            $products = Product::with('category')->where('product_name', 'like', '%' . $searchTerm . '%')->get();
            if ($products->isEmpty()) {
                $products = Product::with('category')->where('sku', 'like', '%' . $searchTerm . '%')->get();
            }

        }else{
            $products = "";
        }
        $rand = mt_rand(1000000, 9999999);
        return response()->json([
            'products' => $products,
            'rand' => $rand,
        ]);
    }

    public function getProduct(Request $request)
    {
        $purchase_product = PurchaseProduct::with('product')->where('product_id', $request->product_id)->where('unit_id',$request->unit_id)->latest('id')->first();
        $product = Product::where('id', $request->product_id)->first();
        $responseData = [
            'purchase_product' => $purchase_product,
            'product' => $product
        ];

        return response()->json($responseData, 200);
    }


    public function getProductDetails(Request $request){
        $rand = rand(100000, 999999);
        $productDetails = Product::where('id', $request->product_id)->first();
        return response()->json(['productDetails' => $productDetails, 'rand' => $rand]);
    }

    public function getRequisitionId(Request $request)
    {
        $data['requisition'] = Requisition::with('requisitionProduct')->findOrFail($request->id);
        return response()->json($data);
    }

    public function getData($id)
    {
        $lists = Requisition::findOrFail($id);
        return response()->json($lists, 201);
    }
}
