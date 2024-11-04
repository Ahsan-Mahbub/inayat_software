<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequisition;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use File;
use Illuminate\Support\Facades\DB;

class ExpenseRequisitionController extends Controller
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
        $users = User::where('role_id', 12)->get();
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 11)
        {
            $all_expense = ExpenseRequisition::where('employee_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }else{
            $all_expense = ExpenseRequisition::orderBy('id','desc')->paginate($perPage);
        }
        
        $search_user = '';
        $search_subhead = '';
        $subhead = '';
        return view('backend.office-expense.expense-requisition.list', compact('all_expense','search_user','startingSerial','heads','search_head','users','search_subhead','subhead'));
    }

    public function search(Request $request)
    {
        $heads = Head::get();
        $users = User::where('role_id', 12)->get();
        $search_user = $request->user_id;
        $search_head = $request->head_id;
        $search_subhead = $request->subhead_id;
        $subhead = SubHead::where('id',$search_subhead)->first();

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if($request->head_id && $search_user && $search_subhead){
            $all_expense = ExpenseRequisition::where('head_id', $search_head)
                                    ->where('subhead_id', $search_subhead)
                                    ->where('accessor_id', $search_user)
                                    ->paginate($perPage);
        }elseif($request->head_id && $search_subhead){
            $all_expense = ExpenseRequisition::where('head_id', $search_head)
                                    ->where('subhead_id', $search_subhead)
                                    ->paginate($perPage);
        }if($request->head_id && $search_user){
            $all_expense = ExpenseRequisition::where('head_id', $search_head)
                                    ->where('accessor_id', $search_user)
                                    ->paginate($perPage);
        }elseif($request->head_id){
            $all_expense = ExpenseRequisition::where('head_id', $search_head)
                                    ->paginate($perPage);
        }elseif($search_user){
            $all_expense = ExpenseRequisition::where('accessor_id', $search_user)
                                    ->paginate($perPage);
        }
        else {
            $all_expense = expenseRequisition::paginate($perPage);;
        }

        return view('backend.office-expense.expense-requisition.list', compact('all_expense','search_user','startingSerial','heads','search_head','users','search_subhead','subhead')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heads = Head::get();
        $users = User::where('role_id', 12)->get();
        return view('backend.office-expense.expense-requisition.create', compact('heads','users'));
    }

    public function subHead($id)
    {   
        $subheads = SubHead::where('head_id', $id)->get();
        return response()->json($subheads, 200);
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

        $expense = new ExpenseRequisition();

        $last_requisition = ExpenseRequisition::orderBy('id','desc')->select('id')->first();
        $number = $last_requisition ? $last_requisition->id+1 : 1;
        $numberString = (string) $number;
        $length = strlen($numberString);
        $zerosToAdd = 4 - $length;
        $requisitionNumber = str_pad($numberString, $length + $zerosToAdd, '0', STR_PAD_LEFT); 

        $expense->requisition = 'OE-Requisition'.'-'.$requisitionNumber;
        $expense->amount = $request->request_amount;

        $user = User::where('role_id', 11)->first();
        $expense->employee_id = $user->id;
        $expense->accessor_id = $request->accessor_id;
        $save = $expense->fill($requested_data)->save();
        if($save)
        {
            return redirect()->route('expense.requisition.index')->with('message','Expense Requisition Added Successfully');
        }else{
            return back()->with('error', 'Something is Wrong!');
        }
    }

    public function adjustment($id)
    {
        $data['requisition'] = ExpenseRequisition::findOrFail($id);
        return view('backend.office-expense.expense-requisition.requisition-adjustment', $data);
    }

    public function updateAdjustment(Request $request, $id)
    {
        ExpenseRequisition::findOrFail($id)->update([
            'amount' => $request->amount,
            'status' => 1,
        ]);
        return back()->with('message', 'Expense Requisition Adjustment Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseRequisition  $expenseRequisition
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseRequisition $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseRequisition  $expenseRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = ExpenseRequisition::findOrFail($id);
        $heads = Head::get();
        $users = User::where('role_id', 12)->get();
        $subhead = SubHead::where('id', $expense->subhead_id)->first();
        return view('backend.office-expense.expense-requisition.edit', compact('expense','heads','users','subhead')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseRequisition  $expenseRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = ExpenseRequisition::findOrFail($id);
        $formData = $request->all();

        if($update->status == 1)
        {
            $update->amount = $update->amount;
        }else{
            $update->amount = $request->request_amount;
        }

        $updated = $update->fill($formData)->save();
        if($updated){
            return back()->with('message','Expense Requisition Updated Successfully');
        }else{
            return back()->with('error','Expense Requisition Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseRequisition  $expenseRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExpenseRequisition::where('id', $id)->firstOrFail()->delete();
        return back()->with('message', 'Expense Requisition Successfully Deleted');
    }

    public function approved($id)
    {
        $expense = ExpenseRequisition::where('id', $id)->first();
        $expense->update([
            'status' => 1
        ]);
        return back()->with('message', 'Expense Requisition Approved!');
    }

    public function employeeExpenseRequisitionHistory(Request $request, $id)
    {
        $perPage = 20;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        $employee = User::where('id', $id)->first();
        $expense_requisitions = ExpenseRequisition::where('employee_id', $id)->orderBy('date','desc')->paginate($perPage);
        return view('backend.office-expense.expense-requisition.employee-expense-requisition-history', compact('employee','expense_requisitions','startingSerial'));
    }
}
