<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\User;
use App\Models\SaleTransaction;
use Illuminate\Http\Request;
use File;
use Str;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendSMSJob;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get();
        $perPage = 50;
        $currentUserId = Auth::user()->id;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
            $userIds = User::where(function ($query) {
                $userId = Auth::user()->id;
                $query->where('head_id', $userId)
                    ->orWhere('subhead_id', $userId);
            })->pluck('id');

            $all_customer = Customer::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 11) {
            $all_customer = Customer::orderBy('id', 'desc')->paginate($perPage);
        }else {
            $all_customer = Customer::where('creator_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
        }

        
        $search = '';
        $get_user = '';

        return view('backend.sale.customer.list', compact('all_customer','search','startingSerial','users','get_user'));
    }

    public function dues(Request $request)
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

            $all_customer = Customer::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        }elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
            $all_customer = Customer::orderBy('id','desc')->paginate($perPage);
        }else{
            $all_customer = Customer::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }
        $search = '';
        return view('backend.sale.customer.dues', compact('all_customer','search','startingSerial'));
    }

    public function dueSearch(Request $request)
    {
        $search = $request->search;

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        
        if ($request->searchDataLength >= 0) {
            $currentUserId = Auth::user()->id;
            
            if (in_array(Auth::user()->role_id, [4, 5, 18])) {
                $userIds = User::where(function ($query) use ($currentUserId) {
                    $query->where('head_id', $currentUserId)
                        ->orWhere('subhead_id', $currentUserId);
                })->pluck('id');
        
                $all_customer = Customer::where(function ($query) use ($currentUserId, $userIds) {
                        $query->where('creator_id', $currentUserId)
                            ->orWhereIn('creator_id', $userIds);
                    })
                    ->where(function ($query) use ($request) {
                        $query->where('customer_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('customer_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate($perPage);
        
            } elseif (in_array(Auth::user()->role_id, [1, 11])) {
                $all_customer = Customer::where(function ($query) use ($request) {
                        $query->where('customer_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('customer_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate($perPage);
        
            } else {
                $all_customer = Customer::where('creator_id', $currentUserId)
                    ->where(function ($query) use ($request) {
                        $query->where('customer_name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('customer_id', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate($perPage);
            }
        
        } else {
            return back();
        }
        
        return view('backend.sale.customer.dues', compact('all_customer','search','startingSerial')); 
    }

    public function print(Request $request)
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

            $all_customer = Customer::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        }elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
            $all_customer = Customer::orderBy('id','desc')->paginate($perPage);
        }else{
            $all_customer = Customer::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }
        $search = '';
        return view('backend.sale.customer.print', compact('all_customer','search','startingSerial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $sales = Sale::where('customer_id', $id)->get();
        $returns = SaleReturn::where('customer_id', $id)->get();
        $transactions = SaleTransaction::where('customer_id', $id)->get();
        return view('backend.sale.customer.profile', compact('customer','transactions','returns','sales'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|unique:customers|digits:11|max:11',
            'email' => 'nullable|unique:customers',
        ]);
        
        $customer = new Customer();
        $requested_data = $request->all();
        $customer->creator_id = Auth::user()->id;
        $customer_update = Customer::orderBy('id','desc')->select('id')->first();

        if(!$customer_update){
            $customer_update = 1;
        }else{
            $customer_update = $customer_update->id+1;
        }

        $customer->customer_id = 'client-' . date('Y-m-d') . '-' . $customer_update;

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/customer/";
            $request->file('image')->move($path, $name);
            $requested_data['image'] = $path . $name;
        }
        $save = $customer->fill($requested_data)->save();
        if($save){
            return back()->with('message','Client Added Successfully');
        }else{
            return back()->with('error','Client Added Failed!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;
        $users = User::get();
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        $currentUserId = Auth::user()->id;
        $get_user = $request->user_id;
        $get_user = $request->user_id;

        if($get_user && $search){
            return back()->with('error','Select Creator or Type something!');
        }elseif ($get_user) {
            $find_user_role = User::where('id', $get_user)->select('role_id')->first();
            
            if ($find_user_role) {
                $role_id = $find_user_role->role_id;

                if (in_array($role_id, [4, 5, 18])) { 
                    $userIds = User::where(function ($query) use ($get_user) {
                        $query->where('head_id', $get_user)
                            ->orWhere('subhead_id', $get_user);
                    })->pluck('id');

                    $all_customer = Customer::where(function ($query) use ($get_user, $userIds) {
                        $query->where('creator_id', $get_user)
                            ->orWhereIn('creator_id', $userIds);
                    })
                    ->orderBy('id', 'desc')
                    ->paginate($perPage);

                } elseif (in_array($role_id, [1, 11])) {
                    $all_customer = Customer::orderBy('id', 'desc')->paginate($perPage);
                } else {
                    $all_customer = Customer::where('creator_id', $get_user)
                                            ->orderBy('id', 'desc')
                                            ->paginate($perPage);
                }
            }
        }else{
            if ($request->searchDataLength >= 0) {
                if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
                    $userIds = User::where(function ($query) {
                        $userId = Auth::user()->id;
                        $query->where('head_id', $userId)
                              ->orWhere('subhead_id', $userId);
                    })->pluck('id');
                
                    $all_customer = Customer::where(function ($query) use ($currentUserId, $userIds) {
                            $query->where('creator_id', $currentUserId)
                                  ->orWhereIn('creator_id', $userIds);
                        })
                        ->where(function ($query) use ($request) {
                            $query->where('customer_name', 'LIKE', '%' . $request->search . '%')
                                  ->orWhere('customer_id', 'LIKE', '%' . $request->search . '%')
                                  ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                                  ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                        })
                        ->orderBy('id', 'desc')
                        ->paginate($perPage);
                }elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 11){
                    $all_customer = Customer::where('customer_name', 'LIKE', '%' .$request->search . '%')
                        ->orWhere('customer_id', 'LIKE', '%' .$request->search . '%')
                        ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                        ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->orderBy('id', 'desc')->paginate($perPage);
                }else{
                    $all_customer = Customer::where('creator_id', Auth::user()->id)->where('customer_name', 'LIKE', '%' .$request->search . '%')
                        ->orWhere('customer_id', 'LIKE', '%' .$request->search . '%')
                        ->orWhere('email', 'LIKE', '%' .$request->search . '%')
                        ->orWhere('phone', 'LIKE', '%' .$request->search . '%')->orderBy('id', 'desc')->paginate($perPage);
                }
                
            }
            else {
                $all_customer = Customer::paginate(15);
            }
        }
        
        return view('backend.sale.customer.list', compact('all_customer','search','startingSerial', 'users', 'get_user')); 
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update = Customer::findOrFail($id);
        $formData = $request->all();

        if ($request->hasFile('image')) {
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/customer/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        $updated = $update->fill($formData)->save();
        if($updated){
            return redirect()->route('customer.index')->with('message','Client Updated Successfully');
        }else{
            return back()->with('error','Client Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Customer::where('id', $id)->firstOrFail()->delete();
        return back()->with('message','Client Successfully Deleted');
    }

    public function message()
    {
        
        $currentUserId = Auth::user()->id;

        if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 18) {
            $userIds = User::where(function ($query) {
                $userId = Auth::user()->id;
                $query->where('head_id', $userId)
                    ->orWhere('subhead_id', $userId);
            })->pluck('id');

            $all_customer = Customer::where(function ($query) use ($currentUserId, $userIds) {
                $query->where('creator_id', $currentUserId)
                    ->orWhereIn('creator_id', $userIds);
            })->whereRaw('LENGTH(phone) = 11')->get();
        }if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
        {
            $customers = Customer::whereRaw('LENGTH(phone) = 11')->get();
        }else{
            $customers = Customer::where('creator_id', Auth::user()->id)->whereRaw('LENGTH(phone) = 11')->get();
        }
        return view('backend.sale.customer.message', compact('customers'));
    }

    #Batch System Message Send
    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'customer_phone' => 'required|array',
    //         'message' => 'required|string',
    //     ]);

    //     $customers = $request->customer_phone;
    //     $messageContent = $request->message;

    //     $batchSize = 50;
    //     $batchedCustomers = array_chunk($customers, $batchSize);

    //     foreach ($batchedCustomers as $batch) {

    //         $numbers = implode(',', array_map(fn($phone) => "88" . $phone, $batch));
    //         dd($numbers);
    //         $message_url = "https://sms.rapidsms.xyz/request.php?user_id=200501&password=11111111&number=" . $numbers . "&message=" . urlencode($messageContent);
    //         $curl = curl_init();
    //         curl_setopt($curl, CURLOPT_URL, $message_url);
    //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //         curl_setopt($curl, CURLOPT_HEADER, 0);
    //         $resultdata = curl_exec ($curl);
    //         curl_close ($curl);
    //         $resultArray=json_decode($resultdata, true);
    //     }

    //     return back()->with('message', 'Messages sent successfully to selected clients.');
    // }

    #Queue System Message Send
    public function sendMessage(Request $request)
    {
        $request->validate([
            'customer_phone' => 'required|array',
            'message' => 'required|string',
        ]);

        $customers = $request->customer_phone;
        $messageContent = $request->message;

        foreach ($customers as $phone) {
            SendSMSJob::dispatch($phone, $messageContent);
        }

        return back()->with('message', 'Messages are being sent to selected clients.');
    }

}
