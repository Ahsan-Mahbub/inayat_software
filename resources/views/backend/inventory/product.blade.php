@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Inventory</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Inventory</li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-right mb-4">
                        @isset(auth()->user()->role->permission['permission']['inventory']['print'])
                        <button type="button" class="btn btn-info btn-sm" onclick="printableContent('printableContent')">
                            <i class="mdi mdi-printer-check"></i> Print
                        </button>
                        @endisset
                    </div>
                    <form method="get" action="{{ route('inventory.search') }}">
                        <div class="row mb-3">
                            <div class="col-md-3 col-12">
                                <label>Category: </label>
                                <select class="custom-select select2" name="category_id">
                                    <option value="">Select One</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $search_category ? 'selected' : '' }}>
                                            {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Product: </label>
                                <select class="custom-select select2" required="" name="product_id">
                                    <option value="">Select One</option>
                                    @foreach ($all_products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == $search ? 'selected' : '' }}>
                                            {{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-12 mt-auto">
                                <input type="submit" class="btn btn-info" value="Search">
                            </div>
                        </div>
                    </form>
                    <div class="block-header block-header-default mb-4">
                        <div class="block-header block-header-default">
                            <div class="block-options">
                                  <input class="ml-3 mr-1" type="checkbox"  id="sl" checked> S.L
                                  <input class="ml-3 mr-1" type="checkbox"  id="name" checked> Product Name
                                  <input class="ml-3 mr-1" type="checkbox"  id="unit" checked> Unit
                                  <input class="ml-3 mr-1" type="checkbox"  id="purchase-qty" checked> Purchase Qty
                                  <input class="ml-3 mr-1" type="checkbox"  id="purchase-return" checked> Purchase Return Qty
                                  <input class="ml-3 mr-1" type="checkbox"  id="sample-request-qty" checked> Sample Request Qty
                                  <input class="ml-3 mr-1" type="checkbox"  id="sample-request-return" checked> Sample Request Return Qty
                                  <input class="ml-3 mr-1" type="checkbox"  id="sale-qty" checked> Sale Qty
                                  <input class="ml-3 mr-1" type="checkbox"  id="sale-return" checked> Sale Return Qty
                                  <input class="ml-3 mr-1" type="checkbox"  id="stock" checked> Available Stock
                                  @if(Auth::user()->role_id == 1)
                                  <input class="ml-3 mr-1" type="checkbox"  id="purchase" checked> Purchase Price
                                  <input class="ml-3 mr-1" type="checkbox"  id="total-purchase" checked> Available Purchase Amount
                                  <input class="ml-3 mr-1" type="checkbox"  id="sale" checked> Sale Price
                                  <input class="ml-3 mr-1" type="checkbox"  id="total-sale" checked>Available Sale Amount
                                  @endif
                                  <input class="ml-3 mr-1" type="checkbox"  id="status" checked> Status
                                  <input class="ml-3 mr-1" type="checkbox"  id="calculation" checked> Calculation
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" id="printableContent">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>
                                <tr>
                                    <th class="sl">S/N</th>
                                    <th class="name">Product Name</th>
                                    <th class="unit">Unit</th>
                                    <th class="purchase-qty">Purchase Qty</th>
                                    <th class="purchase-return">Purchase Return Qty</th>
                                    <th class="sample-request-qty">Sample Request Qty</th>
                                    <th class="sample-request-return">Sample Request Return Qty</th>
                                    <th class="sale-qty">Sale Qty</th>
                                    <th class="sale-return">Sale Return Qty</th>
                                    <th class="stock">Available Stock</th>
                                    {{-- <th>Stock Amount</th> --}}
                                    @if(Auth::user()->role_id == 1)
                                        <th class="purchase">Purchase Price</th>
                                        <th class="total-purchase">Available Purchase Amount</th>
                                        <th class="sale">Sale Price</th>
                                        <th class="total-sale">Available Sale Amount</th>
                                    @endif
                                    <th class="status">Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                    $total_now_stock = 0;
                                    $total_purchase_amount = 0;
                                    $total_sale_amount = 0;
                                @endphp
                                @foreach ($purchase_products as $purchase)
                                <?php
                                    $product = App\Models\Product::where('id', $purchase->product_id)->first();
                                    if($product)
                                    {
                                        $unit = App\Models\Unit::where('id', $purchase->unit_id)->first();
                                        $purchase_return_qty = App\Models\PurchaseReturn::where('product_id', $purchase->product_id)
                                            ->where('unit_id', $purchase->unit_id)
                                            ->sum('qty');

                                        $sale_qty = App\Models\SaleProduct::where('product_id', $purchase->product_id)
                                            ->where('unit_id', $purchase->unit_id)
                                            ->sum('qty');
                                        $sale_return_qty = App\Models\SaleReturn::where('product_id', $purchase->product_id)
                                            ->where('unit_id', $purchase->unit_id)
                                            ->sum('qty');

                                        $sample_request_qty = App\Models\SampleRequestProduct::where('product_id', $purchase->product_id)
                                            ->where('unit_id', $purchase->unit_id)
                                            ->sum('qty');
                                        $sample_request_return_qty = App\Models\SampleReturn::where('product_id', $purchase->product_id)
                                            ->where('unit_id', $purchase->unit_id)
                                            ->sum('qty');
                                        
                                        
                                        $total_qty = $purchase->total_qty - $purchase_return_qty - $sale_qty + $sale_return_qty - $sample_request_qty + $sample_request_return_qty;
                                        
                                        $purchase_last_product = App\Models\PurchaseProduct::where('product_id', $purchase->product_id)
                                            ->where('unit_id', $purchase->unit_id)
                                            ->orderBy('id', 'desc')
                                            ->first();
                                        
                                        $purchase_amount = $product->purchase_price * $total_qty;
                                        $sale_amount = $product->sale_price * $total_qty;
                                        
                                        $total_purchase_amount += $purchase_amount;
                                        $total_sale_amount += $sale_amount;
                                        $total_now_stock += $total_qty;
                                        ?>
                                        @if($total_qty > 0)
                                        <tr>
                                            <td class="sl">{{ $sl++ }}</td>
                                            <td class="name">{{ $product->product_name }}</td>
                                            <td class="unit">{{ $unit->unit_name }}</td>
                                            <td class="purchase-qty">{{ $purchase->total_qty }}</td>
                                            <td class="purchase-return">{{ $purchase_return_qty }}</td>
                                            <td class="sample-request-qty">{{$sample_request_qty}}</td>
                                            <td class="sample-request-return">{{$sample_request_return_qty}}</td>
                                            <td class="sale-qty">{{ $sale_qty }}</td>
                                            <td class="sale-return">{{ $sale_return_qty }}</td>
                                            <td class="stock">{{ $total_qty }}</td>
                                            {{-- <td>{{ $purchase_amount }}</td> --}}
                                            @if(Auth::user()->role_id == 1)
                                                <td class="purchase">{{ $product->purchase_price }}</td>
                                                <td class="total-purchase">{{ $product->purchase_price * $total_qty }}</td>
                                                <td class="sale">{{ $product->sale_price }}</td>
                                                <td class="total-sale">{{ $product->sale_price * $total_qty }}</td>
                                            @endif
                                            <td class="status">
                                                @if ($total_qty <= 5 && $total_qty >= 1)
                                                    <span class="badge badge-pill badge-warning">Low inventory</span>
                                                @elseif($total_qty == 0)
                                                    <span class="badge badge-pill badge-danger">Zero inventory</span>
                                                @elseif($total_qty < 0)
                                                    <span class="badge badge-pill badge-dark">Stock Negative</span>
                                                @else
                                                    <span class="badge badge-pill badge-success">Up to 5</span>
                                                @endif
                                            </td>
                                        </tr>  
                                        @endif 
                                        <?php
                                    }
                                ?>
                                @endforeach
                                
                            </tbody>
                        </table>
                        @if(Auth::user()->role_id == 1)
                            <div style="width: 35%; float: right;" class="calculation">
                                <table class="table">
                                    <tbody>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                colspan="7" class="text-bold-800"><b>Total Available Stock</b></td>
                                            <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                <b>{{ $total_now_stock }}</b>
                                            </td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                colspan="7" class="text-bold-800"><b>Available Purchase Amount</b></td>
                                            <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                <b>{{ $total_purchase_amount }} /-</b>
                                            </td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                colspan="7" class="text-bold-800"><b>Available Sale Amount</b></td>
                                            <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                <b>{{ $total_sale_amount }} /-</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
 <script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            var columnId = $(this).attr('id');
            if ($(this).is(":checked")) {
                $('.' + columnId).removeClass('d-none');
            } else {
                $('.' + columnId).addClass('d-none');
            }
        });
    });
 </script>
@endsection