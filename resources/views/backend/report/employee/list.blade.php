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
                <h4 class="mb-0 font-size-18">Employee Sale & Purchase Report</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Employee Sale & Purchase</li>
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
                    @if(count($all_sale_requisition) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="8" class="text-center">Sale Quotation</th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Requisitor</th>
                                    <th>Editor</th>
                                    <th>Quotation Number</th>
                                    <th>Client Name</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($all_sale_requisition as $requisition)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            <?php
                                            $timestamp = strtotime($requisition->date);
                                            $date = date('d-m-Y', $timestamp);
                                            ?>
                                            {{ $date }}
                                        </td>
                                        <td>{{ $requisition->creator ? $requisition->creator->name : 'N/A' }}</td>
                                        <td>{{ $requisition->editor ? $requisition->editor->name : 'N/A' }}</td>
                                        <td>{{ $requisition->requisition_number }}</td>
                                        <td>{{ $requisition->customer ? $requisition->customer->customer_name : 'N/A' }}
                                        </td>
                                        <td>{{ $requisition->total_amount }}</td>
                                        <td>
                                            @if ($requisition->status == 0)
                                                <span class="text-info">
                                                    Pending
                                                </span>
                                                   
                                            @elseif ($requisition->status == 1)
                                                <span class="text-success">
                                                    Approved
                                                </span>
                                            @else
                                                <span class="text-danger">
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(count($all_sale) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="9" class="text-center">Sale</th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Seller</th>
                                    <th>Invoice</th>
                                    <th>Quotation</th>
                                    <th>Client Name</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach($all_sale as $sale)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
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
                                        <td>{{$sale -> total_amount}}</td>
                                        <td>{{$sale -> paid_amount}}</td>
                                        <?php
                                            $return = App\Models\SaleReturn::where('sale_id', $sale->id)->sum('amount');
                                        ?>
                                        <td>{{$sale -> due_amount - $return}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(count($all_requisition) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="6" class="text-center">Purchase Quotation</th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Requisitor</th>
                                    <th>Quotation Number</th>
                                    <th>Supplier Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach($all_requisition as $requisition)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            <?php
                                                $timestamp = strtotime($requisition->date);
                                                $date = date('d-m-Y', $timestamp);
                                            ?>
                                            {{$date}}
                                        </td>
                                        <td>{{$requisition->creator ? $requisition->creator->name : 'N/A'}}</td>
                                        <td>{{$requisition -> requisition_number}}</td>
                                        <td>{{$requisition->supplier ? $requisition->supplier->supplier_name : 'N/A'}}</td>
                                        <td>
                                            @if ($requisition->status == 0)
                                                <span class="text-info">
                                                    Pending
                                                </span>
                                            @elseif ($requisition->status == 1)
                                                <span class="text-success">
                                                    Approved
                                                </span>
                                            @else
                                                <span class="text-danger">
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(count($all_purchase) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="6" class="text-center">Purchase</th>
                                </tr>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Purchaser</th>
                                    <th>Requisition Number</th>
                                    <th>Invoice</th>
                                    <th>Supplier Name</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($all_purchase as $purchase)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            <?php
                                            $timestamp = strtotime($purchase->date);
                                            $date = date('d-m-Y', $timestamp);
                                            ?>
                                            {{ $date }}
                                        </td>
                                        <td>{{ $purchase->creator ? $purchase->creator->name : 'N/A' }}</td>
                                        <td>{{ $purchase->requisition ? $purchase->requisition->requisition_number : 'N/A' }}
                                        </td>
                                        <td>{{ $purchase->invoice }}</td>
                                        <td>{{ $purchase->supplier ? $purchase->supplier->supplier_name : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection