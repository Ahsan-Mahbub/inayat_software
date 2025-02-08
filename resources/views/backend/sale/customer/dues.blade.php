@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Dues Client List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Receivable</li>
                    <li class="breadcrumb-item active">Dues Client List</li>
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
                    @isset(auth()->user()->role->permission['permission']['customer']['index'])
                    <a href="{{route('receivable.index')}}" class="btn btn-dark btn-sm waves-effect waves-light">All Clients</a>
                    @endisset
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('customer.due-search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Client ID, Name, Phone, Email.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Creator Name</th>
                                <th>Image</th>
                                <th>ID / Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Total Amount</th>
                                <th>Paid + Return + Adjustment</th>
                                <th>Due / Credit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_customer as $customer)
                            @php
                                $due_amount = $customer->total_amount - ($customer->paid_amount + $customer->return_amount + $customer->adjustment_amount);
                                $credit_amount = abs($due_amount);
                            @endphp
                            @if($due_amount > 0)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$customer->creator ? $customer->creator->name : ''}}</td>
                                <td><img src="/{{$customer->image ? $customer->image : 'demo.svg'}}" height="50"></td>
                                <td>{{$customer -> customer_id}} <br> {{$customer -> customer_name}}</td>
                                <td>{{$customer -> phone}}</td>
                                <td>{{$customer -> email}}</td>
                                <td>{{$customer -> total_amount ? $customer -> total_amount : 0}}</td>
                                <td>{{$customer -> paid_amount ? $customer -> paid_amount : 0}} + {{$customer -> return_amount ? $customer -> return_amount : 0}} ({{$customer -> paid_amount + $customer -> return_amount }})</td>
                                <td>@if($due_amount > 0) {{$due_amount}} <small>dr</small> @else {{$credit_amount}} <small>cr</small> @endif</td>
                                <td>
                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['customer']['transaction'])
                                        <a href="{{route('customer.transaction', $customer->id)}}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-money-bill-wave text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['customer']['profile'])
                                        <a href="{{route('customer.show', $customer->id)}}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-user text-white"></i>
                                        </a>
                                        @endisset
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $all_customer->appends(request()->except('page'))->links() }} --}}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection