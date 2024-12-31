@extends('backend.layouts.app')
@section('content')
<style>
    .bg-primary-op {
        background-color: rgba(2, 132, 199, .75) !important;
    }
</style>
<?php
    $month = date('m');
    $monthName = DateTime::createFromFormat('!m', $month)->format('F');
    $year = date('Y');
    // $total_budget = App\Models\Budget::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
    // $total_expense = App\Models\Expense::where('status',1)->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');

    // $previous_amount = 0;
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$monthName}} Office Expense</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"> {{$monthName}} Office Expense</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row justify-content-center">
    <div class="col-md-3">
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th class="text-right">Previous Amount</th>
                <th class="text-right">{{$previous_amount}}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th class="text-right">{{$monthName}} - Total Budget Amount</th>
                <th class="text-right">{{$total_budget}}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th class="text-right">{{$monthName}} - Total Expense Amount</th>
                <th class="text-right">{{$total_expense}}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th class="text-right">{{$monthName}} - Now Balance</th>
                <th class="text-right">{{$total_budget - $total_expense}}</th>
            </tr>
        </table>
    </div>
</div> --}}
<div class="row">
    @foreach($heads as $head)
        <?php
            $total_head_amount = App\Models\Expense::where('head_id', $head->id)->where('status',1)->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
        ?>
        @if($total_head_amount > 0)
            <div class="col-12">
                <div class="card m-1" style="border: 2px solid #0d7f9c17;">
                    <div class="card-body" style="border-radius: 10px">
                        <h1 class="text-center font-size-18" style="font-weight: 600;">{{$head->head_name}} ({{$total_head_amount}})</h1>
                    </div>
                </div>
            </div>
            @foreach($head['subheads'] as $subhead)
                <div class="col-lg-3 col-md-3 pt-2 pb-2">
                    <div class="border text-center bg-primary-op p-1 block block-rounded block-transparent bg-image m-2 d-flex align-items-stretch h-60 mb-0" style="border-radius: 10px; background-image: url('https://img.freepik.com/free-photo/retro-living-room-interior-design_53876-145503.jpg?w=740&t=st=1710914039~exp=1710914639~hmac=12ecc23d56f6eb82c6455eb7b31396bfc973810c492519a42fd3ae237633845e');">
                        <a href="{{route('expense.subhead-expense', $subhead->id)}}">
                            <div class="row">
                                <div class="col-4">
                                    <img src="https://cdn.iconscout.com/icon/free/png-256/free-cost-icon-download-in-svg-png-gif-file-formats--expenses-budgeting-budget-business-projects-pack-icons-3704362.png" width="70%">
                                </div>
                                <?php
                                    $total_subhead_amount = App\Models\Expense::where('subhead_id', $subhead->id)->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
                                ?>
                                <div class="col-8 m-auto">
                                    <h5 class="font-size-15 text-white">{{$subhead->subhead_name}}</h5>
                                    <h5 class="font-size-16 text-white">{{$total_subhead_amount}} /-</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
</div> <!-- end row -->
@endsection