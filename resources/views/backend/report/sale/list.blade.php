@extends('backend.layouts.app')
@section('content')
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
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Sale Report</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Sale</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mb-3">
        <button type="button" class="btn btn-info" onclick="printableContent('printableContent')">
            <i class="mdi mdi-printer-check"></i>Print Report
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card" id="printableContent">
                <div class="card-body">
                    <div class="bg-header" style="margin-bottom: 20px">
                        <img src="/bg.png" style="width: 100%;">
                    </div>
                    <div class="text-center pt-2 pb-4">
                        @if($customer_id)
                        <strong class="d-block">Client Name : {{$customer->customer_name}}</strong>
                        @endif
                        @if($creator_id)
                        <strong class="d-block">Creator / Employee Name : {{$user->name}}</strong>
                        @endif
                        @if($form_date && $to_date)
                        <strong class="d-block">Date : 
                            <?php
                                $timestamp = strtotime($form_date);
                                $f_date = date('d-m-Y', $timestamp);
                            ?>
                            {{ $f_date }} to 
                            <?php
                                $timestamp = strtotime($to_date);
                                $t_date = date('d-m-Y', $timestamp);
                            ?>
                            {{ $t_date }}
                        </strong>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Seller</th>
                                    <th>Invoice</th>
                                    <th>Quotation</th>
                                    <th>Client Name</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Adjustment Amount</th>
                                    <th>Due Amount</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                    $total_amount = 0;
                                    $total_paid_amount = 0;
                                    $total_due_amount = 0;
                                    $total_adjustment_amount = 0;
                                @endphp
                                @foreach($all_sale as $sale)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            <?php
                                                $timestamp = strtotime($sale->date);
                                                $date = date('d-m-Y', $timestamp);
                                                $total_amount += $sale->total_amount;
                                                $total_paid_amount += $sale->paid_amount;
                                                $total_adjustment_amount += $sale->adjustment_amount;
                                            ?>
                                            {{$date}}
                                        </td>
                                        <td>{{$sale->creator ? $sale->creator->name : 'N/A'}}</td>
                                        <td>{{$sale -> invoice}}</td>
                                        <td>{{$sale->requisition ? $sale->requisition->requisition_number : 'N/A'}}</td>
                                        <td>{{$sale->customer ? $sale->customer->customer_name : 'N/A'}}</td>
                                        <td>{{$sale -> total_amount}}</td>
                                        <td>{{$sale -> paid_amount}}</td>
                                        <td>{{$sale -> adjustment_amount}}</td>
                                        <?php
                                            $return = App\Models\SaleReturn::where('sale_id', $sale->id)->sum('amount');
                                        ?>
                                        <td>
                                            {{($sale->due_amount - $return) - $total_adjustment_amount}}
                                            <?php
                                                $total_due_amount += ($sale->due_amount - $return) - $total_adjustment_amount;
                                            ?>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-right" colspan="6">Total Amount</td>
                                    <td>{{$total_amount}}</td>
                                    <td>{{$total_paid_amount}}</td>
                                    <td>{{$total_adjustment_amount}}</td>
                                    <td>{{$total_due_amount}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
