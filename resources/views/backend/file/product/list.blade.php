@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Product List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Product</li>
                    <li class="breadcrumb-item active">List</li>
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
                    @isset(auth()->user()->role->permission['permission']['product']['create'])
                    <a href="{{route('product.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Product</a>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['product']['print'])
                    <a href="{{route('product.print')}}" class="btn btn-dark btn-sm waves-effect waves-light">Print Product</a>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['product']['export'])
                    <a href="{{route('product.export')}}" class="btn btn-warning btn-sm waves-effect waves-light">Product Export</a>
                    @endisset
                </div>

                <form method="get" action="{{route('product.search')}}">
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

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name/Code</th>
                                <th>Image</th>
                                <th>QR Code</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_product as $product)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$product->sku}}</td>
                                <td><img style="width: auto; height: 100px;"
                                    src="{{ $product->image ? '/' . $product->image : '/demo.svg' }}"></td>
                                <td><img style="width: auto; height: 100px;"
                                    src="{{ $product->qr_code ? '/' . $product->qr_code : '/demo.svg' }}"></td>
                                <td>{{$product -> category ? $product -> category ->  category_name : ''}} </td>
                                <td>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['product']['edit'])
                                        <a href="{{ route('product.edit', $product->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['product']['destroy'])
                                        <button type="submit"
                                            class="btn btn-sm btn-danger delete-confirm">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                        @endisset
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $all_product->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection