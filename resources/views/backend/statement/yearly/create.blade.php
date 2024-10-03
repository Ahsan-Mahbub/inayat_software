@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Yearly Income Statement</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Yearly Income Statement</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" action="{{route('income-statement.yearly')}}" method="get">
                        <div class="row justify-content-center">
                            <div class="col-md-12 mb-3">
                                <label>Year</label>
                                <select class="custom-select select2" required="" name="year">
                                    <option value="">Select One</option>
                                    @php
                                    $currentYear = date('Y');
                                    foreach(range(2020, $currentYear+1) as $value)
                                    {
                                        echo"<option value=".$value.">".$value."</option>";
                                    }
                                    @endphp
                                </select>
                            </div>
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary" type="submit">Find Yearly Income</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection