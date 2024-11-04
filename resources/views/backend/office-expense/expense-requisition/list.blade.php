@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Expense Requisition List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Expense Requisition</li>
                    <li class="breadcrumb-item active">List</li>
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
                    @isset(auth()->user()->role->permission['permission']['expense-requisition']['create'])
                    <a href="{{route('expense.requisition.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Expense Requisition</a>
                    @endisset
                </div>

                <form method="get" action="{{route('expense.requisition.search')}}">
                    <div class="row mb-3">
                        <div class="col-md-3 col-12">
                            <label>Head: </label>
                            <select class="custom-select select2" name="head_id" id="head_id" onchange="getSubHead()">
                                <option value="">Select One</option>
                                @foreach($heads as $head)
                                <option value="{{$head->id}}" {{$head->id == $search_head ? 'selected' : ''}}>{{$head->head_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-12">
                            <label>Expense Sub Head</label>
                            <select class="custom-select select2" name="subhead_id" id="subhead_id">
                                <option value="">Select One</option>
                                @if($subhead)
                                <option value="{{$subhead->id}}" {{$subhead->id == $search_subhead ? 'selected' : ''}}>{{$user->subhead_name}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3 col-12">
                            <label>Accessor: </label>
                            <select class="custom-select select2" name="user_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{$user->id == $search_user ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-12 mt-auto">
                            <input type="submit" class="btn btn-info" value="Search">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Requisition</th>
                                <th>Date</th>
                                <th>Head Name</th>
                                <th>Accessor Name</th>
                                <th>Req. Amount</th>
                                <th>Approved Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_expense as $expense)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$expense->requisition}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($expense->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$expense->head ? $expense->head->head_name : ''}} <br> {{$expense->subhead ? $expense->subhead->subhead_name : ''}}</td>
                                <td>{{$expense->accessor ? $expense->accessor->name : ''}} </td>
                                <td>{{$expense->request_amount}} </td>
                                <td>{{$expense->amount}} </td>
                                <td>
                                    @if($expense->status == 0)
                                    <span class="text-warning">
                                        Pending
                                    </span>
                                    @else
                                    <span class="text-success">
                                        Approved
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @isset(auth()->user()->role->permission['permission']['expense-requisition']['approved'])
                                        @if($expense->status == 0)
                                            <a href="{{ route('expense.requisition.approved',$expense->id) }}" class="btn btn-warning btn-sm mb-2 waves-effect waves-light">Approved</a>
                                        @endif
                                    @endisset
                                    <form action="{{ route('expense.requisition.destroy', $expense->id) }}" method="post"
                                        accept-charset="utf-8">

                                        @if(Auth::user()->role_id == 1)
                                            @if($expense->status != 1)
                                            <a href="{{ route('expense.requisition.adjustment', $expense->id) }}"
                                                class="btn btn-sm btn-info" title="Adjustment">
                                                <i class="mdi mdi-adjust"></i>
                                            </a>
                                            @endif
                                        @endif
                                        @isset(auth()->user()->role->permission['permission']['expense-requisition']['edit'])
                                        <a href="{{ route('expense.requisition.edit', $expense->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['expense-requisition']['destroy'])
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
                    {{ $all_expense->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
@section('script')
    <script type="text/javascript">
        function getSubHead() {
            let id = $("#head_id").val();
            let url = '/admin/expense-requisition/subhead/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    let html = '';
                    console.log(response)
                    html += `<option value="">` + 'Select One' + `</option>`
                    response.forEach(element => {
                        html += '<option value=' + element.id + '>' + element.subhead_name +
                            '</option>'
                    });
                    $("#subhead_id").html(html);
                }
            });
        }
    </script>
@endsection