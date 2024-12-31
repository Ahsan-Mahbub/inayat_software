@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Sample Request Return</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Sample Request Return</li>
                        <li class="breadcrumb-item active">Add Sample Request Return</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 text-right mb-4">
            @isset(auth()->user()->role->permission['permission']['sample-return']['index'])
            <a href="{{route('sample.return.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Sample Request Return List</a>
            @endisset
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" action="{{route('sample.return.invoice')}}" method="get">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-3">
                                <label>Creator Name</label>
                                <select class="custom-select select2" required="" name="creator_id" id="creator_id">
                                    <option value="">Select One</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{ $user->name }} @if($user->role) - {{$user->role->role_name}} @endif </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Customer Name</label>
                                <select class="custom-select select2" required="" name="customer_id" id="customer_id" onchange="getCustomerInvoice()">
                                    <option value="">Select One</option>
                                    @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{ $customer->customer_name }} @if($customer->phone) - {{$customer->phone}} @endif @if($customer->company_name) - {{$customer->company_name}} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Invoice</label>
                                <select class="custom-select select2" required="" name="request_id" id="request_id">
                                    <option value="">Select One</option>
                                </select>
                            </div>
                            <div class="col-md-4 m-auto">
                                <button class="btn btn-primary" type="submit">Find Return Invoice</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function getCustomerInvoice() {
        let id = $("#customer_id").val();
        let creator_id = $("#creator_id").val();
        
        if (!creator_id) {
            toastr.error("Please select a creator first.");
            return;
        }

        let url = `/admin/sample-return/invoice/${id}/${creator_id}`;
        
        $("#request_id").html('<option>Loading...</option>');

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                let html = '<option value="">Select One</option>';
                response.forEach(element => {
                    html += `<option value="${element.id}">${element.request_number}</option>`;
                });
                $("#request_id").html(html);
            },
            error: function(xhr, status, error) {
                toastr.error("Failed to fetch invoices. Please try again.");
                console.error("Error:", error);
            }
        });
    }
</script>

@endsection