<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\SampleRequest;
use App\Models\Product;
use App\Models\SampleRequestProduct;
use App\Models\SampleReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SampleReturnController extends Controller
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

            $all_sample_return = SampleReturn::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } elseif (Auth::user()->role_id == 1 || Auth::user()->role_id == 11) {
            $all_sample_return = SampleReturn::orderBy('id','desc')->paginate($perPage);
        } else {
            $all_sample_return = SampleReturn::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }

        $search = '';
        return view('backend.sample.return.list', compact('all_sample_return','search','startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
        {
            $users = User::get();
        }else{
            $users = User::where('id', Auth::user()->id)->get();
        }
        return view('backend.sample.return.create', compact('customers','users'));
    }

    public function getInvoice($id, $creator_id)
    {
        $samples = SampleRequest::where('customer_id', $id)->where('creator_id', $creator_id)->where('status',1)->orderBy('id','desc')->get();
        return response()->json($samples, 200);
    }

    public function sampleReturnInvoice(Request $request)
    {
        $sample = SampleRequest::where('id', $request->request_id)->first();
        $sample_products = SampleRequestProduct::where('request_id', $request->request_id)->get();

        return view('backend.sample.return.return-invoice', compact('sample', 'sample_products'));
    }

    public function getSampleProduct(Request $request)
    {
        $sample_product = SampleRequestProduct::with('product','sampleReturn')->where('id', $request->sample_product_id)->first();
        return response()->json($sample_product, 200);
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
                $sample_return_product_data=[];
                for ($key=0; $key < count($request_data['product_id']); $key++) {
                    if($request_data['qty'][$key] > 0){                        

                        $sample_product = SampleRequestProduct::where('request_id', $request->request_id)->where('product_id', $request_data['product_id'][$key])->first();
                        
                        $sample_return_product_data[]=[
                            'date'                => $request->date,
                            'customer_id'         => $request->customer_id,
                            'creator_id'          => $request->creator_id,
                            'request_id'          => $request->request_id,
                            'request_product_id'  => $request_data['sample_product_id'][$key],
                            'product_id'          => $request_data['product_id'][$key],
                            'unit_id'             => $request_data['unit_id'][$key],
                            'qty'                 => $request_data['qty'][$key],
                            'amount'              => $request_data['amount'][$key],
                        ];
                    }
                }
                SampleReturn::insert($sample_return_product_data);
        
                DB::commit();
                return redirect()->route('sample.return.index')->with('message','Product sample return successfully');
            } catch (\Exception $e) {
                return back()->with('error','Product sample return failed. Try another');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sampleReturn  $sampleReturn
     * @return \Illuminate\Http\Response
     */
    public function show(sampleReturn $sampleReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sampleReturn  $sampleReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(sampleReturn $sampleReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sampleReturn  $sampleReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sampleReturn $sampleReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sampleReturn  $sampleReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(sampleReturn $sampleReturn)
    {
        //
    }
}
