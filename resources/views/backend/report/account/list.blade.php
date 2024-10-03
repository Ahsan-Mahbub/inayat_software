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
                <h4 class="mb-0 font-size-18">Budget & Expense Report</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Budget & Expense</li>
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
                        @if($employee_id)
                        <strong class="d-block">Employee Name : {{$user->name}}</strong>
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


                    @php
                        $total_budget_amount = 0;
                    @endphp
                    @isset($all_budget)
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <table class="table table-bordered table-striped text-center">
                                    <tr>
                                        <th colspan="4" class="text-center">Budget Histories</th>
                                    </tr>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Date</th>
                                        <th>Purpose</th>
                                        <th>Budget</th>
                                    </tr>
                                    @if(count($all_budget) > 0)
                                        @foreach ($all_budget as $item)
                                            @php
                                                $total_budget_amount = $total_budget_amount + $item->amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d-F-Y', strtotime($item->date ?? '')) }}</td>
                                                <td>{!! $item->purpose !!}</td>
                                                <td>{{ $item->amount ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        
                                        <tr>
                                            <th colspan="3" class="text-right">Grand Total</th>
                                            <th>TK. {{ $total_budget_amount }}</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-danger h4">Item Not Found</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endisset

                    @php
                        $total_expense_amount = 0;
                    @endphp
                    @isset($all_expense)
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <table class="table table-bordered table-striped text-center">
                                    <tr>
                                        <th colspan="4" class="text-center">Expense Histories</th>
                                    </tr>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Expense</th>
                                    </tr>
                                    @if(count($all_expense) > 0 )
                                        
                                        @foreach ($all_expense as $item)
                                            @php
                                                $total_expense_amount = $total_expense_amount + $item->amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d-F-Y', strtotime($item->date ?? '')) }}</td>
                                                <td>{!! $item->reason !!}</td>
                                                <td>{{ $item->amount ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="3" class="text-right">Grand Total</th>
                                            <th>TK. {{$total_expense_amount}}</th>
                                        </tr>
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center text-danger h4">Item Not Found</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endisset

                    @isset($all_budget)
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th class="text-right">Total Budget Amount</th>
                                    <th class="text-right">{{$total_budget_amount}}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th class="text-right">Total Expense Amount</th>
                                    <th class="text-right">{{$total_expense_amount}}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th class="text-right">Extra Balance</th>
                                    <th class="text-right">{{$total_budget_amount - $total_expense_amount}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection