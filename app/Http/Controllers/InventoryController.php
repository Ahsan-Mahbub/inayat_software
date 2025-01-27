<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $all_products = Product::get();
        $categories = Category::get();
        $purchase_products = DB::table('purchase_products')
            ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id', 'unit_id')
            ->get();
        $search = '';
        $search_category = '';
        return view('backend.inventory.index', compact('purchase_products', 'search', 'all_products', 'categories', 'search_category'));
    }

    public function search(Request $request)
    {
        $search = $request->product_id;
        $search_category = $request->category_id;

        $categories = Category::get();
        $all_products = Product::get();
        // dd($request->all());
        if ($request->category_id && $request->product_id) {

            $search_product = Product::where('id', $request->product_id)->where('category_id', $request->category_id)->pluck('id');
            $purchase_products = DB::table('purchase_products')
                    ->whereIn('product_id', $search_product)
                    ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
                    ->groupBy('product_id', 'unit_id')
                    ->get();
        } elseif ($request->category_id) {

            $search_product = Product::where('category_id', $request->category_id)->pluck('id');
            $purchase_products = DB::table('purchase_products')
                    ->whereIn('product_id', $search_product)
                    ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
                    ->groupBy('product_id', 'unit_id')
                    ->get();
        } elseif ($request->product_id) {

            $search_product = Product::where('id', $request->product_id)->pluck('id');
            $purchase_products = DB::table('purchase_products')
                    ->whereIn('product_id', $search_product)
                    ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
                    ->groupBy('product_id', 'unit_id')
                    ->get();
        } else {
            $purchase_products = DB::table('purchase_products')
                ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('product_id', 'unit_id')
                ->get();
        }


        return view('backend.inventory.product', compact('purchase_products', 'search', 'all_products', 'search_category', 'categories'));
    }


    public function employee()
    {
        $all_products = Product::get();
        $users = User::get();
        $purchase_products = DB::table('purchase_products')
            ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id', 'unit_id')
            ->get();
        $search = '';
        $search_user = '';
        return view('backend.inventory.employee-wise', compact('purchase_products', 'search', 'all_products', 'users', 'search_user'));
    }


    public function employeeSearch(Request $request)
    {
        $search_user = $request->user_id;
        $users = User::all();
        $all_products = Product::all();

        $query = DB::table('purchase_products')
            ->join('purchases', 'purchase_products.purchase_id', '=', 'purchases.id')
            ->select(
                'purchase_products.product_id',
                'purchase_products.unit_id',
                DB::raw('SUM(purchase_products.qty) as total_qty'),
                DB::raw('SUM(purchase_products.amount) as total_amount')
            )
            ->groupBy('purchase_products.product_id', 'purchase_products.unit_id');

        if ($request->user_id) {
            $query->where('purchases.creator_id', $request->user_id);
        }

        $purchase_products = $query->get();

        // dd($purchase_products);

        return view('backend.inventory.employee-product', compact('purchase_products', 'search_user', 'all_products', 'users'));
    }


}
