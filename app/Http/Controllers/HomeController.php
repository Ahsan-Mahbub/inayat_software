<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleRequisition;
use App\Models\Purchase;
use App\Models\Requisition;
use Illuminate\Support\Facades\Auth;
use Hash;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //ProductList
        $products = Product::orderBy('id','desc')->paginate(12);
        //CategoryWiseProduct
        $categories = Category::withCount('products')->get();
        $categoryNames = $categories->pluck('category_name');
        $productCounts = $categories->pluck('products_count');
        //Previous&CurrentMonthSalesAmount
        $currentMonth = Carbon::now()->month;
        $previousMonth = Carbon::now()->subMonth()->month;
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
        {
            $currentMonthSales = Sale::selectRaw('DATE(date) as date, SUM(total_amount) as total_sales')
                ->whereMonth('date', $currentMonth)
                ->groupBy('date')
                ->get();
            $previousMonthSales = Sale::selectRaw('DATE(date) as date, SUM(total_amount) as total_sales')
                ->whereMonth('date', $previousMonth)
                ->groupBy('date')
                ->get();
        }else{
            $currentMonthSales = Sale::where('creator_id', Auth::user()->id)->selectRaw('DATE(date) as date, SUM(total_amount) as total_sales')
                ->whereMonth('date', $currentMonth)
                ->groupBy('date')
                ->get();
            $previousMonthSales = Sale::where('creator_id', Auth::user()->id)->selectRaw('DATE(date) as date, SUM(total_amount) as total_sales')
                ->whereMonth('date', $previousMonth)
                ->groupBy('date')
                ->get();
        }
        //Sales
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
        {
            $sales = Sale::orderBy('id','desc')->paginate(12);
        }else{
            $sales = Sale::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate(12);
        }
        //EmployeeWiseSale
        $sales_user = Sale::select('creator_id')->pluck('creator_id');
        $employees = User::whereIn('id', $sales_user)->withCount('sales')->get();
        $employeeNames = $employees->pluck('name');
        $saleCounts = $employees->pluck('sales_count');

        //Purchases
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
        {
            $purchases = Purchase::orderBy('id','desc')->paginate(12);
        }else{
            $purchases = Purchase::where('creator_id', Auth::user()->id)->orderBy('id','desc')->paginate(12);
        }
        //EmployeeWisePurchase
        $purchases_user = Purchase::select('creator_id')->pluck('creator_id');
        $employees = User::whereIn('id', $purchases_user)->withCount('purchases')->get();
        $purchaseEmployeeNames = $employees->pluck('name');
        $purchaseCounts = $employees->pluck('purchases_count');
        return view('backend.layouts.dashboard', compact('products', 'categoryNames', 'productCounts','currentMonthSales',
        'previousMonthSales','sales', 'employeeNames', 'saleCounts', 'purchases', 'purchaseEmployeeNames', 'purchaseCounts'));
    }

    public function profile()
    {
        return view('backend.layouts.profile');
    }

    public function store(Request $request){
        
       if ($request->password) {
            $data = [
                'name'   => $request->name,
                'email'  => $request->email,
                'password'=> Hash::make($request->password),
            ];
        } else {
            $data = [
                'name'   => $request->name,
                'email'  => $request->email,
                'password' => Auth::user()->password,
            ];
        }
        
        User::where('id', Auth::user()->id)->update($data);
        return back()->with('message','Profile Update Successfully');
    }
}
