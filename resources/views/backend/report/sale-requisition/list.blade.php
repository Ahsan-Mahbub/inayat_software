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
                <h4 class="mb-0 font-size-18">Sale Quotation Report</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Sale Quotation</li>
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
                                    $total_amount = 0;
                                @endphp
                                @foreach ($all_requisition as $requisition)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            <?php
                                            $timestamp = strtotime($requisition->date);
                                            $date = date('d-m-Y', $timestamp);
                                            $total_amount += $requisition->total_amount;
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
                                <tr>
                                    <td colspan="6" class="text-right">Total Sale Quotation Amount</td>
                                    <td>{{$total_amount}}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection