<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Method;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use App\Models\Requisition;
use App\Models\Unit;
use Auth;

class PurchaseController extends Controller
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

        $all_purchase = Purchase::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.purchase.purchase.list', compact('all_purchase','search','startingSerial'));
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
        $methods = Method::get();
        $units = Unit::get();
        return view('backend.purchase.purchase.create', compact('suppliers','methods','categories','units'));
    }
    public function createRequisition()
    {
        $categories = Category::get();
        $suppliers = Supplier::get();
        $methods = Method::get();
        $purchase_requisitions = Purchase::whereNotNull('requisition_id')->pluck('requisition_id');
        if(Auth::user()->role_id == 1)
        {
            $requisitions = Requisition::whereNotIn('id', $purchase_requisitions)->where('status',1)->get();
        }else{
            $requisitions = Requisition::whereNotIn('id', $purchase_requisitions)->where('creator_id', Auth::user()->role_id)->where('status',1)->get();
        }
        return view('backend.purchase.purchase.requisition_purchase', compact('suppliers','methods','categories', 'requisitions'));
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
            // dd($request->all());

            try {
                $validated = $request->validate([
                    'product_id' => 'required',
                ]);
                $request_data=$request->all();

                $last_purchase = Purchase::orderBy('id','desc')->select('id')->first();
                $number = $last_purchase ? $last_purchase->id+1 : 1;
                $numberString = (string) $number;
                $length = strlen($numberString);
                $zerosToAdd = 4 - $length;
                $purchaseNumber = str_pad($numberString, $length + $zerosToAdd, '0', STR_PAD_LEFT); 
                
                if($request->requisition_id)
                {
                    $requisition = Requisition::findOrFail($request->requisition_id);
                    $supplier_id = $requisition->supplier_id;
                    $requisition_id = $request->requisition_id;

                    $purchase_information = [
                        'date'              => $request->date,
                        'creator_id'        => Auth::user()->id,
                        'supplier_id'       => $supplier_id,
                        'requisition_id'    => $requisition_id,
                        'invoice'           => 'PI'.'-'.$purchaseNumber,
                        'subtotal'          => $request->subtotal,
                        'discount'          => $request->discount,
                        'percentage'        => $request->percentage,
                        'discount_price'    => $request->discount_price,
                        'vat'               => $request->vat,
                        'total_amount'      => $request->total_amount,
                        'paid_amount'       => $request->paid_amount,
                        'due_amount'        => $request->due_amount,
                    ];
                    
                }else
                {
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
                        }else
                        {
                            return back()->with('error','Please Insert supplier Name');
                        }
                    }else
                    {
                        $supplier_id = $request->supplier_id;
                    }
                    $purchase_information = [
                        'date'              => $request->date,
                        'supplier_id'       => $supplier_id,
                        'creator_id'        => Auth::user()->id,
                        'invoice'           => 'PI'.'-'.$purchaseNumber,
                        'subtotal'          => $request->subtotal,
                        'discount'          => $request->discount,
                        'percentage'        => $request->percentage,
                        'discount_price'    => $request->discount_price,
                        'vat'               => $request->vat,
                        'total_amount'      => $request->total_amount,
                        'paid_amount'       => $request->paid_amount,
                        'due_amount'        => $request->due_amount,
                    ];
                }
    
                $save = Purchase::create($purchase_information);
                $purchase_ids = $save['id'];
    
                //Purchase Product
                $purchase_product_data=[];
                for ($key=0; $key < count($request_data['product_id']); $key++) {

                    if($request_data['amount'][$key] == 0)
                    {
                        $discountPercentage = 0;
                    
                        $discountedAmount = 0;
                    }else{
                        $discountPercentage = round(($request->subtotal - $request->total_amount) / $request->total_amount, 1);
                    
                        $discountedAmount = $request_data['unit_price'][$key] - ($request_data['unit_price'][$key] * $discountPercentage);   
                    }

                    
                    $purchase_product_data[]=[
                        'purchase_id'     =>$purchase_ids,
                        'product_id'      =>$request_data['product_id'][$key],
                        'unit_id'         =>$request_data['unit_id'][$key],
                        'qty'             =>$request_data['buying_qty'][$key],
                        'amount'          =>$request_data['amount'][$key],
                        'discount_amount' =>$request_data['buying_qty'][$key]*$discountedAmount,
                        'actual_sale_amount'=>$request_data['sale_price'][$key],
                    ];
                }
                PurchaseProduct::insert($purchase_product_data);
                
                DB::commit();
                return redirect()->route('purchase.index')->with('message','Product purchase successfully');
            } catch (\Exception $e) {
                return back()->with('error','Product purchase failed. Try another');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::findOrFail($id);
        $products=PurchaseProduct::where('purchase_id', $id)->orderBy('id', 'asc')->get();
        $account = User::where('id', 14)->first();
        return view('backend.purchase.purchase.invoice', compact('purchase','products','account'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_purchase = Purchase::where('invoice', 'LIKE', '%' .$request->search . '%')->orderBy('id','desc')
                                    ->paginate($perPage);
        }
        else {
            $all_purchase = Purchase::orderBy('id','desc')->paginate(15);
        }
        return view('backend.purchase.purchase.list', compact('all_purchase','search','startingSerial')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::with('purchaseProduct')->findOrFail($id);

        $supplier = Supplier::where('id', $purchase->supplier_id)->first();
        $units = Unit::get();

        return view('backend.purchase.purchase.edit', compact('supplier', 'units', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        // dd($request->all());

        try {
            $validated = $request->validate([
                'product_id' => 'required',
            ]);
            $request_data=$request->all();

            $purchase = Purchase::findOrFail($id);

            $purchase_information = [
                'subtotal'          => $request->subtotal,
                'total_amount'      => $request->subtotal,
                'due_amount'        => $request->subtotal,
            ];

            $purchase->update($purchase_information);

            //Purchase Product
            $purchase_product_data = [];
            for ($key = 0; $key < count($request_data['product_id']); $key++) {
                $purchase_product_data[] = [
                    'purchase_id'        => $id,
                    'product_id'         => $request_data['product_id'][$key],
                    'unit_id'            => $request_data['unit_id'][$key],
                    'qty'                => $request_data['buying_qty'][$key],
                    'amount'             => $request_data['amount'][$key],
                    'discount_amount'    => $request_data['amount'][$key],
                    'actual_sale_amount' => $request_data['sale_price'][$key],
                ];
            }
            // Update or Insert Purchase Products
            foreach ($purchase_product_data as $product_data) {
                $purchaseProduct = PurchaseProduct::where('purchase_id', $id)
                    ->where('product_id', $product_data['product_id'])
                    ->first();

                if ($purchaseProduct) {
                    $purchaseProduct->update($product_data);
                } else {
                    PurchaseProduct::create($product_data);
                }
            }
            // Remove products that are no longer
            $existingProductIds = PurchaseProduct::where('purchase_id', $id)->pluck('product_id')->toArray();
            $incomingProductIds = $request_data['product_id'];
            $productsToDelete = array_diff($existingProductIds, $incomingProductIds);

            if (!empty($productsToDelete)) {
                PurchaseProduct::where('purchase_id', $id)
                    ->whereIn('product_id', $productsToDelete)
                    ->delete();
            }
            
            DB::commit();
            return redirect()->route('purchase.index')->with('message','Product purchase successfully');
        } catch (\Exception $e) {
            return back()->with('error','Product purchase failed. Try another');
        }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Purchase::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Purchase Successfully Deleted');
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

    public function getProductDetails(Request $request){
        $rand = rand(100000, 999999);
        $productDetails = Product::where('id', $request->product_id)->first();
        return response()->json(['productDetails' => $productDetails, 'rand' => $rand]);
    }

    public function getQty()
    {
        $products = Product::get();
        $units = Unit::get();
        $search_product = '';
        $search_unit = '';
        $invoice_product = '';
        return view('backend.purchase.purchase.get-product', compact('products','units','search_product','search_unit','invoice_product'));
    }

    public function getProductQty(Request $request)
    {
        $products = Product::get();
        $units = Unit::get();
        $search_product = $request->product_id;
        $search_unit = $request->unit_id;

        $invoice_product = PurchaseProduct::where('product_id', $search_product)->where('unit_id', $search_unit)->orderBy('id','desc')->first();

        return view('backend.purchase.purchase.get-product', compact('products','units','search_product','search_unit','invoice_product'));
    }

    public function updateProductQty(Request $request, $id)
    {
        $product = Product::where('id',$request->product_id)->first();

        $now_add_price = $product->purchase_price * $request->qty;

        $purchase_product = PurchaseProduct::findOrFail($id);

        $purchase_product_information = [
            'qty'               => $purchase_product->qty + $request->qty,
            'amount'            => $purchase_product->amount + $now_add_price,
            'discount_amount'   => $request->discount_amount + $now_add_price,
        ];
        $purchase_product->update($purchase_product_information);

        $purchase = Purchase::where('id',$purchase_product->purchase_id)->first();
        $purchase_information = [
            'subtotal'       => $purchase->subtotal + $now_add_price,
            'discount_price' => $purchase->discount_price + $now_add_price,
            'total_amount'   => $request->discount_amount + $now_add_price,
            'due_amount'     => $request->due_amount + $now_add_price,
        ];
        $purchase->update($purchase_information);

        return back()->with('success', 'Product Qty Update Successfully');

    }
}
