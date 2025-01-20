@extends('backend.layouts.app')
@section('content')
<?php
    $monthNumber = date('m');
    $monthName = DateTime::createFromFormat('!m', $monthNumber)->format('F');
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$employee->name}} - {{$monthName}} Budget & Expense</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item active">Employee {{$monthName}} Budget & Expense</li>
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
                    @isset(auth()->user()->role->permission['permission']['budget']['create'])
                    <a href="{{route('budget.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Budget</a>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['expense']['create'])
                    <a href="{{route('expense.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Expense</a>
                    @endisset
                    <button type="button" class="btn btn-info btn-sm" onclick="printableContent('printableContent')">
                        <i class="mdi mdi-printer-check"></i>Print
                    </button>
                </div>
                <div id="printableContent">
                    @php
                        $total_budget_amount = 0;
                        $total_requisition_amount = 0;
                    @endphp
                    @isset($budgets)
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <table class="table table-bordered table-striped text-center">
                                    <tr>
                                        <th colspan="4" class="text-center">{{$employee->name}} - {{$monthName}} - Budget Histories</th>
                                    </tr>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Date</th>
                                        <th>Purpose</th>
                                        <th>Budget</th>
                                    </tr>
                                    @if(count($budgets) > 0)
                                        @foreach ($budgets as $item)
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

                    @isset($expense_requisitions)
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <table class="table table-bordered table-striped text-center">
                                    <tr>
                                        <th colspan="4" class="text-center">{{$employee->name}} - {{$monthName}} - Expense Requisition Histories</th>
                                    </tr>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Budget</th>
                                    </tr>
                                    @if(count($expense_requisitions) > 0)
                                        @foreach ($expense_requisitions as $item)
                                            @php
                                                $total_requisition_amount = $total_requisition_amount + $item->amount;
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
                                            <th>TK. {{ $total_requisition_amount }}</th>
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
                    @isset($expenses)
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <table class="table table-bordered table-striped text-center">
                                    <tr>
                                        <th colspan="4" class="text-center">{{$employee->name}} - {{$monthName}} - Expense Histories</th>
                                    </tr>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Expense</th>
                                    </tr>
                                    @if(count($expenses) > 0 )
                                        
                                        @foreach ($expenses as $item)
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

                    @isset($budgets)
                    <div class="row justify-content-center">
                        <div class="col-md-6" style="width: 50%">
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th class="text-right">Last Month Closing Balance</th>
                                    <th class="text-right">{{$previous_amount}}</th>
                                </tr>
                                <tr>
                                    <th class="text-right">{{$monthName}} - Total Received Amount</th>
                                    <th class="text-right">{{$total_budget_amount}}</th>
                                </tr>
                                <tr>
                                    <th class="text-right">{{$monthName}} - Total Expense Requisition Amount</th>
                                    <th class="text-right">{{$total_requisition_amount}}</th>
                                </tr>
                                <tr>
                                    <th class="text-right">{{$monthName}} - Total Amount</th>
                                    <th class="text-right">{{$previous_amount + $total_budget_amount + $total_requisition_amount}}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6" style="width: 50%">
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th class="text-right">{{$monthName}} - Total Expense Amount</th>
                                    <th class="text-right">{{$total_expense_amount}}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6" style="width: 50%">
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th class="text-right">{{$monthName}} - Current Balance</th>
                                    <th class="text-right">{{$previous_amount + $total_budget_amount + $total_requisition_amount - $total_expense_amount}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection