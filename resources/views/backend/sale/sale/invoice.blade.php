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
                <h4 class="mb-0 font-size-18">Sale : {{ $sale->invoice }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Sale</li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mb-3">
        <button type="button" class="btn btn-info" onclick="printableContent('printableContent')">
            <i class="mdi mdi-printer-check"></i>Print Invoice
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <section class="card p-3" id="printableContent" style="background-color: transparent;">
                <div class="card-body">
                    <div class="bg-header" style="margin-bottom: 20px">
                        <img src="/bg.png" style="width: 100%;">
                    </div>
                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-md-12" style="color: #000">
                            <span style="display: block; margin-bottom: 2px">{{ $sale->invoice }}</span>
                            <span
                                style="display: block; margin-bottom: 2px">{{ $sale->requisition ? $sale->requisition->requisition_number : '' }}</span>
                            <?php
                                $timestamp = strtotime($sale->date);
                                $date = date('j-M-y', $timestamp);
                            ?>
                            {{$date}}
                            <ul class="px-0 list-unstyled" style="color: #000">
                                <li style="margin-top: 5px">To</li>
                                <li><b>{{ $sale->customer ? $sale->customer->customer_name : 'N/A' }}</b></li>
                                <li>{{ $sale->customer ? $sale->customer->designation : 'N/A' }}</li>
                                <li>{{ $sale->customer ? $sale->customer->company_name : 'N/A' }}</li>
                                <li>{{ $sale->customer ? $sale->customer->address : 'N/A' }}</li>
                            </ul>
                        </div>
                        <div class="col-12">
                            <span style="color: #000">Dear Sir/Madam,</span>
                            <p style="color: #000">We are pleased to submit the following invoice as per requirement for
                                your kind considaration</p>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->
                    <div class="price-box"
                        style="background-color: #b1b0b0!important; padding: 2px; text-align: center; font-weight: bold; color: #000; border: 2px solid #000">
                        <span style="font-size: 22px;">Invoice</span>
                    </div>
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table" style="color: #000">
                                    <thead>
                                        <tr>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">
                                                SL</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 13%;">
                                                Name/Code</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 19%">
                                                Product Image</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">
                                                Product Description</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">
                                                Unit</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center">
                                                QTY</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 12%;">
                                                Unit Price</th>
                                            <th
                                                style="border: 2px solid #3e3e3e; vertical-align: middle; font-size: 17px; font-weight: 600; padding: 3px; text-align: center; width: 12%;">
                                                Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sl = 1;
                                        @endphp
                                        @foreach ($products as $product)
                                            <tr>
                                                <th style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;"
                                                    scope="row">{{ $sl++ }}</th>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                                                    {{ $product->product ? $product->product->product_name : 'N/A' }}
                                                </td>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                                                    @if ($product->product)
                                                        <img src="/{{ $product->product->image }}" width="200">
                                                    @else
                                                        <img src="/demo.svg" width="100">
                                                    @endif
                                                </td>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px;">
                                                    {!! $product->product ? $product->product->description : 'N/A' !!}
                                                </td>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align: center">
                                                    {{ $product->unit ? $product->unit->unit_name : 'N/A' }}
                                                </td>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align:center">
                                                    {{ $product->qty }}</td>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align:center">
                                                    @if($product->qty > 0)
                                                        {{ $product->amount / $product->qty }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td
                                                    style="border: 2px solid #3e3e3e; vertical-align: middle; padding: 3px; text-align:center">
                                                    {{ $product->amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="width: 100%">
                            <div style="display: flex;">
                                <div style="width: 65%">
                                    <b style="color: #000; text-transform: capitalize">In Words : </b> <b
                                        style="color: #000;"><?php echo numberToWords(intval($sale->total_amount)); ?> Taka</b>
                                    @if ($info->trams_condition)
                                        <b style="color: #000; text-transform: capitalize;display: block; margin-top: 5px">
                                            Terms and Condition : </b></b>
                                        <div>
                                            {!! $info->trams_condition !!}
                                        </div>
                                    @endif
                                </div>
                                <div style="width: 2%"></div>
                                <div style="width: 33%">
                                    <table class="table" style="color: #000">
                                        <tbody>
                                            @if ($sale->discount || $sale->vat || $sale->tax || $sale->ait)
                                                <tr>
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7"><b>Sub Total</b></td>
                                                    <td
                                                        style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        <b>{{ number_format($sale->subtotal, 2, '.', '') }}/-</b>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($sale->discount)
                                                <tr>
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7">Discount {{ $sale->discount }} @if ($sale->percentage)
                                                            %
                                                        @endif
                                                    </td>
                                                    <td
                                                        style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        {{ number_format($sale->subtotal - $sale->discount_price, 2, '.', '') }}/-
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7" class="text-bold-800">After Discount Amount</td>
                                                    <td
                                                        style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        {{ number_format($sale->discount_price, 2, '.', '') }}/-</td>
                                                </tr>
                                            @endif
                                            @if ($sale->vat)
                                                <tr>
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7">VAT {{ $sale->vat }} %</td>
                                                    <td
                                                        style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        {{ number_format($sale->vat_amount, 2, '.', '') }}/-</td>
                                                </tr>
                                            @endif
                                            @if ($sale->tax)
                                                <tr>
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7">TAX {{ $sale->tax }} %</td>
                                                    <td
                                                        style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        {{ number_format($sale->tax_amount, 2, '.', '') }}/-</td>
                                                </tr>
                                            @endif
                                            @if ($sale->ait)
                                                <tr>
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7">AIT {{ $sale->ait }} %</td>
                                                    <td
                                                        style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        {{ number_format($sale->ait_amount, 2, '.', '') }}/-</td>
                                                </tr>
                                            @endif
                                            <tr class="bg-grey bg-lighten-4">
                                                <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                    colspan="7" class="text-bold-800"><b>Total Amount</b></td>
                                                <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                    <b>{{ number_format($sale->total_amount, 2, '.', '') }}/-</b>
                                                </td>
                                            </tr>
                                            @if(count($sale_transaction) > 0)
                                                @foreach($sale_transaction as $transaction)
                                                <tr class="bg-grey bg-lighten-4">
                                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                        colspan="7" class="text-bold-800">
                                                        Paid Amount <br>
                                                        <?php
                                                            $timestamp = strtotime($transaction->date);
                                                            $date = date('d-m-Y', $timestamp);
                                                        ?>
                                                        {{$date}}
                                                    </td>
                                                    <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                        {{ number_format($transaction->amount, 2, '.', '') }}/-
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            {{-- <tr class="bg-grey bg-lighten-4">
                                                <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                    colspan="7" class="text-bold-800">Paid Amount</td>
                                                <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                    {{ number_format($sale->paid_amount, 2, '.', '') }}/-
                                                </td>
                                            </tr> --}}
                                            <?php
                                                $return = App\Models\SaleReturn::where('sale_id', $sale->id)->sum('amount');
                                            ?>
                                            @if($return > 0)
                                            <tr class="bg-grey bg-lighten-4">
                                                <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                    colspan="7" class="text-bold-800">Return Amount</td>
                                                <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                    {{ number_format($return, 2, '.', '') }}/-
                                                </td>
                                            </tr>
                                            @endif
                                            @if($sale->adjustment_amount > 0)
                                            <tr class="bg-grey bg-lighten-4">
                                                <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                    colspan="7" class="text-bold-800">Adjustment Amount</td>
                                                <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                    {{ number_format($sale->adjustment_amount, 2, '.', '') }}/-
                                                </td>
                                            </tr>
                                            @endif
                                            <tr class="bg-grey bg-lighten-4">
                                                <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                                    colspan="7" class="text-bold-800"><b>Due Amount</b></td>
                                                <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                                    <b>{{ number_format(($sale->due_amount - $return - $sale->adjustment_amount), 2, '.', '') }}/-</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div style="margin-top: 150px; display: flex">
                            <div style="color: #000; width: 32%">
                                <ul class="px-0 list-unstyled" style="color: #000">
                                    <li style="text-decoration: overline dotted;">
                                        <b>{{ $sale->creator ? $sale->creator->name : 'N/A' }}</b>
                                    </li>
                                    <li>{{ $sale->creator ? $sale->creator->role->role_name : 'N/A' }}</li>
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
                                    <li style="text-decoration: overline dotted;">
                                        <b>{{ $sale->customer ? $sale->customer->customer_name : '' }}</b>
                                    </li>
                                    <li>{{ $sale->customer ? $sale->customer->designation : '' }}</li>
                                    <li>{{ $sale->customer ? $sale->customer->company_name : '' }}</li>
                                    <li>{{ $sale->customer ? $sale->customer->phone : '' }}</li>
                                    <li>{{ $sale->customer ? $sale->customer->address : '' }}</li>
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
