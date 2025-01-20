<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use File;
use Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_category = '';
        $categories = Category::get();
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        $all_product = Product::orderBy('product_name','asc')->paginate($perPage);
        $search = '';
        return view('backend.file.product.list', compact('all_product','search','startingSerial','categories','search_category'));
    }

    public function search(Request $request)
    {
        $categories = Category::get();
        $search = $request->search;
        $search_category = $request->category_id;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if ($request->search && $request->category_id) {
            $all_product = Product::where('product_name', 'LIKE', '%' .$request->search . '%')
                                    ->where('category_id', $search_category)
                                    ->orderBy('product_name','asc')
                                    ->paginate($perPage);
        }elseif($request->search){
            $all_product = Product::where('product_name', 'LIKE', '%' .$request->search . '%')
                                    ->orderBy('product_name','asc')
                                    ->paginate($perPage);
        }elseif($request->category_id){
            $all_product = Product::where('category_id', $search_category)
                                    ->orderBy('product_name','asc')
                                    ->paginate($perPage);
        }
        else {
            $all_product = Product::orderBy('product_name','asc')->paginate($perPage);;
        }

        return view('backend.file.product.list', compact('all_product','search','startingSerial','categories','search_category')); 
    }

    public function productListPrint ()
    {
        $all_product = Product::orderBy('id','desc')->paginate(100);
        $categories = Category::get();
        $search_category = "";
        $search = "";
        return view('backend.file.product.list-print', compact('all_product','categories','search','search_category'));
    }

    public function printSearch(Request $request)
    {

        $categories = Category::get();
        $search = $request->search;
        $search_category = $request->category_id;
        
        if ($request->search && $request->category_id) {
            $all_product = Product::where('product_name', 'LIKE', '%' .$request->search . '%')
                                    ->where('category_id', $search_category)
                                    ->get();
        }elseif($request->search){
            $all_product = Product::where('product_name', 'LIKE', '%' .$request->search . '%')
                                    ->get();
        }elseif($request->category_id){
            $all_product = Product::where('category_id', $search_category)
                                    ->get();
        }
        else {
            $all_product = Product::get();
        }
        return view('backend.file.product.list-print', compact('all_product','categories','search','search_category'));
    }

    public function exportProduct ()
    {
        $categories = Category::get();
        $search_category = "";
        $search = "";
        return view('backend.file.product.export', compact('categories','search','search_category'));
    }

    public function exportProductList(Request $request)
    {
        $search_category = $request->category_id;
        
        if ($request->search && $request->category_id) {
            $data = Product::where('product_name', 'LIKE', '%' .$request->search . '%')
                                    ->where('category_id', $search_category)
                                    ->get();
        }elseif($request->search){
            $data = Product::where('product_name', 'LIKE', '%' .$request->search . '%')
                                    ->get();
        }elseif($request->category_id){
            $data = Product::where('category_id', $search_category)
                                    ->get();
        }
        else {
            $data = Product::get();
        }

        if ($data->isNotEmpty()) {
            return Excel::download(new ExportProduct($data), 'product.xlsx');
        } else {
            return back()->with('error', 'No data found!.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.file.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $requested_data = $request->all();

        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'category_id' => 'required',
                'sku' => 'required',
            ]);
            if($validator->passes()){
                $product = new Product();
                $product->product_name  = $request->sku;
                $save = $product->fill($requested_data)->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product Created Successfully!',
                ]); 
            }
            else{
                return response()->json(['status'=>'error', 'errors'=>$validator->messages()]);
            }  

        }else{
            $product = new Product();
            $product->product_name  = $request->sku;
            if ($request->hasFile('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $name = 'image' . Str::random(5) . '.' . $extension;
                $path = "backend/assets/images/product/";
                $request->file('image')->move($path, $name);
                $requested_data['image'] = $path . $name;
            }
            if ($request->hasFile('qr_code')) {
                $extension = $request->file('qr_code')->getClientOriginalExtension();
                $name = 'qr_code' . Str::random(5) . '.' . $extension;
                $path = "backend/assets/qr-code/product/";
                $request->file('qr_code')->move($path, $name);
                $requested_data['qr_code'] = $path . $name;
            }
            $save = $product->fill($requested_data)->save();
            if($save){
                return redirect()->route('product.index')->with('message','Product Added Successfully');
            }else{
                return back()->with('error','product Added Failed!!');
            }

        }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get();
        session()->put('redirect_url', url()->previous());
        return view('backend.file.product.edit', compact('product','categories')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Product::findOrFail($id);
        $formData = $request->all();
        $update->product_name = $request->sku;
        if ($request->hasFile('image')) {
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/product/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        if ($request->hasFile('qr_code')) {
            if (File::exists($update->qr_code)) {
                File::delete($update->qr_code);
            }
            $extension = $request->file('qr_code')->getClientOriginalExtension();
            $name = 'qr_code' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/qr-code/product/";
            $request->file('qr_code')->move($path, $name);
            $formData['qr_code'] = $path . $name;
        }
        $updated = $update->fill($formData)->save();

        if ($updated) {
            $redirectUrl = session()->get('redirect_url', route('product.index'));
            return redirect($redirectUrl)->with('message', 'Product Updated Successfully');
        } else {
            return back()->with('error', 'Product Update Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Product::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Product Successfully Deleted');
    }
}
