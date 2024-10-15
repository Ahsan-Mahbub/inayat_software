@extends('backend.layouts.app')
@section('content')
<style>
    .quick-link .col-lg-3 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 25%;
        flex: 0 0 20%;
        max-width: 20%;
    }
</style>
<!-- start page title -->
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Dashboard</h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">Dashboard</li>
              </ol>
          </div>
          
      </div>
  </div>
</div>     
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="">
            <div class="quick-link">
                <div class="row">
                    @isset(auth()->user()->role->permission['permission']['expense']['received'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('budget.employee')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/6491/6491550.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Total Received</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['expense']['office'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('expense.head')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/5501/5501375.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Office Expense</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['product']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('product.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/product-5806313-4863042.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Product Create</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['qr-code']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('qr-code.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/package-location-8697111-6996247.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">QR Code Print</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['requisition']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('requisition.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/requisition-1659069-1408026.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Purchase Quotation</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['purchase']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('purchase.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/purchase-9687788-7887647.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Product Purchase</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['purchase-return']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('purchase.return.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/parcel-return-6914199-5668381.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Purchase Return</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['sale-requisition']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('sale.requisition.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/requisition-1659069-1408026.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Sale Quotation</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['sale']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('sale.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/box-9270441-7607615.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Product Sale</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['sale-return']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('sale.return.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/product-return-4889676-4076853.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Sale Return</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['inventory']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('inventory.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/inventory-1488878-1259960.png?f=webp&w=256" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Inventory</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['customer']['dues'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('receivable.dues')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/client-2118312-1785007.png?f=webp&w=256" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Dues Client</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['budget']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('budget.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/budget-44-444115.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Employee Budget</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['expense']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('expense.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/financial-expenses-3d-icon-download-in-png-blend-fbx-gltf-file-formats--cost-investment-accounting-finance-banking-money-pack-icons-4755624.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Employee Expense</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['permission']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('permission.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/secure-access-permissions-5334939-4455484.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Permission</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@isset(auth()->user()->role->permission['permission']['product']['index'])
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3"> Product</h4>
                <div>
                    <canvas id="pieChartCategoryInfo" width="100" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Recent 12 Products</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name/Code</th>
                                <th>Category</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($products as $product)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>{{$product->sku}}</td>
                                <td>{{$product -> category ? $product -> category ->  category_name : ''}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endisset
@isset(auth()->user()->role->permission['permission']['sale']['index'])
<div class="row mt-4">
    <div class="col-md-5">
        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Employee Sales</h4>
                    <div>
                        <canvas id="employeeSalesChart" width="100" height="50"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3"> Sales Amount</h4>
                <div>
                    <canvas id="salesChart" width="100" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Recent 12 Sales</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Seller</th>
                                <th>Invoice</th>
                                <th>Quotation</th>
                                <th>Client Name</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($sale->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$sale->creator ? $sale->creator->name : 'N/A'}}</td>
                                <td>{{$sale -> invoice}}</td>
                                <td>{{$sale->requisition ? $sale->requisition->requisition_number : 'N/A'}}</td>
                                <td>{{$sale->customer ? $sale->customer->customer_name : 'N/A'}}</td>
                                <td>{{$sale->total_amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div>
@endisset

@isset(auth()->user()->role->permission['permission']['purchase']['index'])
<div class="row mt-4">
    <div class="col-md-5">
        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Employee Purchases</h4>
                    <div>
                        <canvas id="employeePurchasesChart" width="100" height="50"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Recent 12 Purchases</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Purchaser</th>
                                <th>Invoice</th>
                                <th>Quotation</th>
                                <th>Supplier Name</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($purchase->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$purchase->creator ? $purchase->creator->name : 'N/A'}}</td>
                                <td>{{$purchase -> invoice}}</td>
                                <td>{{$purchase->requisition ? $purchase->requisition->requisition_number : 'N/A'}}</td>
                                <td>{{$purchase->supplier ? $purchase->supplier->supplier_name : 'N/A'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div>
@endisset



@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    // Pie Chart for Sales Information
    const purchaseEmployeeNames = @json($purchaseEmployeeNames);
    const purchaseCounts = @json($purchaseCounts);

    var ctxPie = document.getElementById('employeePurchasesChart').getContext('2d');
    var employeePurchasesChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: purchaseEmployeeNames,
            datasets: [{
                data: purchaseCounts,
                backgroundColor: [
                    'rgba(34, 139, 34, 0.8)',
                    'rgba(255, 165, 0, 0.8)',
                    'rgba(220, 20, 60, 0.8)',
                    'rgba(70, 130, 180, 0.8)',
                    'rgba(128, 0, 128, 0.8)',
                    'rgba(255, 99, 71, 0.8)',
                    'rgba(0, 255, 127, 0.8)',
                    'rgba(135, 206, 250, 0.8)',
                    'rgba(255, 215, 0, 0.8)',
                    'rgba(47, 79, 79, 0.8)',
                    'rgba(75, 0, 130, 0.8)',
                    'rgba(255, 69, 0, 0.8)',
                    'rgba(0, 191, 255, 0.8)',
                    'rgba(139, 0, 0, 0.8)',
                    'rgba(255, 20, 147, 0.8)',
                    'rgba(85, 107, 47, 0.8)',
                    'rgba(154, 205, 50, 0.8)',
                    'rgba(123, 104, 238, 0.8)',
                    'rgba(0, 128, 128, 0.8)',
                    'rgba(240, 230, 140, 0.8)',
                    'rgba(255, 182, 193, 0.8)',
                    'rgba(255, 140, 0, 0.8)',
                    'rgba(46, 139, 87, 0.8)',
                    'rgba(64, 224, 208, 0.8)',
                    'rgba(210, 105, 30, 0.8)'
                ],
                borderColor: [
                    'rgba(34, 139, 34, 1)',
                    'rgba(255, 165, 0, 1)',
                    'rgba(220, 20, 60, 1)',
                    'rgba(70, 130, 180, 1)',
                    'rgba(128, 0, 128, 1)',
                    'rgba(255, 99, 71, 1)',
                    'rgba(0, 255, 127, 1)',
                    'rgba(135, 206, 250, 1)',
                    'rgba(255, 215, 0, 1)',
                    'rgba(47, 79, 79, 1)',
                    'rgba(75, 0, 130, 1)',
                    'rgba(255, 69, 0, 1)',
                    'rgba(0, 191, 255, 1)',
                    'rgba(139, 0, 0, 1)',
                    'rgba(255, 20, 147, 1)',
                    'rgba(85, 107, 47, 1)',
                    'rgba(154, 205, 50, 1)',
                    'rgba(123, 104, 238, 1)',
                    'rgba(0, 128, 128, 1)',
                    'rgba(240, 230, 140, 1)',
                    'rgba(255, 182, 193, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(46, 139, 87, 1)',
                    'rgba(64, 224, 208, 1)',
                    'rgba(210, 105, 30, 1)'
                ],
                borderWidth: 1
            }]
        },
    });

    // Pie Chart for Sales Information
    const employeeNames = @json($employeeNames);
    const saleCounts = @json($saleCounts);

    var ctxPie = document.getElementById('employeeSalesChart').getContext('2d');
    var employeeSalesChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: employeeNames,
            datasets: [{
                data: saleCounts,
                backgroundColor: [
                    'rgba(34, 139, 34, 0.8)',
                    'rgba(255, 165, 0, 0.8)',
                    'rgba(220, 20, 60, 0.8)',
                    'rgba(70, 130, 180, 0.8)',
                    'rgba(128, 0, 128, 0.8)',
                    'rgba(255, 99, 71, 0.8)',
                    'rgba(0, 255, 127, 0.8)',
                    'rgba(135, 206, 250, 0.8)',
                    'rgba(255, 215, 0, 0.8)',
                    'rgba(47, 79, 79, 0.8)',
                    'rgba(75, 0, 130, 0.8)',
                    'rgba(255, 69, 0, 0.8)',
                    'rgba(0, 191, 255, 0.8)',
                    'rgba(139, 0, 0, 0.8)',
                    'rgba(255, 20, 147, 0.8)',
                    'rgba(85, 107, 47, 0.8)',
                    'rgba(154, 205, 50, 0.8)',
                    'rgba(123, 104, 238, 0.8)',
                    'rgba(0, 128, 128, 0.8)',
                    'rgba(240, 230, 140, 0.8)',
                    'rgba(255, 182, 193, 0.8)',
                    'rgba(255, 140, 0, 0.8)',
                    'rgba(46, 139, 87, 0.8)',
                    'rgba(64, 224, 208, 0.8)',
                    'rgba(210, 105, 30, 0.8)'
                ],
                borderColor: [
                    'rgba(34, 139, 34, 1)',
                    'rgba(255, 165, 0, 1)',
                    'rgba(220, 20, 60, 1)',
                    'rgba(70, 130, 180, 1)',
                    'rgba(128, 0, 128, 1)',
                    'rgba(255, 99, 71, 1)',
                    'rgba(0, 255, 127, 1)',
                    'rgba(135, 206, 250, 1)',
                    'rgba(255, 215, 0, 1)',
                    'rgba(47, 79, 79, 1)',
                    'rgba(75, 0, 130, 1)',
                    'rgba(255, 69, 0, 1)',
                    'rgba(0, 191, 255, 1)',
                    'rgba(139, 0, 0, 1)',
                    'rgba(255, 20, 147, 1)',
                    'rgba(85, 107, 47, 1)',
                    'rgba(154, 205, 50, 1)',
                    'rgba(123, 104, 238, 1)',
                    'rgba(0, 128, 128, 1)',
                    'rgba(240, 230, 140, 1)',
                    'rgba(255, 182, 193, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(46, 139, 87, 1)',
                    'rgba(64, 224, 208, 1)',
                    'rgba(210, 105, 30, 1)'
                ],
                borderWidth: 1
            }]
        },
    });


    // Pie Chart for Category Information
    const categoryNames = @json($categoryNames);
    const productCounts = @json($productCounts);

    var ctxPie = document.getElementById('pieChartCategoryInfo').getContext('2d');
    var pieChartCategoryInfo = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: categoryNames,
            datasets: [{
                data: productCounts,
                backgroundColor: [
                    'rgba(34, 139, 34, 0.8)',
                    'rgba(255, 165, 0, 0.8)',
                    'rgba(220, 20, 60, 0.8)',
                    'rgba(70, 130, 180, 0.8)',
                    'rgba(128, 0, 128, 0.8)',
                    'rgba(255, 99, 71, 0.8)',
                    'rgba(0, 255, 127, 0.8)',
                    'rgba(135, 206, 250, 0.8)',
                    'rgba(255, 215, 0, 0.8)',
                    'rgba(47, 79, 79, 0.8)',
                    'rgba(75, 0, 130, 0.8)',
                    'rgba(255, 69, 0, 0.8)',
                    'rgba(0, 191, 255, 0.8)',
                    'rgba(139, 0, 0, 0.8)',
                    'rgba(255, 20, 147, 0.8)',
                    'rgba(85, 107, 47, 0.8)',
                    'rgba(154, 205, 50, 0.8)',
                    'rgba(123, 104, 238, 0.8)',
                    'rgba(0, 128, 128, 0.8)',
                    'rgba(240, 230, 140, 0.8)',
                    'rgba(255, 182, 193, 0.8)',
                    'rgba(255, 140, 0, 0.8)',
                    'rgba(46, 139, 87, 0.8)',
                    'rgba(64, 224, 208, 0.8)',
                    'rgba(210, 105, 30, 0.8)'
                ],
                borderColor: [
                    'rgba(34, 139, 34, 1)',
                    'rgba(255, 165, 0, 1)',
                    'rgba(220, 20, 60, 1)',
                    'rgba(70, 130, 180, 1)',
                    'rgba(128, 0, 128, 1)',
                    'rgba(255, 99, 71, 1)',
                    'rgba(0, 255, 127, 1)',
                    'rgba(135, 206, 250, 1)',
                    'rgba(255, 215, 0, 1)',
                    'rgba(47, 79, 79, 1)',
                    'rgba(75, 0, 130, 1)',
                    'rgba(255, 69, 0, 1)',
                    'rgba(0, 191, 255, 1)',
                    'rgba(139, 0, 0, 1)',
                    'rgba(255, 20, 147, 1)',
                    'rgba(85, 107, 47, 1)',
                    'rgba(154, 205, 50, 1)',
                    'rgba(123, 104, 238, 1)',
                    'rgba(0, 128, 128, 1)',
                    'rgba(240, 230, 140, 1)',
                    'rgba(255, 182, 193, 1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(46, 139, 87, 1)',
                    'rgba(64, 224, 208, 1)',
                    'rgba(210, 105, 30, 1)'
                ],
                borderWidth: 1
            }]
        },
    });

    // Line Chart for Sales Report
    const currentMonthSales = @json($currentMonthSales);
    const previousMonthSales = @json($previousMonthSales);

    if (currentMonthSales.length === 0 && previousMonthSales.length === 0) {
        console.error('No sales data available.');
    }

    const currentMonthData = currentMonthSales.slice(0, 2).map(sale => ({
        x: new Date(sale.date).toLocaleDateString(),
        y: sale.total_sales
    }));

    const previousMonthData = previousMonthSales.map(sale => ({
        x: new Date(sale.date).toLocaleDateString(),
        y: sale.total_sales
    }));

    const ctxBar = document.getElementById('salesChart');
    if (ctxBar) {
        const ctx = ctxBar.getContext('2d');

        const gradientCurrent = ctx.createLinearGradient(0, 0, 0, 400);
        gradientCurrent.addColorStop(0, 'rgba(75, 192, 192, 0.5)');
        gradientCurrent.addColorStop(1, 'rgba(75, 192, 192, 0)');

        const gradientPrevious = ctx.createLinearGradient(0, 0, 0, 400);
        gradientPrevious.addColorStop(0, 'rgba(34, 139, 34, 0.5)');
        gradientPrevious.addColorStop(1, 'rgba(34, 139, 34, 0)');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: currentMonthData.map(data => data.x),
                datasets: [
                    {
                        label: 'Current Month Sales',
                        data: currentMonthData.map(data => data.y),
                        backgroundColor: gradientCurrent,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Previous Month Sales',
                        data: previousMonthData.map(data => data.y),
                        backgroundColor: gradientPrevious,
                        borderColor: 'rgba(34, 139, 34, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        },
                        stacked: false
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales Amount'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    } else {
        console.error('Canvas element for sales chart not found.');
    }
</script>

@endsection