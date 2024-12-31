@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add Office Expense</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Expense</li>
                    <li class="breadcrumb-item active">Add Expense</li>
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
                <form class="needs-validation" novalidate="" action="{{route('expense.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Date *</label>
                            <input type="date" class="form-control" id="validationCustom01" name="date" required="">
                        </div>

                        @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12)
                        <div class="col-md-4 mb-3">
                            <label>Employee Name *</label>
                            <select class="custom-select select2" onchange="getRequisition()" @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 12) required="" @endif name="employee_id" id="employee_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        {{-- <div class="col-md-4 mb-3">
                            <label>Expense Requisition *</label>
                            <select class="custom-select select2" name="requisition_id" id="requisition_id" required>
                                <option value="">Select One</option>
                            </select>
                        </div> --}}

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
                            <label for="validationCustom01">Expense Amount *</label>
                            <input type="number" class="form-control" id="amount" placeholder="Expense Amount" name="amount" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="d-block">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" placeholder="Expense Reason"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Image </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-group" name="image"
                                    onchange="readURL(this);" />
                                <img id="file_image" src="/demo.svg" class="pt-2" height="200" width="auto"
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
        function getRequisition() {
            let id = $("#employee_id").val();
            let url = '/admin/expense/requisition/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    let html = '';
                    html += `<option value="">` + 'Select One' + `</option>`
                    response.forEach(element => {
                        html += '<option value=' + element.id + '>' + element.requisition +
                            '</option>'
                    });
                    $("#requisition_id").html(html);
                }
            });
        }

        $(document).on('change', '#requisition_id', function(e){
            var requisition_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-expense-requisition-details') }}",
                type: "post",
                data: {requisition_id:requisition_id},
                dataType: "json",
                success: function (response) {
                    $('#head_id').val(response.head_id);
                    $('#subhead_id').val(response.subhead_id);
                    $('#amount').val(response.amount);
                    $('#reason').val(response.reason);
                }
            });
        });
    </script>
@endsection
