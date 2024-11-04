@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Adjustment Expense Requisition</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Expense Requisition</li>
                    <li class="breadcrumb-item active">Adjustment Expense Requisition</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['expense-requisition']['index'])
        <a href="{{route('expense.requisition.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Expense Requisition List</a>
        @endisset
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('requisition.update.adjustment', $requisition->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Request Amount *</label>
                            <input type="number" class="form-control" id="validationCustom01" placeholder="Request Amount" readonly name="request_amount" value="{{$requisition->request_amount}}" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Amount *</label>
                            <input type="number" class="form-control" id="validationCustom01" placeholder="Amount" name="amount" value="{{$requisition->amount}}" required="">
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
