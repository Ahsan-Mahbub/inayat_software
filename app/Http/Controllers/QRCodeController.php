<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use App\Models\Product;
use App\Models\Watt;
use App\Models\Color;
use App\Models\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class QRCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $all_qrcode = QRCode::orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->get();
        $watts = Watt::get();   
        $colors = Color::get();  
        $temperatures = Temperature::get();  
        return view('backend.file.qr-code.list', compact('all_qrcode', 'products','watts','colors','temperatures'));
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
    // public function store(Request $request)
    // {
    //     if($request->product_id)
    //     {
    //         if ($request->quantity) {
    //             $quantity = $request->quantity;
    //         } else {
    //             $quantity = 1;
    //         }
    //         if ($request->action_type == 'save')
    //         {
    //             $qr_code = new QRCode();
    //             $qr_code->product_id = $request->product_id;
    //             if($request->watt_id)
    //             {
    //                 $qr_code->watt_id = $request->watt_id ? $request->watt_id : '';
    //             }
    //             if($request->color_id)
    //             {
    //                 $qr_code->color_id = $request->color_id ? $request->color_id : '';
    
    //             }
    //             if($request->temperature_id)
    //             {
    //                 $qr_code->temperature_id = $request->temperature_id ? $request->temperature_id : '';
    
    //             }
    //             if($request->dimmable_type)
    //             {
    //                 $qr_code->dimmable_type = $request->dimmable_type ? $request->dimmable_type : '';
    //             }
    //             if($request->size)
    //             {
    //                 $qr_code->size = $request->size ? $request->size : '';
    
    //             }
    //             if($request->patch_type)
    //             {
    //                 $qr_code->patch_type = $request->patch_type ? $request->patch_type : '';
    
    //             }
    //             if($request->channel_type)
    //             {
    //                 $qr_code->channel_type = $request->channel_type ? $request->channel_type : '';
    
    //             }
    //             $qr_code->quantity = $quantity;
    //             $qr_code->save();
                
    //             return redirect()->route('qr-code.index')->with('message','QR Code added Successfully');
    //         }elseif ($request->action_type == 'download')
    //         {
    //             return back()->with('warning', 'Under Process');
    //             $product = Product::where('id', $request->product_id)->first();
    //             if($product){
    //                 $productCode = $product->sku;
    //                 $qrCodeImage = QrCode::format('png')->size(200)->generate($productCode);
    //                 return response($qrCodeImage)
    //                     ->header('Content-Type', 'image/png')
    //                     ->header('Content-Disposition', 'attachment; filename="product-' . $productCode . '.png"');
    //             }else{
    //                 return redirect()->back()->with('error', 'Product is required!');
    //             }
    //         }else {
    //             return redirect()->back()->with('error', 'Invalid action!');
    //         }  
    //     } else{
    //         return redirect()->back()->with('error', 'Product not found!');
    //     }
    // }

    public function store(Request $request)
    {
        if($request->product_id)
        {
            if ($request->quantity) {
                $quantity = $request->quantity;
            } else {
                $quantity = 1;
            }
            $qr_code = new QRCode();
            $qr_code->product_id = $request->product_id;
            if($request->watt_id)
            {
                $qr_code->watt_id = $request->watt_id ? $request->watt_id : '';
            }
            if($request->color_id)
            {
                $qr_code->color_id = $request->color_id ? $request->color_id : '';

            }
            if($request->temperature_id)
            {
                $qr_code->temperature_id = $request->temperature_id ? $request->temperature_id : '';

            }
            if($request->dimmable_type)
            {
                $qr_code->dimmable_type = $request->dimmable_type ? $request->dimmable_type : '';
            }
            if($request->size)
            {
                $qr_code->size = $request->size ? $request->size : '';

            }
            if($request->patch_type)
            {
                $qr_code->patch_type = $request->patch_type ? $request->patch_type : '';

            }
            if($request->channel_type)
            {
                $qr_code->channel_type = $request->channel_type ? $request->channel_type : '';

            }
            $qr_code->quantity = $quantity;
            $qr_code->save();
            
            return redirect()->route('qr-code.index')->with('message','QR Code added Successfully');  
        } else{
            return redirect()->back()->with('error', 'Product not found!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QRCode  $qRCode
     * @return \Illuminate\Http\Response
     */
    public function show(QRCode $qRCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QRCode  $qRCode
     * @return \Illuminate\Http\Response
     */
    public function edit(QRCode $qRCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QRCode  $qRCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QRCode $qRCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QRCode  $qRCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        QRCode::truncate();
        return back()->with('message','QR Code list clear Successfully');
    }
}
