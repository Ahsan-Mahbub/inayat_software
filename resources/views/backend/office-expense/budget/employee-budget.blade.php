@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Employee Budget List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item active">Employee Budget List</li>
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
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Employee Name</th>
                                <th>Total Budget</th>
                                <th>Total Expense</th>
                                <th>Now Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                                $total_budget = 0;
                                $total_expense = 0;
                            @endphp
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>{{$employee->name}}</td>
                                <?php
                                    $budget = App\Models\Budget::where('employee_id', $employee->id)->sum('amount');
                                    $expense = App\Models\Expense::where('employee_id', $employee->id)->sum('amount');
                                    $total_budget += $budget;
                                    $total_expense += $expense;
                                ?>
                                <td>{{$budget}} </td>
                                <td>{{$expense}} </td>
                                <td>{{$budget - $expense}}</td>
                                <td width="20%">
                                    <a href="{{route('budget.employee.history',$employee->id)}}" class="btn btn-primary btn-sm mr-2 mb-2">Budget</a>
                                    <a href="{{route('expense.employee.history',$employee->id)}}" class="btn btn-dark btn-sm mr-2 mb-2">Expense</a>
                                    <a href="{{route('budget.employee.monthly',$employee->id)}}" class="btn btn-info btn-sm">Monthly Summary</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="width: 35%; float: right;">
                        <table class="table">
                            <tbody>
                                <tr class="bg-grey bg-lighten-4">
                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                        colspan="7" class="text-bold-800"><b>Total Budget</b></td>
                                    <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                        <b>{{ $total_budget }} /-</b>
                                    </td>
                                </tr>
                                <tr class="bg-grey bg-lighten-4">
                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                        colspan="7" class="text-bold-800"><b>Total Expense</b></td>
                                    <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                        <b>{{ $total_expense }} /-</b>
                                    </td>
                                </tr>
                                <tr class="bg-grey bg-lighten-4">
                                    <td style="border: 2px solid #3e3e3e; width: 65%; padding: 3px; text-align: right"
                                        colspan="7" class="text-bold-800"><b>Bow Balance</b></td>
                                    <td style="border: 2px solid #3e3e3e; text-align: center; padding: 3px;">
                                        <b>{{ $total_budget - $total_expense }} /-</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection