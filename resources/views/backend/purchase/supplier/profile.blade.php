@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$supplier->supplier_name}} - Profile</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Supplier</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <img src="/{{$supplier->image ? $supplier->image : 'demo.svg'}}" style="border-radius: 50%; height: 250px;">
                <div class="pt-3">
                    <p class="text-dark" style="font-weight: 500">Name : {{$supplier->supplier_name}}.</p>
                    <p class="text-dark" style="font-weight: 500">Email : {{$supplier->email}}.</p>
                    <p class="text-dark" style="font-weight: 500">Phone : {{$supplier->phone}}.</p>
                    <p class="text-dark" style="font-weight: 500">Designation : {{$supplier->designation}}.</p>
                    <p class="text-dark" style="font-weight: 500">Company Name : {{$supplier->company_name}}.</p>
                    <p class="text-dark" style="font-weight: 500">Address : {{$supplier->address}}.</p>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> 
{{-- <div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body" style="padding: 2.25rem 1.25rem;">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Total Purchase Amount</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-briefcase"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$supplier->total_amount}}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body" style="padding: 2.25rem 1.25rem;">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Total Paid Amount</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-briefcase"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$supplier->paid_amount}}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body" style="padding: 2.25rem 1.25rem;">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Total Product Return Amount</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-briefcase"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$supplier->return_amount}}</h4>
            </div>
        </div>
    </div>
    <?php
        $due_amount = ($supplier->total_amount - ($supplier->paid_amount + $supplier->return_amount));
        $credit = abs($due_amount);
    ?>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body" style="padding: 2.25rem 1.25rem;">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">@if($due_amount > 0) Due @else Credit @endif</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-briefcase"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">@if($due_amount > 0) {{ $due_amount }} @else {{$credit}} @endif</h4>
            </div>
        </div>
    </div>

</div> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{$supplier->supplier_name}} - Inovices </h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Quotation</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($purchase->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td><a href="{{route('purchase.show', $purchase->id)}}" target="_blank">{{$purchase -> invoice}}</a></td>
                                <td>
                                    @if($purchase->requisition)
                                    <a href="{{route('requisition.show',$purchase->requsition->id )}}" target="_blank">{{$purchase->requsition->requsition_number}}</a>
                                    @endif
                                </td>
                                <td>{{$purchase -> total_amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
{{-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="block-content block-content-full">
                    <div class="table table-responsive">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="header-title">{{$supplier->supplier_name}} - All Transaction </h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Date</th>
                                                <th>Method</th>
                                                <th>Account</th>
                                                <th>Paid Amount</th>
                                            </tr>
                                        </thead>
                    
                    
                                        <tbody>
                                            @php
                                                $sl = 1;
                                            @endphp
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{$sl++}}</td>
                                                <td>
                                                    <?php
                                                        $timestamp = strtotime($transaction->date);
                                                        $date = date('d-m-Y', $timestamp);
                                                    ?>
                                                    {{$date}}
                                                </td>
                                                <td>{{$transaction->method ? $transaction->method->method_name : 'N/A'}}</td>
                                                <td>{{$transaction->account ? $transaction->account->account_name : 'N/A'}}</td>
                                                <td>{{$transaction -> amount}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="font-w700 text-right">Total Paid</td>
                                                <td class="font-w700">{{ $supplier->paid_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="header-title">{{$supplier->supplier_name}} - Return Product </h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Date</th>
                                                <th>Invoice</th>
                                                <th>Product Name</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                    
                    
                                        <tbody>
                                            @php
                                                $sl = 1;
                                            @endphp
                                            @foreach($returns as $return)
                                            <tr>
                                                <td>{{$sl++}}</td>
                                                <td>
                                                    <?php
                                                        $timestamp = strtotime($return->date);
                                                        $date = date('d-m-Y', $timestamp);
                                                    ?>
                                                    {{$date}}
                                                </td>
                                                <td>{{$return->purchase ? $return->purchase->invoice : ''}}</td>
                                                <td>{{$return->product ? $return->product->product_name : ''}}</td>
                                                <td>{{$return->unit ? $return->unit->unit_name : ''}}</td>
                                                <td>{{$return->qty}}</td>
                                                <td>{{$return->amount}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" class="font-w700 text-right">Total Return Amount</td>
                                                <td class="font-w700">{{ $supplier->return_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> --}}
<!-- end row -->
@endsection
