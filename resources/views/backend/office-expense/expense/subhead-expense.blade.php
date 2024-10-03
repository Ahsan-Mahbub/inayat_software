@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$subhead->subhead_name}} - Expense</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Expense</li>
                    <li class="breadcrumb-item active">Sub Head List</li>
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
                    @isset(auth()->user()->role->permission['permission']['expense']['create'])
                    <a href="{{route('expense.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Expense</a>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Expense Image</th>
                                <th>Date</th>
                                <th>Head Name</th>
                                <th>Employee Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($subhead_expense as $expense)
                            <tr>
                                <td>{{$startingSerial++}}</td>
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
                                <td>
                                    <form action="{{ route('expense.destroy', $expense->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['expense']['edit'])
                                        <a href="{{ route('expense.edit', $expense->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['expense']['destroy'])
                                        <button type="submit"
                                            class="btn btn-sm btn-danger delete-confirm">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                        @endisset
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $subhead_expense->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection