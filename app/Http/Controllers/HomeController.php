<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.layouts.dashboard');
    }

    public function profile()
    {
        return view('backend.layouts.profile');
    }

    public function store(Request $request){
        
       if ($request->password) {
            $data = [
                'name'   => $request->name,
                'email'  => $request->email,
                'password'=> Hash::make($request->password),
            ];
        } else {
            $data = [
                'name'   => $request->name,
                'email'  => $request->email,
                'password' => Auth::user()->password,
            ];
        }
        
        User::where('id', Auth::user()->id)->update($data);
        return back()->with('message','Profile Update Successfully');
    }
}
