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
use Auth;

class RequisitionController extends Controller
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

        $all_requisition = Requisition::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.purchase.requisition.list', compact('all_requisition','search','startingSerial'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_requisition = Requisition::where('requisition_number', 'LIKE', '%' .$request->search . '%')->orderBy('id','desc')
                                    ->paginate($perPage);
        }
        else {
            $all_requisition = Requisition::orderBy('id','desc')->paginate(15);
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
    public function edit(Requisition $requisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisition $requisition)
    {
        //
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
