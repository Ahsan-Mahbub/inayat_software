@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Budget List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Budget</li>
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
                    @isset(auth()->user()->role->permission['permission']['budget']['create'])
                    <a href="{{route('budget.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Budget</a>
                    @endisset
                </div>

                <form method="get" action="{{route('budget.search')}}">
                    <div class="row mb-3">
                        <div class="col-md-3 col-12">
                            <label>Method: </label>
                            <select class="custom-select select2" name="method_id" id="method_id" onchange="getAccount()">
                                <option value="">Select One</option>
                                @foreach($methods as $method)
                                <option value="{{$method->id}}" {{$method->id == $search_method ? 'selected' : ''}}>{{$method->method_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-12">
                            <label>Account</label>
                            <select class="custom-select select2" name="account_id" id="account_id">
                                <option value="">Select One</option>
                                @if($account)
                                <option value="{{$account->id}}" {{$account->id == $search_account ? 'selected' : ''}}>{{$user->account_name}}</option>
                                @endif
                            </select>
                        </div>
                        @if(Auth::user()->role_id != 11)
                        <div class="col-md-3 col-12">
                            <label>Employee: </label>
                            <select class="custom-select select2" name="user_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{$user->id == $search_user ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
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
                                <th>Date</th>
                                <th>Method/Account</th>
                                <th>Employee Name</th>
                                <th>Amount</th>
                                <th>Purpose</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_budget as $budget)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($budget->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$budget->method ? $budget->method->method_name : ''}} <br> {{$budget->account ? $budget->account->account_name : ''}}</td>
                                <td>{{$budget->employee ? $budget->employee->name : ''}} </td>
                                <td>{{$budget->amount}} </td>
                                <td>{{$budget->purpose}} </td>
                                <td>
                                    <form action="{{ route('budget.destroy', $budget->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['budget']['edit'])
                                        <a href="{{ route('budget.edit', $budget->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['budget']['destroy'])
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
                    {{ $all_budget->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
@section('script')
    <script type="text/javascript">
        function getAccount() {
            let id = $("#method_id").val();
            let url = '/admin/data-get/account/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    let html = '';
                    html += '<option value="">Please select</option>'
                    response.forEach(element => {
                        html += '<option value=' + element.id + '>' + element.account_name + '</option>'
                    });
                    $("#account_id").html(html);

                }
            });
        }
    </script>
@endsection