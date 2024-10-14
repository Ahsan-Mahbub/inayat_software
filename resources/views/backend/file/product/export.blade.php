@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Product Export</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Product</li>
                    <li class="breadcrumb-item active">Export</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-4">
                    @isset(auth()->user()->role->permission['permission']['product']['index'])
                    <a href="{{route('product.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Product List</a>
                    @endisset
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form method="get" action="{{route('product.exportlist')}}">
                            <div class="row mb-3">
                                <div class="col-md-12 col-12">
                                    <label>Category: </label>
                                    <select class="custom-select select2" name="category_id">
                                        <option value="">Select One</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == $search_category ? 'selected' : ''}}>{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 col-12 mt-2">
                                    <label>Search: </label>
                                    <input type="text" class="form-control" placeholder="Search by Product Name.." name="search" id="search" value="{{$search}}"> 
                                </div>
                                <div class="col-md-12 col-12 mt-2 text-center">
                                    <input type="submit" class="btn btn-info" value="Export">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection