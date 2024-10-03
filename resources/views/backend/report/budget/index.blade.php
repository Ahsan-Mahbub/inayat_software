@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Budget Report</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Report</li>
                    <li class="breadcrumb-item active">Budget</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('report.budget.data')}}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Form Date</label>
                            <input type="date" class="form-control" id="validationCustom01" name="form_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">To Date</label>
                            <input type="date" class="form-control" id="validationCustom01" name="to_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Employee Name </label>
                            <select class="custom-select select2" name="employee_id">
                                <option value="">Select One</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Find Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
