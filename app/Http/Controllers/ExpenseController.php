<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\User;
use App\Models\ExpenseRequisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use File;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_head = '';
        $heads = Head::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12)
        {
            $all_expense = Expense::where('employee_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }else{
            $all_expense = Expense::orderBy('id','desc')->paginate($perPage);
        }
        
        $search_user = '';
        $search_subhead = '';
        $subhead = '';
        return view('backend.office-expense.expense.list', compact('all_expense','search_user','startingSerial','heads','search_head','users','search_subhead','subhead'));
    }

    public function search(Request $request)
    {
        $heads = Head::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        $search_user = $request->user_id;
        $search_head = $request->head_id;
        $search_subhead = $request->subhead_id;
        $subhead = SubHead::where('id',$search_subhead)->first();

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12)
        {
            if($request->head_id && $search_user && $search_subhead){
                $all_expense = Expense::where('employee_id', Auth::user()->id)->where('head_id', $search_head)
                                        ->where('subhead_id', $search_subhead)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->head_id && $search_subhead){
                $all_expense = Expense::where('employee_id', Auth::user()->id)->where('head_id', $search_head)
                                        ->where('subhead_id', $search_subhead)
                                        ->paginate($perPage);
            }if($request->head_id && $search_user){
                $all_expense = Expense::where('employee_id', Auth::user()->id)->where('head_id', $search_head)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->head_id){
                $all_expense = Expense::where('employee_id', Auth::user()->id)->where('head_id', $search_head)
                                        ->paginate($perPage);
            }elseif($search_user){
                $all_expense = Expense::where('employee_id', Auth::user()->id)->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }
            else {
                $all_expense = expense::where('employee_id', Auth::user()->id)->paginate($perPage);;
            }
        }else{
            if($request->head_id && $search_user && $search_subhead){
                $all_expense = Expense::where('head_id', $search_head)
                                        ->where('subhead_id', $search_subhead)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->head_id && $search_subhead){
                $all_expense = Expense::where('head_id', $search_head)
                                        ->where('subhead_id', $search_subhead)
                                        ->paginate($perPage);
            }if($request->head_id && $search_user){
                $all_expense = Expense::where('head_id', $search_head)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->head_id){
                $all_expense = Expense::where('head_id', $search_head)
                                        ->paginate($perPage);
            }elseif($search_user){
                $all_expense = Expense::where('employee_id', $search_user)
                                        ->paginate($perPage);
            }
            else {
                $all_expense = expense::paginate($perPage);;
            }
        }

        return view('backend.office-expense.expense.list', compact('all_expense','search_user','startingSerial','heads','search_head','users','search_subhead','subhead')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heads = Head::get();
        $subheads = SubHead::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        return view('backend.office-expense.expense.create', compact('heads','subheads','users'));
    }

    public function requisition($id)
    {   
        $expenses = Expense::where('employee_id', $id)->whereNotNull('requisition_id')->pluck('requisition_id');
        $requisitions = ExpenseRequisition::whereNotIn('id', $expenses)->where('accessor_id', $id)->where('status',1)->get();
        return response()->json($requisitions, 200);
    }

    public function getRequisitionDetails(Request $request)
    {
        $requisition = ExpenseRequisition::where('id', $request->requisition_id)->first();
        return response()->json($requisition);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requisition = ExpenseRequisition::findOrFail($request->requisition_id);

        $requested_data = $request->all();

        $expense = new Expense();
        $expense->head_id = $requisition->head_id ? $requisition->head_id : 0;
        $expense->subhead_id = $requisition->subhead_id ? $requisition->subhead_id : 0;
        if(!$request->employee_id)
        {
            $expense->employee_id = Auth::user()->id;
        }
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/expense/";
            $request->file('image')->move($path, $name);
            $requested_data['image'] = $path . $name;
        }
        $save = $expense->fill($requested_data)->save();
        if($save)
        {
            return back()->with('message','Expense Added Successfully');
        }else{
            return back()->with('error', 'Something is Wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $heads = Head::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        $subhead = SubHead::where('id', $expense->subhead_id)->first();
        return view('backend.office-expense.expense.edit', compact('expense','heads','users','subhead')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Expense::findOrFail($id);
        $formData = $request->all();
        if ($request->hasFile('image')) {
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "backend/assets/images/expense/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        $updated = $update->fill($formData)->save();
        if($updated){
            return back()->with('message','Expense Updated Successfully');
        }else{
            return back()->with('error','Expense Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Expense Successfully Deleted');
    }

    public function approved($id)
    {
        $expense = Expense::where('id', $id)->first();
        $expense->update([
            'status' => 1
        ]);
        return back()->with('message', 'Expense Approved!');
    }

    public function expenseHead()
    {
        $heads = Head::with('subheads')->get();
        return view('backend.office-expense.expense.head-expense', compact('heads'));
    }

    public function expenseSubHead(Request $request, $id)
    {
        $month = date('m');
        $year = date('Y');
        $subhead = SubHead::where('id', $id)->first();

        $perPage = 50;
        
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12)
        {
            $subhead_expense = Expense::where('subhead_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->where('employee_id', Auth::user()->id)->orderBy('date','desc')->paginate($perPage);
        }else{
            $subhead_expense = Expense::where('subhead_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->orderBy('date','desc')->paginate($perPage);
        }

        return view('backend.office-expense.expense.subhead-expense', compact('subhead','subhead_expense','startingSerial'));
    }

    public function employeeExpenseHistory(Request $request, $id)
    {
        $perPage = 20;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        $employee = User::where('id', $id)->first();
        $expenses = Expense::where('employee_id', $id)->orderBy('date','desc')->paginate($perPage);
        return view('backend.office-expense.expense.employee-expense-history', compact('employee','expenses','startingSerial'));
    }

}
