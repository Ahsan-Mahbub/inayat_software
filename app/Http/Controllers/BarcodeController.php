<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Watt;
use App\Models\Color;
use App\Models\Temperature;
use Illuminate\Support\Facades\View;
use Milon\Barcode\DNS1D;
use ZipArchive;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $all_barcode = Barcode::orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->get();    
        $watts = Watt::get();   
        $colors = Color::get();  
        $temperatures = Temperature::get();    
        return view('backend.file.barcode.list', compact('all_barcode', 'products', 'watts','colors','temperatures'));
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
        if ($request->quantity)
        {
            $quantity = $request->quantity;
        } else
        {
            $quantity = 1;
        }

        if ($request->action_type == 'save')
        {
            $barcode = new Barcode();
            $barcode->product_id = $request->product_id;
            if($request->watt_id)
            {
                $barcode->watt_id = $request->watt_id ? $request->watt_id : '';
            }
            if($request->color_id)
            {
                $barcode->color_id = $request->color_id ? $request->color_id : '';

            }
            if($request->temperature_id)
            {
                $barcode->temperature_id = $request->temperature_id ? $request->temperature_id : '';

            }
            if($request->dimmable_type)
            {
                $barcode->dimmable_type = $request->dimmable_type ? $request->dimmable_type : '';
            }
            if($request->size)
            {
                $barcode->size = $request->size ? $request->size : '';

            }
            if($request->patch_type)
            {
                $barcode->patch_type = $request->patch_type ? $request->patch_type : '';

            }
            if($request->channel_type)
            {
                $barcode->channel_type = $request->channel_type ? $request->channel_type : '';

            }
            $barcode->quantity = $quantity;
            $barcode->save();
            return redirect()->route('barcode.index')->with('message','Barcode added Successfully');

        }elseif ($request->action_type == 'download')
        {    
            $product = Product::where('id', $request->product_id)->first();
            if($product){
                $watt = Watt::where('id', $request->watt_id)->first();
                $color = Color::where('id', $request->color_id)->first();
                $temperature = Temperature::where('id', $request->temperature_id)->first();
                $barcodes = [];
                $dns1d = new DNS1D();
                for ($i = 1; $i <= $quantity; $i++) {
                    $barcodeData = $dns1d->getBarcodePNG($product->sku . $i, 'C39');
                    #add some html watt name, color name, temperature name
                    $fileName = 'barcode_' . $i . '.png';
                    $path = public_path($fileName);
                    file_put_contents($path, base64_decode($barcodeData));
                    $barcodes[] = $path;
                }
                $zipFileName = 'barcodes.zip';
                $zipFilePath = public_path($zipFileName);

                $zip = new ZipArchive;
                if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                    foreach ($barcodes as $barcode) {
                        $zip->addFile($barcode, basename($barcode));
                    }
                    $zip->close();
                }
                foreach ($barcodes as $barcode) {
                    @unlink($barcode);
                }
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            }else{
                return redirect()->back()->with('error', 'Product is required!');
            }
            
        } else {
            return redirect()->back()->with('error', 'Invalid action!');
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function show(Barcode $barcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Barcode $barcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barcode $barcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Barcode::truncate();
        return back()->with('message','Barcode list clear Successfully');
    }
}
