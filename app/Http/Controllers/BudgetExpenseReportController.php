<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Budget;
use App\Models\Head;
use App\Models\Expense;
use App\Models\SubHead;

class BudgetExpenseReportController extends Controller
{
    public function budget()
    {
        $users = User::whereIn('role_id', [11, 12])->get();
        return view('backend.report.budget.index', compact('users'));
    }

    public function budgetData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $employee_id = $request->employee_id;

        $all_budget = Budget::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($employee_id, function ($query, $employee_id) {
                return $query->where('employee_id', $employee_id);
            })
            ->get();
        return view('backend.report.budget.list', compact('user','all_budget','form_date', 'to_date','employee_id'));
    }

    public function expense()
    {
        $users = User::whereIn('role_id', [11, 12])->get();
        $heads = Head::get();
        return view('backend.report.expense.index', compact('users','heads'));
    }

    public function expenseData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();
        $head = Head::where('id', $request->head_id)->first();
        $subhead = SubHead::where('id', $request->subhead_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $employee_id = $request->employee_id;
        $head_id = $request->head_id;
        $subhead_id = $request->subhead_id;

        $all_expense = Expense::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($employee_id, function ($query, $employee_id) {
                return $query->where('employee_id', $employee_id);
            })
            ->when($head_id, function ($query, $head_id) {
                return $query->where('head_id', $head_id);
            })
            ->when($subhead_id, function ($query, $subhead_id) {
                return $query->where('subhead_id', $subhead_id);
            })
            ->get();
        return view('backend.report.expense.list', compact('user','all_expense','form_date', 'to_date','employee_id','head_id','subhead_id','head','subhead'));
    }

    public function allAccountBudgetExpense()
    {
        $users = User::whereIn('role_id', [11, 12])->get();
        return view('backend.report.account.index', compact('users'));
    }

    public function allAccountBudgetExpenseData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $employee_id = $request->employee_id;

        $all_budget = Budget::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($employee_id, function ($query, $employee_id) {
                return $query->where('employee_id', $employee_id);
            })
            ->get();

        $all_expense = Expense::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($employee_id, function ($query, $employee_id) {
                return $query->where('employee_id', $employee_id);
            })
            ->get();
        return view('backend.report.account.list', compact('user','form_date', 'to_date','employee_id','all_expense','all_budget'));
    }
}
