@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Edit Product</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Product</li>
                    <li class="breadcrumb-item active">Edit Product</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['product']['index'])
        <a href="{{route('product.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Product List</a>
        @endisset
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Product Name</label>
                            <input type="text" class="form-control" value="{{$product->product_name}}" id="validationCustom01" placeholder="Product name" name="product_name" required="">
                        </div> --}}
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">Product Code</label>
                            <input type="text" class="form-control" id="validationCustom01" value="{{$product->sku}}" placeholder="Product Code" name="sku" required="">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Product Category</label>
                            <select class="custom-select select2" required="" name="category_id" id="category_id" onchange="getSubCategory()">
                                <option value="">Select One</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(Auth::user()->role_id == 1)
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">Purchase Price</label>
                            <input type="number" class="form-control" id="validationCustom01" placeholder="Purchase Price" name="purchase_price" value="{{$product->purchase_price}}" min="0" required="">
                        </div>
                        @endif
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">Sale Price</label>
                            <input type="number" class="form-control" id="validationCustom01" placeholder="Sale Price" name="sale_price" value="{{$product->sale_price}}" min="0" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="d-block">Product Description</label>
                            <textarea id="elm1" name="description" placeholder="Product Description">{{$product->description}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Image </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-group" name="image"
                                    onchange="readURL(this);" />
                                <img id="file_image" src="{{ $product->image ? '/' . $product->image : '/demo.svg' }}" class="pt-2" height="200" width="auto"
                                    alt="product" /><br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>QR Code </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-group" name="qr_code"
                                    onchange="readURL2(this);" />
                                <img id="file_qr_code" src="{{ $product->qr_code ? '/' . $product->qr_code : '/demo.svg' }}" class="pt-2" height="200" width="auto"
                                    alt="qr code" /><br>
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
        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#file_qr_code')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection