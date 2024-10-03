<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
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
        if ($request->search) {

            $purchase_products = DB::table('purchase_products')
                ->where('product_id', $request->product_id)
                ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('product_id', 'unit_id')
                ->get();
        } elseif ($request->category_id) {

            $search_product = Product::where('category_id', $request->category_id)->pluck('id');
            if ($search_product->isNotEmpty()) {
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
        } elseif ($request->product_id) {

            $search_product = Product::where('id', $request->product_id)->pluck('id');
            if ($search_product->isNotEmpty()) {
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
        } else {
            $purchase_products = DB::table('purchase_products')
                ->select('product_id', 'unit_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('product_id', 'unit_id')
                ->get();
        }


        return view('backend.inventory.product', compact('purchase_products', 'search', 'all_products', 'search_category', 'categories'));
    }
}
