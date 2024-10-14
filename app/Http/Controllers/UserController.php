<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Str;
use File;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::get();
        $head_users = User::where('role_id', 4)->get();
        $subhead_users = User::where('role_id', 5)->get();
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        $all_user = User::orderBy('id','desc')->paginate($perPage);
        $search = '';
        return view('backend.rbac.user.list', compact('all_user','search','startingSerial','roles','head_users','subhead_users'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(),[
            'email' => 'nullable|unique:users',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $requested_data = $request->all();
        $user = new User();
        $user->fill($requested_data);
        $user->password = Hash::make($request->m_password);
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/user/";
            $request->file('image')->move($path, $name);
            $requested_data['image'] = $path . $name;
        }
        $save = $user->save();

        if ($save) {
            return redirect()->route('user.index')->with('message', 'Employee Added Successfully');
        } else {
            return back()->with('error', 'Employee Addition Failed!!');
        }
    }

    public function search(Request $request)
    {
        $roles = Role::get();
        $head_users = User::where('role_id', 4)->get();
        $subhead_users = User::where('role_id', 5)->get();

        $search = $request->search;
        $headId = $request->input('head_id');
        $subheadId = $request->input('subhead_id');

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($search || $headId || $subheadId) {
            $all_user = User::when($headId, function ($query, $headId) use ($search, $subheadId) {
                $query->where('head_id', $headId)
                      ->when($subheadId, function ($query, $subheadId) use ($search) {
                          $query->where('subhead_id', $subheadId)
                                ->where(function ($query) use ($search) {
                                    $query->where('name', 'LIKE', '%' . $search . '%')
                                          ->orWhere('email', 'LIKE', '%' . $search . '%')
                                          ->orWhere('phone', 'LIKE', '%' . $search . '%');
                                });
                      }, function ($query) use ($search) {
                          $query->where(function ($query) use ($search) {
                              $query->where('name', 'LIKE', '%' . $search . '%')
                                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                                    ->orWhere('phone', 'LIKE', '%' . $search . '%');
                          });
                      });
            }, function ($query) use ($search, $subheadId) {
                $query->when($subheadId, function ($query, $subheadId) use ($search) {
                    $query->where('subhead_id', $subheadId)
                          ->where(function ($query) use ($search) {
                              $query->where('name', 'LIKE', '%' . $search . '%')
                                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                                    ->orWhere('phone', 'LIKE', '%' . $search . '%');
                          });
                }, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%')
                              ->orWhere('email', 'LIKE', '%' . $search . '%')
                              ->orWhere('phone', 'LIKE', '%' . $search . '%');
                    });
                });
            })->paginate($perPage);
        } else {
            $all_user = User::paginate(15);
        }
        
        return view('backend.rbac.user.list', compact('all_user','search','startingSerial','roles','head_users','subhead_users')); 
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 201);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $update = User::findOrFail($id);
        $formData = $request->all();
        if($request->m_password)
        {
            $update->password = Hash::make($request->m_password);
        }
        if ($request->hasFile('image')) {
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/user/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('user.index')->with('message','Employee Updated Successfully');
        }else{
            return back()->with('error','Employee Updated Failed');
        }
    }

    public function destroy($id)
    {
        $delete = User::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Employee Successfully Deleted');
    }
}
