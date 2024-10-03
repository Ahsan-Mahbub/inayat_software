@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Purchase Return</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Purchase Return</li>
                        <li class="breadcrumb-item active">Add Purchase Return</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 text-right mb-4">
            @isset(auth()->user()->role->permission['permission']['purchase-return']['index'])
            <a href="{{route('purchase.return.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Purchase Return List</a>
            @endisset
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" action="{{route('purchase.return.invoice')}}" method="get">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-3">
                                <label>Supplier Name</label>
                                <select class="custom-select select2" required="" name="supplier_id" id="supplier_id" onchange="getSupplierInvoice()">
                                    <option value="">Select One</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }} @if($supplier->phone) - {{$supplier->phone}} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Invoice</label>
                                <select class="custom-select select2" required="" name="purchase_id" id="purchase_id">
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
    function getSupplierInvoice() {
            let id = $("#supplier_id").val();
            let url = '/admin/purchase-return/invoice/' + id;
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
                    $("#purchase_id").html(html);
                }
            });
        }
    </script> 
@endsection