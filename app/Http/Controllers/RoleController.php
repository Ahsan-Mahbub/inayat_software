<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class RoleController extends Controller
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

        $all_role = Role::orderBy('id','asc')->paginate($perPage);
        $search = '';
        return view('backend.rbac.role.list', compact('all_role','search','startingSerial'));
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
            'role_name' => 'nullable|unique:roles',
        ]);
        $requested_data = $request->all();

        $role = new Role();
        $save = $role->fill($requested_data)->save();
        if($save){
            return redirect()->route('role.index')->with('message','Role Added Successfully');
        }else{
            return back()->with('error','Role Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        $perPage = 15;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $all_role = Role::where('role_name', 'LIKE', '%' .$request->search . '%')->paginate($perPage);
        }
        else {
            $all_role = Role::paginate(15);
        }
        return view('backend.rbac.role.list', compact('all_role','search','startingSerial')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Role::findOrFail($id);
        $formData = $request->all();
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('role.index')->with('message','Role Updated Successfully');
        }else{
            return back()->with('error','Role Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Role::where('id', $id)->firstorfail()->delete();
        return back()->with('message','Role Successfully Deleted');
    }
}
