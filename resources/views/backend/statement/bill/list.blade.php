@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Profit - {{$sale->invoice}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Bill Wise Profit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="text-right mb-3">
  <button type="button" class="btn btn-info" onclick="printableContent('printableContent')">
    <i class="mdi mdi-printer-check"></i>Print
  </button>
</div>


<div class="row">
    <div class="col-12">
        <section class="card p-3" id="printableContent">
            <div class="card-body">
              <!-- Invoice Company Details -->
              <div id="invoice-company-details" class="row">
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                  <div class="media">
                    <div class="media-body ">
                      <ul class="ml-2 px-0 list-unstyled">
                        <img src="/logo.jpeg" height="150px" class="pb-2">
                        <li class="text-bold-800">{{$info->company_name}}</li>
                        <li>{{$info->address}}</li>
                        <li>{{$info->phone}}</li>
                        <li>{{$info->email}}</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                  <h2>INVOICE</h2>
                  <ul class="px-0 list-unstyled">
                    <li># {{$sale->invoice}}</li>
                    <li>Date : <?php
                          $timestamp = strtotime($sale->date);
                          $date = date('d-m-Y', $timestamp);
                      ?>
                      {{$date}}
                    </li>
                    <li>Customer Name : {{$sale->customer ? $sale->customer->customer_name : 'N/A'}}</li>
                    <li>Phone Number : {{$sale->customer ? $sale->customer->phone : 'N/A'}}</li>
                    <li>Email : {{$sale->customer ? $sale->customer->email : 'N/A'}}</li>
                    <li>Address : {{$sale->customer ? $sale->customer->address : 'N/A'}}</li>
                  </ul>
                </div>
              </div>
              <!--/ Invoice Company Details -->

              <!-- Invoice Items Details -->
              <div id="invoice-items-details" class="pt-2">
                <div class="row">
                  <div class="table-responsive col-sm-12">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Item &amp; SKU</th>
                          <th class="text-right">Size</th>
                          <th class="text-right">Unit</th>
                          <th class="text-right">QTY</th>
                          <th class="text-right">Sale Amount</th>
                          <th class="text-right">Purchase Amount</th>
                          <th class="text-right">Return Amount</th>
                          <th class="text-right">Profit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $sl = 1;
                            $total_sale_amount = 0;
                            $total_purchase_amount = 0;
                            $total_profit_amount = 0;
                            $total_return_amount = 0;
                        @endphp
                        @foreach($products as $product)
                        @php
                            $returns_amount = App\Models\SaleReturn::where('sale_id', $sale->id)->where('product_id', $product->id)->sum('amount');
                            $total_sale_amount += $product->amount;
                            $total_purchase_amount += ($product->qty * $product->purchase_price);
                            $total_profit_amount += $product->amount - $returns_amount - ($product->qty * $product->purchase_price);
                            $total_return_amount += $returns_amount;
                            
                        @endphp
                        <tr>
                          <th scope="row">{{$sl++}}</th>
                          <td>
                            <p>{{$product->product ? $product->product->product_name : 'N/A'}} (<span class="text-muted">{{$product->product ? $product->product->sku : 'N/A'}}</span>)</p>
                          </td>
                          <td class="text-right">{{$product->size }}</td>
                          <td class="text-right">{{$product->unit ? $product->unit->unit_name : 'N/A'}}</td>
                          <td class="text-right">{{$product->qty}}</td>
                          <td class="text-right">{{$product->amount}}</td>
                          <td class="text-right">{{$product->qty * $product->purchase_price}}</td>
                          <td class="text-right">{{$returns_amount}}</td>
                          <td class="text-right">{{$product->amount - $returns_amount - ($product->qty * $product->purchase_price)}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="6" class="text-right">Total Sale : {{$total_sale_amount }}</th>
                            <th class="text-right">Total Purchase : {{$total_purchase_amount }}</th>
                            <th class="text-right">Total Return : {{$total_return_amount }}</th>
                            <th class="text-right">Gross Profit : {{$total_profit_amount }}</th>
                          </tr>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection