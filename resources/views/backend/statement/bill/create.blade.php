@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Bill Wise Income Statement</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Bill Wise Income Statement</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" action="{{route('income-statement.bill')}}" method="get">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-3">
                                <label>Customer Name</label>
                                <select class="custom-select select2" required="" name="customer_id" id="customer_id" onchange="getcustomerInvoice()">
                                    <option value="">Select One</option>
                                    @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
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
                                <button class="btn btn-primary" type="submit">Find Bill Income</button>
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