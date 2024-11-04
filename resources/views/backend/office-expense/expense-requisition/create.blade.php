@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add Expense Requisition</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Expense Requisition</li>
                    <li class="breadcrumb-item active">Add Expense Requisition</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['expense-requisition']['index'])
        <a href="{{route('expense.requisition.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Expense Requisition List</a>
        @endisset
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('expense.requisition.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Date *</label>
                            <input type="date" class="form-control" id="validationCustom01" name="date" required="">
                        </div>

                        @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12)
                        <div class="col-md-4 mb-3">
                            <label>Employee Name *</label>
                            <select class="custom-select select2" @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12) required="" @endif name="accessor_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-4 mb-3">
                            <label>Expense Head *</label>
                            <select class="custom-select select2" required="" name="head_id" id="head_id" onchange="getSubHead()">
                                <option value="">Select One</option>
                                @foreach($heads as $head)
                                <option value="{{$head->id}}">{{$head->head_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Expense Sub Head</label>
                            <select class="custom-select select2" name="subhead_id" id="subhead_id">
                                <option value="">Select One</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Request Amount *</label>
                            <input type="number" class="form-control" id="validationCustom01" placeholder="Request Amount" name="request_amount" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="d-block">Reason</label>
                            <textarea id="elm1" name="reason" placeholder="Expense Reason"></textarea>
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
