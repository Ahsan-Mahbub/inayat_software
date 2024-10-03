@extends('backend.layouts.app')
<style>
  @media print {
      @page {
          margin-top: 1.5in;
          margin-bottom: 1in;
          margin-right: 1in;
          margin-left: 1in;
      }
      @page :first {
          margin-top: 0in;
          margin-bottom: 1in;
          margin-right: 1in;
          margin-left: 1in;
      }
  }
</style>
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Sale : {{$sale->challan}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Sale</li>
                    <li class="breadcrumb-item active">Challan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="text-right mb-3">
  <button type="button" class="btn btn-info" onclick="printableContent('printableContent')">
    <i class="mdi mdi-printer-check"></i>Print Challan
  </button>
</div>
<div class="row">
    <div class="col-12">
        <section class="card p-3" id="printableContent" style="background-color: transparent;">
            <div class="card-body">
              
              <div class="bg-header" style="margin-bottom: 20px">
                <img src="/bg.png" style="width: 100%;">
              </div>
              <!-- Challan Company Details -->
              <div id="Challan-company-details" class="row">
                <div class="col-md-12" style="color: #000">
                  <span style="display: block; margin-bottom: 2px">{{$sale->challan}}</span>
                  <span style="display: block; margin-bottom: 2px">{{$sale->invoice}}</span>
                  <span style="display: block; margin-bottom: 2px">{{$sale->requisition ? $sale->requisition->requisition_number : ''}}</span>
                  <?php
                      echo date('j-M-y');
                    ?>
                  <ul class="px-0 list-unstyled" style="color: #000">
                    <li style="margin-top: 5px">To</li>
                    <li><b>{{$sale->customer ? $sale->customer->customer_name : 'N/A'}}</b></li>
                    <li>{{$sale->customer ? $sale->customer->designation : 'N/A'}}</li>
                    <li>{{$sale->customer ? $sale->customer->company_name : 'N/A'}}</li>
                    <li>{{$sale->customer ? $sale->customer->address : 'N/A'}}</li>
                  </ul>
                </div>
                <div class="col-12">
                  <span style="color: #000">Dear Sir/Madam,</span>
                  <p style="color: #000">We are pleased to submit the following challan as per requirement for your kind considaration</p>
                </div>
              </div>
              <!--/ Challan Company Details -->
              <div class="price-box" style="background-color: #b1b0b0!important; padding: 2px; text-align: center; font-weight: bold; color: #000; border: 2px solid #000">
                <span style="font-size: 22px;">Challan</span>
              </div>
              <!-- Challan Items Details -->
              <div id="Challan-items-details" class="pt-2">
                <div class="row">
                  <div class="table-responsive col-sm-12">
                    <table class="table" style="color: #000">
                      <thead>
                        <tr>
                          <th style="border: 2px solid #3e3e3e;">#</th>
                          <th style="border: 2px solid #3e3e3e;">Name/Code</th>
                          <th style="border: 2px solid #3e3e3e;">Product Image</th>
                          <th style="border: 2px solid #3e3e3e;">Product Description</th>
                          <th style="border: 2px solid #3e3e3e;">Unit</th>
                          <th style="border: 2px solid #3e3e3e;" class="text-right">QTY</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach($products as $product)
                        <tr>
                          <th style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;" scope="row">{{$sl++}}</th>
                          <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                            {{$product->product ? $product->product->product_name : 'N/A'}}
                          </td>
                          <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                            @if($product->product)
                            <img src="/{{$product->product->image}}" width="200">
                            @else
                            <img src="/demo.svg" width="100">
                            @endif
                          </td>
                          <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                            {!! $product->product ? $product->product->description : 'N/A' !!}
                          </td>
                          <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align: center">
                            {{$product->unit ? $product->unit->unit_name : 'N/A'}}
                          </td>
                          <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align:center">{{$product->qty}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                
                <div style="margin-top: 150px; display: flex">
                  <div style="color: #000; width: 32%">
                    <ul class="px-0 list-unstyled" style="color: #000">
                      <li style="text-decoration: overline dotted;"><b>{{$sale->creator ? $sale->creator->name : 'N/A'}}</b></li>
                      <li>{{$sale->creator ? $sale->creator->role->role_name : 'N/A'}}</li>
                      <li>INAYAT TRADING</li>
                      <li>01611-006001</li>
                      <li>House-6/20 (2nd floor),Block-E,Lalmatia,Dhaka 1205</li>
                      <li><a>www.inayatlighting.com</a></li>
                      <li><b>Hotline :01810 457 457</b></li>
                    </ul>
                  </div>
                  <div style="color: #000; width: 2%"></div>
                  <div style="color: #000; width: 32%">
                    <ul class="px-0 list-unstyled" style="color: #000">
                      <li style="text-decoration: overline dotted;"><b>{{ $account->name }}</b></li>
                      <li>{{ $account->role ? $account->role->role_name : '' }}</li>
                      <li>INAYAT TRADING</li>
                      <li>{{ $account->phone }}</li>
                      <li>House-6/20 (2nd floor),Block-E,Lalmatia,Dhaka 1205</li>
                      <li><a>www.inayatlighting.com</a></li>
                      <li><b>Hotline :01810 457 457</b></li>
                    </ul>
                  </div>
                  <div style="color: #000; width: 2%"></div>
                  <div style="color: #000; width: 32%">
                    <ul class="px-0 list-unstyled" style="color: #000">
                      <li style="text-decoration: overline dotted;"><b>{{$sale->customer ? $sale->customer->customer_name : ''}}</b></li>
                      <li>{{$sale->customer ? $sale->customer->designation : ''}}</li>
                      <li>{{$sale->customer ? $sale->customer->company_name : ''}}</li>
                      <li>{{$sale->customer ? $sale->customer->phone : ''}}</li>
                      <li>{{$sale->customer ? $sale->customer->address : ''}}</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            {{-- <div class="footer-image">
              <img src="/pad3.png" width="100%">
            </div> --}}
          </section>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection