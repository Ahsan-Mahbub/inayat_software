@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Update Office Expense</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Expense</li>
                    <li class="breadcrumb-item active">Update Expense</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['expense']['index'])
        <a href="{{route('expense.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Expense List</a>
        @endisset
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('expense.update', $expense->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Date *</label>
                            <input type="date" class="form-control" id="validationCustom01" name="date" value="{{$expense->date}}" required="">
                        </div>
                        {{-- <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Expense Requisition</label>
                            <input type="text" class="form-control" disabled value="{{$expense->requisition ? $expense->requisition->requisition : ''}}">
                        </div> --}}

                        @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12)
                        <div class="col-md-4 mb-3">
                            <label>Employee Name *</label>
                            <select class="custom-select select2" @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12) required="" @endif name="employee_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{$user->id == $expense->employee_id ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-4 mb-3">
                            <label>Expense Head *</label>
                            <select class="custom-select select2" required="" name="head_id" id="head_id" onchange="getSubHead()">
                                <option value="">Select One</option>
                                @foreach($heads as $head)
                                <option value="{{$head->id}}" {{$expense->head_id == $head->id ? 'selected' : ''}}>{{$head->head_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Expense Sub Head</label>
                            <select class="custom-select select2" name="subhead_id" id="subhead_id">
                                <option value="">Select One</option>
                                @if($subhead)
                                <option value="{{$subhead->id}}" selected>{{$subhead->subhead_name}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Expense Amount *</label>
                            <input type="number" class="form-control" id="validationCustom01" value="{{$expense->amount}}" placeholder="Expense Amount" name="amount" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="d-block">Reason</label>
                            <textarea id="elm1" name="reason" placeholder="Expense Reason">{{$expense->reason}}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Image </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-group" name="image"
                                    onchange="readURL(this);" />
                                <img id="file_image" src="{{ $expense->image ? '/' . $expense->image : '/demo.svg' }}" class="pt-2" height="200" width="auto"
                                    alt="expense" /><br>
                            </div>
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#file_image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
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
