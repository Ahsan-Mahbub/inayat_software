@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Product Print</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Product</li>
                    <li class="breadcrumb-item active">Print</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-4">
                    @isset(auth()->user()->role->permission['permission']['product']['index'])
                    <a href="{{route('product.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Product List</a>
                    @endisset
                    <button type="button" class="btn btn-info btn-sm" onclick="printableContent('printableContent')">
                        <i class="mdi mdi-printer-check"></i> Print
                    </button>
                </div>

                <form method="get" action="{{route('product.print.search')}}">
                    <div class="row mb-3">
                        <div class="col-md-3 col-12">
                            <label>Category: </label>
                            <select class="custom-select select2" name="category_id">
                                <option value="">Select One</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $search_category ? 'selected' : ''}}>{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-12">
                            <label>Search: </label>
                            <input type="text" class="form-control" placeholder="Search by Product Name.." name="search" id="search" value="{{$search}}"> 
                        </div>
                        <div class="col-md-2 col-12 mt-auto">
                            <input type="submit" class="btn btn-info" value="Search">
                        </div>
                    </div>
                </form>

                <div class="block-header block-header-default mb-4">
                    <div class="block-header block-header-default">
                        <div class="block-options">
                              <input class="ml-3 mr-1" type="checkbox"  id="sl" checked> S.L
                              <input class="ml-3 mr-1" type="checkbox"  id="code" checked> Product Name / Code
                              <input class="ml-3 mr-1" type="checkbox"  id="image" checked> Image
                              <input class="ml-3 mr-1" type="checkbox"  id="description" checked> Description
                              @if(Auth::user()->role_id == 1)
                              <input class="ml-3 mr-1" type="checkbox"  id="purchase" checked> Purchase Price
                              @endif
                              <input class="ml-3 mr-1" type="checkbox"  id="sale" checked> Sale Price
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full" id="printableContent">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="sl">S/N</th>
                                    <th class="code">Name/Code</th>
                                    <th class="image">Image</th>
                                    <th class="description">Description</th>
                                    @if(Auth::user()->role_id == 1)
                                    <th class="purchase" style="width: 11%;">Purchase Price</th>
                                    @endif
                                    <th class="sale" style="width: 8%;">Sale Price</th>
                                </tr>
                            </thead>
        
        
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach($all_product as $product)
                                <tr>
                                    <td class="sl" style="vertical-align: middle;">{{$sl++}}</td>
                                    <td class="code" style="vertical-align: middle;">{{$product->sku}}</td>
                                    <td class="image" style="vertical-align: middle;"><img style="width: 150px; height: 150px; object-fit: contain;"
                                        src="{{ $product->image ? '/' . $product->image : '/demo.svg' }}"></td>
                                    <td class="description" style="vertical-align: middle;">{!! $product->description !!} </td>
                                    @if(Auth::user()->role_id == 1)
                                    <td class="purchase" style="vertical-align: middle;">{{$product->purchase_price}}</td>
                                    @endif
                                    <td class="sale" style="vertical-align: middle;">{{$product->sale_price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
@section('script')
 <script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            var columnId = $(this).attr('id');
            if ($(this).is(":checked")) {
                $('.' + columnId).removeClass('d-none');
            } else {
                $('.' + columnId).addClass('d-none');
            }
        });
    });
 </script>
@endsection