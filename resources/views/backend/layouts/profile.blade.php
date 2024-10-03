@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Profile Update</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('profile.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Name</label>
                            <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Name" value="{{Auth::user()->name}}" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email</label>
                            <input type="email" class="form-control" id="validationCustom02" name="email" placeholder="Email" value="{{Auth::user()->email}}" readonly required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Password</label>
                            <input type="password" class="form-control" id="validationCustom03" name="password" placeholder="Password (if changes)" value="">
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection