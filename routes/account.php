<?php

use Illuminate\Support\Facades\Route;

//Account
use App\Http\Controllers\MethodController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\SubHeadController;
use App\Http\Controllers\ExpenseRequisitionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BudgetController;
/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'permission'], function(){
    /*
    |--------------------------------------------------------------------------
    | Account Routes
    |--------------------------------------------------------------------------
    */
    //Method Route
    Route::group(['prefix' => 'method'], function () {
        Route::get('/list', [MethodController::class, 'index'])->name('method.index');
        Route::post('store', [MethodController::class, 'store'])->name('method.store');
        Route::get('edit/{id}', [MethodController::class, 'edit']);
        Route::post('update', [MethodController::class, 'update'])->name('method.update');
        Route::delete('destroy/{id}', [MethodController::class, 'destroy'])->name('method.destroy');
        Route::get('/search', [MethodController::class, 'search'])->name('method.search');
    });
    //Account Route
    Route::group(['prefix' => 'account'], function () {
        Route::get('/list', [AccountController::class, 'index'])->name('account.index');
        Route::post('store', [AccountController::class, 'store'])->name('account.store');
        Route::get('edit/{id}', [AccountController::class, 'edit']);
        Route::post('update', [AccountController::class, 'update'])->name('account.update');
        Route::delete('destroy/{id}', [AccountController::class, 'destroy'])->name('account.destroy');
        Route::get('/search', [AccountController::class, 'search'])->name('account.search');
    });
    //Head Route
    Route::group(['prefix' => 'head'], function () {
        Route::get('/list', [HeadController::class, 'index'])->name('head.index');
        Route::post('store', [HeadController::class, 'store'])->name('head.store');
        Route::get('edit/{id}', [HeadController::class, 'edit']);
        Route::post('update', [HeadController::class, 'update'])->name('head.update');
        Route::delete('destroy/{id}', [HeadController::class, 'destroy'])->name('head.destroy');
        Route::get('/search', [HeadController::class, 'search'])->name('head.search');
    });
    //SubHead Route
    Route::group(['prefix' => 'sub-head'], function () {
        Route::get('/list', [SubHeadController::class, 'index'])->name('sub-head.index');
        Route::post('store', [SubHeadController::class, 'store'])->name('sub-head.store');
        Route::get('edit/{id}', [SubHeadController::class, 'edit']);
        Route::post('update', [SubHeadController::class, 'update'])->name('sub-head.update');
        Route::delete('destroy/{id}', [SubHeadController::class, 'destroy'])->name('sub-head.destroy');
        Route::get('/search', [SubHeadController::class, 'search'])->name('sub-head.search');
    });

    //Expense Requisition Route
    Route::group(['prefix' => 'expense-requisition'], function () {
        Route::get('/list', [ExpenseRequisitionController::class, 'index'])->name('expense.requisition.index');
        Route::get('/create', [ExpenseRequisitionController::class, 'create'])->name('expense.requisition.create');
        Route::post('store', [ExpenseRequisitionController::class, 'store'])->name('expense.requisition.store');
        Route::get('edit/{id}', [ExpenseRequisitionController::class, 'edit'])->name('expense.requisition.edit');
        Route::post('update/{id}', [ExpenseRequisitionController::class, 'update'])->name('expense.requisition.update');
        Route::delete('destroy/{id}', [ExpenseRequisitionController::class, 'destroy'])->name('expense.requisition.destroy');
        Route::get('approved/{id}', [ExpenseRequisitionController::class, 'approved'])->name('expense.requisition.approved');
        Route::get('adjustment/{id}', [ExpenseRequisitionController::class, 'adjustment'])->name('expense.requisition.adjustment');
        Route::post('adjustment-update/{id}', [ExpenseRequisitionController::class, 'updateAdjustment'])->name('requisition.update.adjustment');
        Route::get('/search', [ExpenseRequisitionController::class, 'search'])->name('expense.requisition.search');
        Route::get('subhead/{id}', [ExpenseRequisitionController::class, 'subHead'])->name('expense.requisition.subhead');
        Route::get('employee-expense-requisition-history/{id}', [ExpenseRequisitionController::class, 'employeeExpenseRequisitionHistory'])->name('expense-requisition.employee.history');
    });

    //Expense Route
    Route::group(['prefix' => 'expense'], function () {
        Route::get('/list', [ExpenseController::class, 'index'])->name('expense.index');
        Route::get('/create', [ExpenseController::class, 'create'])->name('expense.create');
        Route::post('store', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::post('update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::delete('destroy/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
        Route::get('approved/{id}', [ExpenseController::class, 'approved'])->name('expense.approved');
        Route::get('/search', [ExpenseController::class, 'search'])->name('expense.search');
        Route::get('requisition/{id}', [ExpenseController::class, 'requisition'])->name('expense.requisition');
        Route::post('requisition-details', [ExpenseController::class, 'getRequisitionDetails'])->name('get-expense-requisition-details');
        Route::get('expense-head', [ExpenseController::class, 'expenseHead'])->name('expense.head');
        Route::get('expense-subhead-expense/{id}', [ExpenseController::class, 'expenseSubHead'])->name('expense.subhead-expense');
        Route::get('employee-expense-history/{id}', [ExpenseController::class, 'employeeExpenseHistory'])->name('expense.employee.history');
    });
    //Budget Route
    Route::group(['prefix' => 'budget'], function () {
        Route::get('/list', [BudgetController::class, 'index'])->name('budget.index');
        Route::get('/create', [BudgetController::class, 'create'])->name('budget.create');
        Route::post('store', [BudgetController::class, 'store'])->name('budget.store');
        Route::get('edit/{id}', [BudgetController::class, 'edit'])->name('budget.edit');
        Route::post('update/{id}', [BudgetController::class, 'update'])->name('budget.update');
        Route::delete('destroy/{id}', [BudgetController::class, 'destroy'])->name('budget.destroy');
        Route::get('/search', [BudgetController::class, 'search'])->name('budget.search');
        Route::get('subhead/{id}', [BudgetController::class, 'subHead'])->name('budget.subhead');
        Route::get('employee-budget', [BudgetController::class, 'employeeBudget'])->name('budget.employee');
        Route::get('employee-budget-history/{id}', [BudgetController::class, 'employeeBudgetHistory'])->name('budget.employee.history');
        Route::get('employee-monthly-history/{id}', [BudgetController::class, 'employeeMonthlyHistory'])->name('budget.employee.monthly');
    });
});
