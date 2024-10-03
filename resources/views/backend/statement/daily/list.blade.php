@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Daily Profit</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Daily Profit</li>
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
              <div id="invoice-company-details" class="row justify-content-center">
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                  <div class="media">
                    <div class="media-body text-center">
                      <ul class="ml-2 px-0 list-unstyled">
                        <img src="/logo.jpeg" height="150px" class="pb-2">
                        <li class="text-bold-800">{{$info->company_name}}</li>
                        <li>Address : {{$info->address}}</li>
                        <li>Phone : {{$info->phone}}</li>
                        <li>Email : {{$info->email}}</li>
                        <li>Date : {{$date}}</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Invoice Company Details -->

              <!-- Invoice Items Details -->
              <div id="invoice-items-details" class="pt-2">
                <div class="row justify-content-center">
                  <div class="col-md-6">
                    <div class="table-responsive col-sm-12">
                        <table class="table">
                          <tbody>
    
                                <tr>
                                    <th>Total Sale : </th>
                                    <th>{{ $sale_amount }}</th>
                                </tr>
                                <tr>
                                  <th>Total Purchase for this sale item: </th>
                                  <th>{{ $sale_product_purchase_amount->total_purchase_amount ? $sale_product_purchase_amount->total_purchase_amount : 0 }}</th>
                                </tr>
                                <tr>
                                  <th>Total Sale Profit: </th>
                                  <th>{{$sale_amount - $sale_product_purchase_amount->total_purchase_amount}}</th>
                                </tr>
                                <tr>
                                    <th>Total Purchase for this sale retrun item : </th>
                                    <th>{{ $sale_return_amount }}</th>
                                </tr>
                                <tr>
                                    <th>Sale Return Profit : </th>
                                    <th>{{$return_profit_amount->return_profit_amount ? $return_profit_amount->return_profit_amount : 0}}</th>
                                </tr>
                                <tr>
                                    <th>Total Sale Profit : </th>
                                    <th>{{($profit_amount - $return_profit_amount->return_profit_amount) }}</th>
                                </tr>
                                <tr>
                                    <th>Total Cost : </th>
                                    <th>{{ $cost }}</th>
                                </tr>
                                <tr>
                                    <th>Total Income : </th>
                                    <th>{{ $income }}</th>
                                </tr>
                                <tr>
                                    <th>Total Profit : </th>
                                    <th>{{ $total_profit }}</th>
                                </tr>
                            </tbody>
                          </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection