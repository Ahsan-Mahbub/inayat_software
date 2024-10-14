<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class CategoryController extends Controller
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

        $all_category = Category::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.file.category.list', compact('all_category','search','startingSerial'));
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
        $validator = Validator::make($request->all(),[
            'category_name' => 'nullable|unique:categories',
        ]);
        $requested_data = $request->all();

        if($request->ajax()){
            if($validator->passes()){
                Category::create([
                    'category_name' => $requested_data['category_name'],
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Category Created Successfully!',
                ]); 
            }
            else{
                return response()->json(['status'=>'error', 'errors'=>$validator->messages()]);
            }             
        }else{
            $category = new Category();
            $save = $category->fill($requested_data)->save();
            if($save){
                return redirect()->route('category.index')->with('message','Category Added Successfully');
            }else{
                return back()->with('error','Category Added Failed!!');
            }
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_category = Category::where('category_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_category = Category::paginate(15);
        }
        return view('backend.file.category.list', compact('all_category','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Category::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('category.index')->with('message','Category Updated Successfully');
        }else{
            return back()->with('error','Category Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Category::where('id', $id)->firstorfail()->delete();
        return back()->with('message','Category Successfully Deleted');
    }
}
