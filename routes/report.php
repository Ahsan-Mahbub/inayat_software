<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BudgetExpenseReportController;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'permission'], function(){
    Route::group(['prefix' => 'report'], function () {
        //Sale Purchase Report

        Route::get('/sale-requisition', [ReportController::class, 'saleRequisition'])->name('report.sale.requisition');
        Route::get('/sale-requisition-data', [ReportController::class, 'saleRequisitionData'])->name('report.sale.requisition.data');

        Route::get('/sale', [ReportController::class, 'sale'])->name('report.sale');
        Route::get('/sale-data', [ReportController::class, 'saleData'])->name('report.sale.data');

        Route::get('/purchase-requisition', [ReportController::class, 'purchaseRequisition'])->name('report.purchase.requisition');
        Route::get('/purchase-requisition-data', [ReportController::class, 'purchaseRequisitionData'])->name('report.purchase.requisition.data');

        Route::get('/purchase', [ReportController::class, 'purchase'])->name('report.purchase');
        Route::get('/purchase-data', [ReportController::class, 'purchaseData'])->name('report.purchase.data');

        Route::get('/all-employee', [ReportController::class, 'allEmployee'])->name('report.all-employee');
        Route::get('/all-employee-data', [ReportController::class, 'allEmployeeData'])->name('report.all-employee.data');

        //Budget Expense Report

        Route::get('/budget', [BudgetExpenseReportController::class, 'budget'])->name('report.budget');
        Route::get('/budget-data', [BudgetExpenseReportController::class, 'budgetData'])->name('report.budget.data');

        Route::get('/expense-requisition', [BudgetExpenseReportController::class, 'expenseRequisition'])->name('report.expense.requisition');
        Route::get('/expense-requisition-data', [BudgetExpenseReportController::class, 'expenseRequisitionData'])->name('report.expense.requisition.data');

        Route::get('/expense', [BudgetExpenseReportController::class, 'expense'])->name('report.expense');
        Route::get('/expense-data', [BudgetExpenseReportController::class, 'expenseData'])->name('report.expense.data');

        Route::get('/all-account-budget-expense', [BudgetExpenseReportController::class, 'allAccountBudgetExpense'])->name('report.all-account-budget-expense');
        Route::get('/all-account-budget-expense-data', [BudgetExpenseReportController::class, 'allAccountBudgetExpenseData'])->name('report.all-account-budget-expense.data');

        //Notification
        Route::get('/notification', [NotificationController::class, 'notification'])->name('notification');
    });
});
