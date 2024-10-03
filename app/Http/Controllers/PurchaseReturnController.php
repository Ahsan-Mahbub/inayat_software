<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;
use DB;

class PurchaseReturnController extends Controller
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

        $all_purchase_return = PurchaseReturn::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.purchase.return.list', compact('all_purchase_return','search','startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::get();
        return view('backend.purchase.return.create', compact('suppliers'));
    }

    public function getInvoice($id)
    {
        $purchases = Purchase::where('supplier_id', $id)->orderBy('id','desc')->get();
        return response()->json($purchases, 200);
    }

    public function purchaseReturnInvoice(Request $request)
    {
        $purchase = Purchase::where('id', $request->purchase_id)->first();
        $purchase_products = PurchaseProduct::where('purchase_id', $request->purchase_id)->get();

        return view('backend.purchase.return.return-invoice', compact('purchase', 'purchase_products'));
    }

    public function getPurchaseProduct(Request $request)
    {
        $purchase_product = PurchaseProduct::with('product','purchaseReturn')->where('id', $request->purchase_product_id)->first();
        return response()->json($purchase_product, 200);
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
                $purchase_return_product_data=[];
                for ($key=0; $key < count($request_data['product_id']); $key++) {
                    if($request_data['qty'][$key] > 0){
        
                        
                        $purchase_return_product_data[]=[
                            'date'                => $request->date,
                            'supplier_id'         => $request->supplier_id,
                            'purchase_id'         => $request->purchase_id,
                            'product_id'          => $request_data['product_id'][$key],
                            'unit_id'             => $request_data['unit_id'][$key],
                            'purchase_product_id' => $request_data['purchase_product_id'][$key],
                            'qty'                 => $request_data['qty'][$key],
                            'amount'              => $request_data['amount'][$key],
                        ];
                    }
                }
                PurchaseReturn::insert($purchase_return_product_data);

                //Supplier Amount
                // $supplier = Supplier::where('id', $request->supplier_id)->first();
                // $supplier_amount = [
                //     'return_amount' => $supplier->return_amount + $request->total_return_amount,
                // ];
                // Supplier::where('id', $supplier->id)->update($supplier_amount);

                DB::commit();
                return redirect()->route('purchase.return.index')->with('message','Product purchase return successfully');
            } catch (\Exception $e) {
                dd($e);
                return back()->with('error','Product purchase return failed. Try another');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        //
    }
}
