<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Category;

class AjaxController extends Controller
{

    public function getAccount($id)
    {   
        $account = Account::where('method_id', $id)->get();
        return response()->json($account, 200);
    }

    public function getSupplier($id)
    {   
        $supplier = Supplier::where('id', $id)->first();
        return response()->json($supplier, 200);
    }

    public function getCustomer($id)
    {   
        $customer = Customer::where('id', $id)->first();
        return response()->json($customer, 200);
    }

    //  getAllPurchaseData
    public function getAllPurchaseData(Request $request)
    {   
        $categories = Category::get();
        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function getAllCategoryData(Request $request)
    {   
        $categories = Category::get();
        return response()->json([
            'categories' => $categories,
        ]);
    }
}
