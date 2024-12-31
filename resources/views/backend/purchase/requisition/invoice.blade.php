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
            <h4 class="mb-0 font-size-18">Quotation : {{$requisition->requisition_number}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Purchase Quotation</li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@if($requisition->status == 1)
<div class="text-right mb-3">
  <button type="button" class="btn btn-info" onclick="printableContent('printableContent')">
    <i class="mdi mdi-printer-check"></i>Print
  </button>
</div>
@endif
<div class="row">
  <div class="col-12">
    <section class="card p-3" id="printableContent" style="background-color: transparent;">
      <div class="card-body" style="background: #fff">
        <div id="print-box">

          <div class="bg-header" style="margin-bottom: 20px">
            <img src="/bg.png" style="width: 100%;">
          </div>
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
              <div class="col-md-12" style="color: #000">

                <span style="display: block; margin-bottom: 2px">{{$requisition->requisition_number}}</span>
                <?php
                    echo date('j-M-y');
                  ?>
                <ul class="px-0 list-unstyled" style="color: #000">
                  <li style="margin-top: 5px">To</li>
                  <li><b>{{$requisition->supplier ? $requisition->supplier->supplier_name : 'N/A'}}</b></li>
                  <li>{{$requisition->supplier ? $requisition->supplier->designation : 'N/A'}}</li>
                  <li>{{$requisition->supplier ? $requisition->supplier->company_name : 'N/A'}}</li>
                  <li>{{$requisition->supplier ? $requisition->supplier->address : 'N/A'}}</li>
                </ul>
              </div>
              <div class="col-12">
                <span style="color: #000">Dear Sir/Madam,</span>
                <p style="color: #000">We are pleased to submit the following purchase quotation as per requirement for your kind considaration.</p>
              </div>
            </div>
            <!--/ Invoice Company Details -->
            <div class="price-box" style="background-color: #b1b0b0!important; padding: 2px; text-align: center; font-weight: bold; color: #000; border: 2px solid #000">
              <span style="font-size: 22px;">Purchase Quotation</span>
            </div>
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-3">
              <div class="row">
                <div class="table-responsive col-sm-12">
                  <table class="table" style="color: #000">
                    <thead>
                      <tr>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">SL</th>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 13%;">Name/Code</th>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 19%">QR Code</th>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 19%">Product Image</th>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">Product Description</th>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">Unit</th>
                        <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">QTY</th>
                        {{-- <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 12%;">Unit Price</th> --}}
                        {{-- <th style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 12%;">Total Price</th> --}}
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
                          <?php
                            $qrcode_gen = $product->product ? $product->product->sku : 'N/A';
                          ?>
                          <div class="text-center">
                            {{ QrCode::generate($qrcode_gen) }}
                          </div>
                        </td>
                        <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                          @if($product->product)
                          <img src="/{{$product->product->image}}" width="220">
                          @else
                          <img src="/demo.svg" width="100">
                          @endif
                        </td>
                        <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                          {!! $product->product->description !!}
                        </td>
                        <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align: center">
                          {{$product->unit ? $product->unit->unit_name : 'N/A'}}
                        </td>
                        <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align: center">{{$product->qty}}</td>
                        {{-- <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align: center">{{number_format($product->amount / $product->qty, 2, '.', '')}}/-</td> --}}
                        {{-- <td style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align: center">{{number_format($product->amount, 2, '.', '')}}/-</td> --}}
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>


              <div style="width: 100%">
                <div style="display: flex;">
                  <div style="width: 100%">
                    {{-- <b style="color: #000; text-transform: capitalize">In Words : </b> <b style="color: #000;"><?php echo numberToWords(intval($requisition->total_amount)); ?> Taka</b> --}}
                    @if($info->requisition_trams_condition)
                    <b style="color: #000; text-transform: capitalize;display: block; margin-top: 5px"> Terms and Condition : </b></b>
                    <div>
                      {!! $info->requisition_trams_condition !!}
                    </div>
                    @endif
                  </div>
                  {{-- <div style="width: 2%"></div>
                  <div style="width: 33%">
                    <table class="table" style="color: #000">
                      <tbody>
                        <tr class="bg-grey bg-lighten-4">
                          <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right" colspan="7" class="text-bold-800"><b>Total Amount</b></td>
                          <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;"><b>{{number_format($requisition->total_amount, 2, '.', '')}}/-</b></td>
                        </tr>
                      </tbody>
                    </table>
                  </div> --}}
                </div>

              </div>
              
              <div class="row" style="margin-top: 150px">
                <div class="col-md-12" style="color: #000">
                  <ul class="px-0 list-unstyled" style="color: #000">
                    <li style="text-decoration: overline dotted;"><b>{{$requisition->creator ? $requisition->creator->name : 'N/A'}}</b></li>
                    @if($requisition->creator)
                    <li>{{$requisition->creator->role ? $requisition->creator->role->role_name : 'N/A'}}</li>
                    @endif
                    <li>INAYAT LIGHTING</li>
                    <li>{{$requisition->creator ? $requisition->creator->phone : 'N/A'}}</li>
                    <li>House-6/20 (2nd floor),Block-E,Lalmatia,Dhaka 1205</li>
                    <li><a>www.inayatlighting.com</a></li>
                    <li><b>Hotline :01810 457 457</b></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>        
      </div>
    </section>
  </div> <!-- end col -->
</div> <!-- end row -->


@endsection
