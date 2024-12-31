<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Budget;
use App\Models\Head;
use App\Models\Expense;
use App\Models\SubHead;
use App\Models\ExpenseRequisition;

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
            ->orderBy('date','desc')->get();
        return view('backend.report.budget.list', compact('user','all_budget','form_date', 'to_date','employee_id'));
    }

    public function expenseRequisition()
    {
        $heads = Head::get();
        return view('backend.report.expense-requisition.index', compact('heads'));
    }

    public function expenseRequisitionData(Request $request)
    {
        $head = Head::where('id', $request->head_id)->first();
        $subhead = SubHead::where('id', $request->subhead_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $head_id = $request->head_id;
        $subhead_id = $request->subhead_id;
        $status = $request->status;

        $query = ExpenseRequisition::query();
        if ($form_date) {
            $query->whereDate('date', '>=', $form_date);
        }

        if ($to_date) {
            $query->whereDate('date', '<=', $to_date);
        }

        if ($head_id) {
            $query->where('head_id', $head_id);
        }

        if ($subhead_id) {
            $query->where('subhead_id', $subhead_id);
        }

        if (isset($status)) {
            $status = (int)$status;
            if ($status === 0) {
                $query->where('status', 0);
            } elseif ($status === 1) {
                $query->where('status', 1);
            }
        }
        $all_expense = $query->orderBy('date','desc')->get();
        return view('backend.report.expense-requisition.list', compact('all_expense','form_date', 'to_date','head_id','subhead_id','head','subhead'));
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
        $status = $request->status;

        $query = Expense::query();
        if ($form_date) {
            $query->whereDate('date', '>=', $form_date);
        }

        if ($to_date) {
            $query->whereDate('date', '<=', $to_date);
        }

        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }

        if ($head_id) {
            $query->where('head_id', $head_id);
        }

        if ($subhead_id) {
            $query->where('subhead_id', $subhead_id);
        }

        if (isset($status)) {
            $status = (int)$status;
            if ($status === 0) {
                $query->where('status', 0);
            } elseif ($status === 1) {
                $query->where('status', 1);
            }
        }
        $all_expense = $query->orderBy('date','desc')->get();
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
            ->orderBy('date','desc')->get();

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
            ->where('status', 1)->orderBy('date','desc')->get();
        
        $all_expense_requisition = ExpenseRequisition::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($employee_id, function ($query, $employee_id) {
                return $query->where('employee_id', $employee_id);
            })
            ->where('status', 1)->orderBy('date','desc')->get();
        return view('backend.report.account.list', compact('user','form_date', 'to_date','employee_id','all_expense','all_budget','all_expense_requisition'));
    }
}
