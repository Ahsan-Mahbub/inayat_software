@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Setting</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Setting</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('setting.update', $info->id)}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Company Name</label>
                            <input type="text" class="form-control" id="validationCustom01" name="company_name" placeholder="Name" value="{{$info->company_name}}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email</label>
                            <input type="email" class="form-control" id="validationCustom02" name="email" placeholder="Email" value="{{$info->email}}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Phone</label>
                            <input type="tel" class="form-control" id="validationCustom03" name="phone" placeholder="Enter Phone Number" value="{{$info->phone}}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Address</label>
                            <textarea class="form-control" id="validationCustom04" name="address" placeholder="Address">{{$info->address}}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Terms & Condition for Purchase</label>
                            <textarea class="form-control editor" name="purchase_trams_condition" placeholder="Terms & Condition">{{$info->purchase_trams_condition}}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Terms & Condition for Sale</label>
                            <textarea class="form-control editor" name="trams_condition" placeholder="Terms & Condition">{{$info->trams_condition}}</textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection