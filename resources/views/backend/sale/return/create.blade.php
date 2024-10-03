@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Sale Return</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Sale Return</li>
                        <li class="breadcrumb-item active">Add Sale Return</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 text-right mb-4">
            @isset(auth()->user()->role->permission['permission']['sale-return']['index'])
            <a href="{{route('sale.return.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Sale Return List</a>
            @endisset
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" action="{{route('sale.return.invoice')}}" method="get">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-3">
                                <label>Customer Name</label>
                                <select class="custom-select select2" required="" name="customer_id" id="customer_id" onchange="getcustomerInvoice()">
                                    <option value="">Select One</option>
                                    @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{ $customer->customer_name }} @if($customer->phone) - {{$customer->phone}} @endif @if($customer->company_name) - {{$customer->company_name}} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Invoice</label>
                                <select class="custom-select select2" required="" name="sale_id" id="sale_id">
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
    function getcustomerInvoice() {
            let id = $("#customer_id").val();
            let url = '/admin/sale-return/invoice/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    let html = '';
                    html += `<option value="">` + 'Select One' + `</option>`
                    response.forEach(element => {
                        html += '<option value=' + element.id + '>' + element.invoice +
                            '</option>'
                    });
                    $("#sale_id").html(html);
                }
            });
        }
    </script> 
@endsection