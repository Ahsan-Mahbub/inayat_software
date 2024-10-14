<?php

use Illuminate\Support\Facades\Route;

//Purchase
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseTransactionController;
use App\Http\Controllers\PurchaseReturnController;
//Purchase Requisition
use App\Http\Controllers\RequisitionController;
//Sale
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleTransactionController;
use App\Http\Controllers\SaleReturnController;
//Sale Requisition
use App\Http\Controllers\SaleRequisitionController;
//Inventory
use App\Http\Controllers\InventoryController;


/*
|--------------------------------------------------------------------------
| Inventory Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'permission'], function(){

    /*
    |--------------------------------------------------------------------------
    | Purchase Routes
    |--------------------------------------------------------------------------
    */

    //Supplier Route
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/list', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('edit/{id}', [SupplierController::class, 'edit']);
        Route::post('update', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('/search', [SupplierController::class, 'search'])->name('supplier.search');
        Route::get('/profile/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    });
    //Purchase Requisition Route
    Route::prefix('requisition')->group(function () {
        Route::get('list', [RequisitionController::class, 'index'])->name('requisition.index');
        Route::get('create', [RequisitionController::class, 'create'])->name('requisition.create');
        Route::post('store', [RequisitionController::class, 'store'])->name('requisition.store');
        Route::get('edit/{id}', [RequisitionController::class, 'edit'])->name('requisition.edit');
        Route::post('update/{id}', [RequisitionController::class, 'update'])->name('requisition.update');
        Route::delete('destroy/{id}', [RequisitionController::class, 'destroy'])->name('requisition.destroy');
        Route::get('/search', [RequisitionController::class, 'search'])->name('requisition.search');

        Route::get('invoice/{id}', [RequisitionController::class, 'show'])->name('requisition.show');
        Route::get('active/{id}', [RequisitionController::class, 'requisitionActive'])->name('requisition.active');
        Route::get('deactive/{id}', [RequisitionController::class, 'requisitionDeActive'])->name('requisition.deactive');

        Route::get('/requisition-search-product', [RequisitionController::class, 'getSearchProduct'])->name('requisition.search.product');
        Route::post('/get-product-details', [RequisitionController::class, 'getProductDetails']);

        Route::post('get-requisition', [RequisitionController::class, 'getRequisitionId'])->name('get-requisition');
        Route::get('info/{id}', [RequisitionController::class, 'getData']);

        Route::get('/product-details', [RequisitionController::class, 'getProduct'])->name('requisition.get.product');
    });
    //Purchase Route
    Route::group(['prefix' => 'purchase'], function () {
        Route::get('/list', [PurchaseController::class, 'index'])->name('purchase.index');
        Route::get('create', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::get('requisition', [PurchaseController::class, 'createRequisition'])->name('purchase.requisition');
        Route::post('store', [PurchaseController::class, 'store'])->name('purchase.store');
        Route::get('edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
        Route::post('update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
        Route::delete('destroy/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
        Route::get('invoice/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
        Route::get('/search', [PurchaseController::class, 'search'])->name('purchase.search');
        Route::get('/purchase-search-product', [PurchaseController::class, 'getSearchProduct'])->name('purchase.search.product');
        Route::post('/get-product-details', [PurchaseController::class, 'getProductDetails'])->name('get-product-details');
        Route::get('/get-qty', [PurchaseController::class, 'getQty'])->name('purchase.qty');
        Route::get('/get-product-qty', [PurchaseController::class, 'getProductQty'])->name('purchase.product.qty');
        Route::post('get-qty-update/{id}', [PurchaseController::class, 'updateProductQty'])->name('purchase.product.qty.update');
    });
    //Purchase Return
    Route::group(['prefix' => 'purchase-return'], function () {
        Route::get('/list', [PurchaseReturnController::class, 'index'])->name('purchase.return.index');
        Route::get('create', [PurchaseReturnController::class, 'create'])->name('purchase.return.create');
        Route::post('store', [PurchaseReturnController::class, 'store'])->name('purchase.return.store');
        Route::get('/invoice/{id}', [PurchaseReturnController::class, 'getInvoice']);
        Route::get('purchase-return-invoice', [PurchaseReturnController::class, 'purchaseReturnInvoice'])->name('purchase.return.invoice');
        Route::get('/purchase-product', [PurchaseReturnController::class, 'getPurchaseProduct'])->name('purchase.return.get.product');
    });
    //Purchase Transaction
    Route::group(['prefix' => 'supplier-transaction'], function () {
        Route::get('/{id}', [PurchaseTransactionController::class, 'index'])->name('supplier.transaction');
        Route::post('store', [PurchaseTransactionController::class, 'store'])->name('supplier.transaction.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Sales Routes
    |--------------------------------------------------------------------------
    */

    //Customer Route
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/dues', [CustomerController::class, 'dues'])->name('customer.dues');
        Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('edit/{id}', [CustomerController::class, 'edit']);
        Route::post('update', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::get('/search', [CustomerController::class, 'search'])->name('customer.search');
        Route::get('/profile/{id}', [CustomerController::class, 'show'])->name('customer.show');
    });
    Route::group(['prefix' => 'receivable'], function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('receivable.index');
        Route::get('/dues', [CustomerController::class, 'dues'])->name('receivable.dues');
        Route::get('/search', [CustomerController::class, 'dueSearch'])->name('customer.due-search');
    });
    //Requisition Route
    Route::prefix('sale-requisition')->group(function () {
        Route::get('list', [SaleRequisitionController::class, 'index'])->name('sale.requisition.index');
        Route::get('create', [SaleRequisitionController::class, 'create'])->name('sale.requisition.create');
        Route::post('store', [SaleRequisitionController::class, 'store'])->name('sale.requisition.store');
        Route::get('edit/{id}', [SaleRequisitionController::class, 'edit'])->name('sale.requisition.edit');
        Route::post('update/{id}', [SaleRequisitionController::class, 'update'])->name('sale.requisition.update');
        Route::delete('destroy/{id}', [SaleRequisitionController::class, 'destroy'])->name('sale.requisition.destroy');
        Route::get('/search', [SaleRequisitionController::class, 'search'])->name('sale.requisition.search');

        Route::get('invoice/{id}', [SaleRequisitionController::class, 'show'])->name('sale.requisition.show');
        Route::get('active/{id}', [SaleRequisitionController::class, 'requisitionActive'])->name('sale.requisition.active');
        Route::get('deactive/{id}', [SaleRequisitionController::class, 'requisitionDeActive'])->name('sale.requisition.deactive');

        Route::get('/sale-requisition-search-product', [SaleRequisitionController::class, 'getSearchProduct'])->name('sale.requisition-search');
        Route::post('/get-product-details', [SaleRequisitionController::class, 'getProductDetails'])->name('sale-requisition-get-product-details');;

        Route::post('get-requisition', [SaleRequisitionController::class, 'getRequisitionId'])->name('sale.get-requisition');
        Route::get('info/{id}', [SaleRequisitionController::class, 'getData']);

        Route::get('/product-details', [SaleRequisitionController::class, 'getSaleProduct'])->name('sale.requisition.get.product');
    });
    //Sale Route
    Route::group(['prefix' => 'sale'], function () {
        Route::get('/list', [SaleController::class, 'index'])->name('sale.index');
        Route::get('create', [SaleController::class, 'create'])->name('sale.create');
        Route::get('requisition', [SaleController::class, 'createRequisition'])->name('sale.requisition');
        Route::post('store', [SaleController::class, 'store'])->name('sale.store');
        Route::get('invoice/{id}', [SaleController::class, 'show'])->name('sale.show');
        Route::get('challan/{id}', [SaleController::class, 'challan'])->name('sale.challan');
        Route::get('/search', [SaleController::class, 'search'])->name('sale.search');
        Route::get('/sale-search-product', [SaleController::class, 'getSearchProduct']);
        Route::post('/sale-get-product-details', [SaleController::class, 'getProductDetails'])->name('sale-get-product-details');
        Route::get('/product-details', [SaleController::class, 'getSaleProduct'])->name('sale.get.product');
        Route::get('schedule/{id}', [SaleController::class, 'schedule'])->name('sale.schedule');
        Route::delete('destroy/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');
    });
    //Sale Return
    Route::group(['prefix' => 'sale-return'], function () {
        Route::get('/list', [SaleReturnController::class, 'index'])->name('sale.return.index');
        Route::get('create', [SaleReturnController::class, 'create'])->name('sale.return.create');
        Route::post('store', [SaleReturnController::class, 'store'])->name('sale.return.store');
        Route::get('/invoice/{id}', [SaleReturnController::class, 'getInvoice']);
        Route::get('sale-return-invoice', [SaleReturnController::class, 'saleReturnInvoice'])->name('sale.return.invoice');
        Route::get('/sale-product', [SaleReturnController::class, 'getsaleProduct'])->name('sale.return.get.product');
    });
    //Sale Transaction
    Route::group(['prefix' => 'customer-transaction'], function () {
        Route::get('/{id}', [SaleTransactionController::class, 'index'])->name('customer.transaction');
        Route::post('store', [SaleTransactionController::class, 'store'])->name('customer.transaction.store');
        Route::delete('/destroy/{id}', [SaleTransactionController::class, 'destroy'])->name('customer.transaction.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Inventory Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'Inventory'], function () {
        Route::get('/index', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/search', [InventoryController::class, 'search'])->name('inventory.search');
    });
});
