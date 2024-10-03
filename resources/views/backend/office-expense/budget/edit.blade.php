@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Update Employee Budget</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item active">Update Budget</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['budget']['index'])
        <a href="{{route('budget.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Budget List</a>
        @endisset
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('budget.update', $budget->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Date *</label>
                            <input type="date" class="form-control" id="validationCustom01" name="date" value="{{$budget->date}}" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Method *</label>
                            <select class="custom-select select2" required="" name="method_id" id="method_id" onchange="getAccount()">
                                <option value="">Select One</option>
                                @foreach($methods as $method)
                                <option value="{{$method->id}}" {{$method->id == $budget->method_id ? 'selected' : ''}}>{{$method->method_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Account *</label>
                            <select class="custom-select select2" name="account_id" id="account_id" required>
                                <option value="">Select One</option>
                                @if($account)
                                <option value="{{$account->id}}" selected>{{$account->account_name}}</option>
                                @endif
                            </select>
                        </div>
                        @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12)
                        <div class="col-md-4 mb-3">
                            <label>Employee Name *</label>
                            <select class="custom-select select2" @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12) required="" @endif name="employee_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{$user->id == $budget->employee_id ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Budget Amount *</label>
                            <input type="number" class="form-control" id="validationCustom01" value="{{$budget->amount}}" placeholder="Budget Amount" name="amount" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Purpose</label>
                            <input type="text" class="form-control" id="validationCustom01" value="{{$budget->purpose}}" placeholder="Budget Purpose" name="purpose">
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
