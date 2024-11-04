<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\Method;
use App\Models\Account;
use App\Models\User;
use App\Models\ExpenseRequisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_method = '';
        $methods = Method::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12)
        {
            $all_budget = Budget::where('employee_id', Auth::user()->id)->orderBy('id','desc')->paginate($perPage);
        }else{
            $all_budget = Budget::orderBy('id','desc')->paginate($perPage);
        }
        
        $search_user = '';
        $search_account = '';
        $account = '';
        return view('backend.office-expense.budget.list', compact('all_budget','search_user','startingSerial','methods','search_method','users','search_account','account'));
    }

    public function search(Request $request)
    {
        $methods = Method::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        $search_user = $request->user_id;
        $search_method = $request->method_id;
        $search_account = $request->account_id;
        $account = Account::where('id',$search_account)->first();

        $perPage = 50;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;

        if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12)
        {
            if($request->method_id && $search_user && $search_account){
                $all_budget = Budget::where('employee_id', Auth::user()->id)->where('method_id', $search_method)
                                        ->where('account_id', $search_account)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->method_id && $search_account){
                $all_budget = Budget::where('employee_id', Auth::user()->id)->where('method_id', $search_method)
                                        ->where('account_id', $search_account)
                                        ->paginate($perPage);
            }if($request->method_id && $search_user){
                $all_budget = Budget::where('employee_id', Auth::user()->id)->where('method_id', $search_method)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->method_id){
                $all_budget = Budget::where('employee_id', Auth::user()->id)->where('method_id', $search_method)
                                        ->paginate($perPage);
            }elseif($search_user){
                $all_budget = Budget::where('employee_id', Auth::user()->id)->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }
            else {
                $all_budget = Budget::where('employee_id', Auth::user()->id)->paginate($perPage);;
            }
        }else{
            if($request->method_id && $search_user && $search_account){
                $all_budget = Budget::where('method_id', $search_method)
                                        ->where('account_id', $search_account)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->method_id && $search_account){
                $all_budget = Budget::where('method_id', $search_method)
                                        ->where('account_id', $search_account)
                                        ->paginate($perPage);
            }if($request->method_id && $search_user){
                $all_budget = Budget::where('method_id', $search_method)
                                        ->where('employee_id', $search_user)
                                        ->paginate($perPage);
            }elseif($request->method_id){
                $all_budget = Budget::where('method_id', $search_method)
                                        ->paginate($perPage);
            }elseif($search_user){
                $all_budget = Budget::where('employee_id', $search_user)
                                        ->paginate($perPage);
            }
            else {
                $all_budget = Budget::paginate($perPage);;
            }
        }

        return view('backend.office-expense.budget.list', compact('all_budget','search_user','startingSerial','methods','search_method','users','search_account','account')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $methods = Method::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        return view('backend.office-expense.budget.create', compact('methods','users'));
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

        $budget = new Budget();
        if(!$request->employee_id)
        {
            $budget->employee_id = Auth::user()->id;
        }

        $account = Account::where('id',$request->account_id)->first();
        $data = [
            'current_amount'   => $account->current_amount - $request->amount,
            'total_amount'   => $account->total_amount - $request->amount,
        ];
        Account::where('id', $account->id)->update($data);

        $save = $budget->fill($requested_data)->save();

        if($save)
        {
            return back()->with('message','Budget Added Successfully');
        }else{
            return back()->with('error', 'Something is Wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $methods = Method::get();
        $users = User::whereIn('role_id', [11, 12])->get();
        $account = Account::where('id', $budget->account_id)->first();
        return view('backend.office-expense.budget.edit', compact('budget','methods','users','account')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);
        $formData = $request->all();

        $account = Account::where('id', $budget->account_id)->first();
        if (!$account) {
            return back()->with('error', 'Associated account not found.');
        }
        $account->update([
            'current_amount' => $account->current_amount + $budget->amount,
            'total_amount' => $account->total_amount + $budget->amount,
        ]);
        $updated = $budget->fill($formData)->save();

        $new_account = Account::where('id', $request->account_id)->first();
        $new_account->update([
            'current_amount' => $account->current_amount - $request->amount,
            'total_amount' => $account->total_amount - $request->amount,
        ]);

        if($updated){
            return back()->with('message','Budget Updated Successfully');
        }else{
            return back()->with('error','Budget Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $budget = Budget::where('id', $id)->first();
            if (!$budget) {
                return back()->with('error', 'budget not found.');
            }

            $account = Account::where('id', $budget->account_id)->first();
            if (!$account) {
                return back()->with('error', 'Associated account not found.');
            }
            $account->update([
                'current_amount' => $account->current_amount + $budget->amount,
                'total_amount' => $account->total_amount + $budget->amount,
            ]);
            $budget->delete();

            DB::commit();

            return back()->with('message', 'Budget Successfully Deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete budget: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while deleting the budget.');
        }
    }

    public function employeeBudget()
    {
        $employees = User::whereIn('role_id', [11, 12])->get();
        return view('backend.office-expense.budget.employee-budget', compact('employees'));
    }

    public function employeeBudgetHistory(Request $request, $id)
    {
        $perPage = 20;
        $page = $request->query('page', 1);
        $startingSerial = ($page - 1) * $perPage + 1;
        $employee = User::where('id', $id)->first();
        $budgets = Budget::where('employee_id', $id)->orderBy('date','desc')->paginate($perPage);
        return view('backend.office-expense.budget.employee-budget-history', compact('employee','budgets','startingSerial'));
    }

    public function employeeMonthlyHistory($id)
    {
        $month = date('m');
        $year = date('Y');

        $employee = User::findOrFail($id);

        $budgets = Budget::where('employee_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->orderBy('date','desc')->get();
        $expenses = Expense::where('employee_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->where('status',1)->orderBy('date','desc')->get();
        $expense_requisitions = ExpenseRequisition::where('employee_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->where('status',1)->orderBy('date','desc')->get();


        $pre_total_budget = Budget::where('employee_id', $id)
            ->whereNotIn('id', $budgets->pluck('id')->toArray())
            ->sum('amount');
        $pre_total_expense = Expense::where('employee_id', $id)
            ->whereNotIn('id', $expenses->pluck('id')->toArray())
            ->where('status',1)
            ->sum('amount');    
        $pre_total_expense_requisition = ExpenseRequisition::where('employee_id', $id)
            ->whereNotIn('id', $expense_requisitions->pluck('id')->toArray())
            ->where('status',1)
            ->sum('amount');   
        $previous_amount = $pre_total_budget + $pre_total_expense_requisition - $pre_total_expense;

        return view('backend.office-expense.budget.employee-budget-monthly', compact('employee','budgets','expenses','expense_requisitions','previous_amount'));
    }

}
