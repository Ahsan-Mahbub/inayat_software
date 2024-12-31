<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\SaleRequisition;
use App\Models\SaleRequisitionProduct;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Requisition;
use App\Models\RequisitionProduct;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\SampleRequest;
use App\Models\SampleRequestProduct;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function saleRequisition()
    {
        $users = User::get();
        $customers = Customer::get();
        return view('backend.report.sale-requisition.index', compact('users','customers'));
    }

    public function saleRequisitionData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();
        $customer = Customer::where('id', $request->customer_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $customer_id = $request->customer_id;
        $creator_id = $request->employee_id;

        if($user)
        {
            if($user->role_id == 4 || $user->role_id == 5){
                $userIds = User::where(function ($query) use ($user) {
                    $userId = $user->id;
                    $query->where('head_id', $userId)
                        ->orWhere('subhead_id', $userId);
                })->pluck('id');
    
                $all_requisition = SaleRequisition::where(function ($query) use ($creator_id, $userIds) {
                    $query->where('creator_id', $creator_id)
                          ->orWhereIn('creator_id', $userIds);
                    })
                    ->when($form_date, function ($query, $form_date) {
                        return $query->whereDate('date', '>=', $form_date);
                    })
                    ->when($to_date, function ($query, $to_date) {
                        return $query->whereDate('date', '<=', $to_date);
                    })
                    ->when($customer_id, function ($query, $customer_id) {
                        return $query->where('customer_id', $customer_id);
                    })
                    ->get(); 
            }else{
                $all_requisition = SaleRequisition::query()
                ->when($form_date, function ($query, $form_date) {
                    return $query->whereDate('date', '>=', $form_date);
                })
                ->when($to_date, function ($query, $to_date) {
                    return $query->whereDate('date', '<=', $to_date);
                })
                ->when($customer_id, function ($query, $customer_id) {
                    return $query->where('customer_id', $customer_id);
                })
                ->when($creator_id, function ($query, $creator_id) {
                    return $query->where('creator_id', $creator_id);
                })
                ->get();
            }
        }else{
            $all_requisition = SaleRequisition::query()
                ->when($form_date, function ($query, $form_date) {
                    return $query->whereDate('date', '>=', $form_date);
                })
                ->when($to_date, function ($query, $to_date) {
                    return $query->whereDate('date', '<=', $to_date);
                })
                ->when($customer_id, function ($query, $customer_id) {
                    return $query->where('customer_id', $customer_id);
                })
                ->when($creator_id, function ($query, $creator_id) {
                    return $query->where('creator_id', $creator_id);
                })
                ->get();
        }
        return view('backend.report.sale-requisition.list', compact('user','customer','all_requisition','form_date', 'to_date','creator_id','customer_id'));
    }


    public function sale()
    {
        $users = User::get();
        $customers = Customer::get();
        return view('backend.report.sale.index', compact('users','customers'));
    }

    public function saleData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();
        $customer = Customer::where('id', $request->customer_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $customer_id = $request->customer_id;
        $creator_id = $request->employee_id;

        $all_sale = Sale::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($customer_id, function ($query, $customer_id) {
                return $query->where('customer_id', $customer_id);
            })
            ->when($creator_id, function ($query, $creator_id) {
                return $query->where('creator_id', $creator_id);
            })
            ->get();
        return view('backend.report.sale.list', compact('user','customer','all_sale','form_date', 'to_date','creator_id','customer_id'));
    }

    public function purchaseRequisition()
    {
        $users = User::get();
        $suppliers = Supplier::get();
        return view('backend.report.purchase-requisition.index', compact('users','suppliers'));
    }

    public function purchaseRequisitionData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();
        $supplier = Supplier::where('id', $request->supplier_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $supplier_id = $request->supplier_id;
        $creator_id = $request->employee_id;

        $all_requisition = Requisition::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($supplier_id, function ($query, $supplier_id) {
                return $query->where('supplier_id', $supplier_id);
            })
            ->when($creator_id, function ($query, $creator_id) {
                return $query->where('creator_id', $creator_id);
            })
            ->get();
        return view('backend.report.purchase-requisition.list', compact('user','supplier','all_requisition','form_date', 'to_date','creator_id','supplier_id'));
    }

    public function purchase()
    {
        $users = User::get();
        $suppliers = Supplier::get();
        return view('backend.report.purchase.index', compact('users','suppliers'));
    }

    public function purchaseData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();
        $supplier = Supplier::where('id', $request->supplier_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $supplier_id = $request->supplier_id;
        $creator_id = $request->employee_id;

        $all_purchase = Purchase::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($supplier_id, function ($query, $supplier_id) {
                return $query->where('supplier_id', $supplier_id);
            })
            ->when($creator_id, function ($query, $creator_id) {
                return $query->where('creator_id', $creator_id);
            })
            ->get();
        return view('backend.report.purchase.list', compact('user','supplier','all_purchase','form_date', 'to_date','creator_id','supplier_id'));
    }

    public function allEmployee()
    {
        $users = User::get();
        return view('backend.report.employee.index', compact('users'));
    }

    public function allEmployeeData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $creator_id = $request->employee_id;

        if($user)
        {
            if($user->role_id == 4 || $user->role_id == 5){
                $userIds = User::where(function ($query) use ($user) {
                    $userId = $user->id;
                    $query->where('head_id', $userId)
                        ->orWhere('subhead_id', $userId);
                })->pluck('id');
    
                $all_sale_requisition = SaleRequisition::where(function ($query) use ($creator_id, $userIds) {
                    $query->where('creator_id', $creator_id)
                          ->orWhereIn('creator_id', $userIds);
                    })
                    ->when($form_date, function ($query, $form_date) {
                        return $query->whereDate('date', '>=', $form_date);
                    })
                    ->when($to_date, function ($query, $to_date) {
                        return $query->whereDate('date', '<=', $to_date);
                    })
                    ->get(); 
            }else{
                $all_sale_requisition = SaleRequisition::query()
                ->when($form_date, function ($query, $form_date) {
                    return $query->whereDate('date', '>=', $form_date);
                })
                ->when($to_date, function ($query, $to_date) {
                    return $query->whereDate('date', '<=', $to_date);
                })
                ->when($creator_id, function ($query, $creator_id) {
                    return $query->where('creator_id', $creator_id);
                })
                ->get();
            }
        }else{
            $all_sale_requisition = SaleRequisition::query()
                ->when($form_date, function ($query, $form_date) {
                    return $query->whereDate('date', '>=', $form_date);
                })
                ->when($to_date, function ($query, $to_date) {
                    return $query->whereDate('date', '<=', $to_date);
                })
                ->when($creator_id, function ($query, $creator_id) {
                    return $query->where('creator_id', $creator_id);
                })
                ->get();
        }

        $all_sale = Sale::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($creator_id, function ($query, $creator_id) {
                return $query->where('creator_id', $creator_id);
            })
            ->get();
        $all_requisition = Requisition::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($creator_id, function ($query, $creator_id) {
                return $query->where('creator_id', $creator_id);
            })
            ->get();
        $all_purchase = Purchase::query()
            ->when($form_date, function ($query, $form_date) {
                return $query->whereDate('date', '>=', $form_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->when($creator_id, function ($query, $creator_id) {
                return $query->where('creator_id', $creator_id);
            })
            ->get();
        return view('backend.report.employee.list', compact('user','all_sale_requisition','all_sale','all_requisition','all_purchase','form_date', 'to_date','creator_id'));
    }

    public function sampleRequest()
    {
        $users = User::get();
        $customers = Customer::get();
        return view('backend.report.sample.index', compact('users','customers'));
    }

    public function sampleRequestData(Request $request)
    {
        $user = User::where('id', $request->employee_id)->first();
        $customer = Customer::where('id', $request->customer_id)->first();

        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $customer_id = $request->customer_id;
        $creator_id = $request->employee_id;

        if($user)
        {
            if($user->role_id == 4 || $user->role_id == 5){
                $userIds = User::where(function ($query) use ($user) {
                    $userId = $user->id;
                    $query->where('head_id', $userId)
                        ->orWhere('subhead_id', $userId);
                })->pluck('id');
    
                $all_request = SampleRequest::where(function ($query) use ($creator_id, $userIds) {
                    $query->where('creator_id', $creator_id)
                          ->orWhereIn('creator_id', $userIds);
                    })
                    ->when($form_date, function ($query, $form_date) {
                        return $query->whereDate('date', '>=', $form_date);
                    })
                    ->when($to_date, function ($query, $to_date) {
                        return $query->whereDate('date', '<=', $to_date);
                    })
                    ->when($customer_id, function ($query, $customer_id) {
                        return $query->where('customer_id', $customer_id);
                    })
                    ->get(); 
            }else{
                $all_request = SampleRequest::query()
                ->when($form_date, function ($query, $form_date) {
                    return $query->whereDate('date', '>=', $form_date);
                })
                ->when($to_date, function ($query, $to_date) {
                    return $query->whereDate('date', '<=', $to_date);
                })
                ->when($customer_id, function ($query, $customer_id) {
                    return $query->where('customer_id', $customer_id);
                })
                ->when($creator_id, function ($query, $creator_id) {
                    return $query->where('creator_id', $creator_id);
                })
                ->get();
            }
        }else{
            $all_request = SampleRequest::query()
                ->when($form_date, function ($query, $form_date) {
                    return $query->whereDate('date', '>=', $form_date);
                })
                ->when($to_date, function ($query, $to_date) {
                    return $query->whereDate('date', '<=', $to_date);
                })
                ->when($customer_id, function ($query, $customer_id) {
                    return $query->where('customer_id', $customer_id);
                })
                ->when($creator_id, function ($query, $creator_id) {
                    return $query->where('creator_id', $creator_id);
                })
                ->get();
        }
        return view('backend.report.sample.list', compact('user','customer','all_request','form_date', 'to_date','creator_id','customer_id'));
    }
}
