@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Purchase Qty Update</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Purchase</li>
                    <li class="breadcrumb-item active">Qty Update</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">

                <form method="get" action="{{route('purchase.product.qty')}}">
                    <div class="row mb-3">
                        <div class="col-md-12 col-12 pb-3">
                            <label>Product: *</label>
                            <select class="custom-select select2" name="product_id" required>
                                <option value="">Select One</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}" {{$product->id == $search_product ? 'selected' : ''}}>{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 col-12 pb-3">
                            <label>Unit: *</label>
                            <select class="custom-select select2" name="unit_id" required>
                                <option value="">Select One</option>
                                @foreach($units as $unit)
                                <option value="{{$unit->id}}" {{$unit->id == $search_unit ? 'selected' : ''}}>{{$unit->unit_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 col-12 text-center">
                            <input type="submit" class="btn btn-info" value="Search">
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div> <!-- end col -->
    @if($invoice_product)
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('purchase.product.qty.update', $invoice_product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="block-content block-content-full">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                        <th>Product Code &nbsp;</th>
                                        <th>Unit &nbsp;</th>
                                        <th>Total Stock Qty &nbsp;</th>
                                        <th>Now Add Qty &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$invoice_product->product ? $invoice_product->product->product_name : ''}}</td>
                                        <td>
                                            {{$invoice_product->unit ? $invoice_product->unit->unit_name : ''}}
                                        </td>
                                        <input type="hidden" value="{{$search_product}}" name="product_id">
                                        <td>{{$total_stock}}</td>
                                        <td width="35%">
                                            <input class="form-control return-qty" type="number"
                                                name="qty" placeholder="Add Qty">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
    @endif
</div> <!-- end row -->

@endsection