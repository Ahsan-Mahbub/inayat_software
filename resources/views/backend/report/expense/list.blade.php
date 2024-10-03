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
                <h4 class="mb-0 font-size-18">Expense Report</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Expense</li>
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
                        @if($head_id)
                        <strong class="d-block">Expense Head : {{$head->head_name}}</strong>
                        @endif
                        @if($subhead_id)
                        <strong class="d-block">Expense Sub Head : {{$subhead->subhead_name}}</strong>
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
                                    <th>Expense Image</th>
                                    <th>Date</th>
                                    <th>Head Name</th>
                                    <th>Employee Name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach($all_expense as $expense)
                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td><img style="width: auto; height: 100px;"
                                        src="{{ $expense->image ? '/' . $expense->image : '/demo.svg' }}"></td>
                                    <td>
                                        <?php
                                            $timestamp = strtotime($expense->date);
                                            $date = date('d-m-Y', $timestamp);
                                        ?>
                                        {{$date}}
                                    </td>
                                    <td>{{$expense->head ? $expense->head->head_name : ''}} <br> {{$expense->subhead ? $expense->subhead->subhead_name : ''}}</td>
                                    <td>{{$expense->employee ? $expense->employee->name : ''}} </td>
                                    <td>{{$expense->amount}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection