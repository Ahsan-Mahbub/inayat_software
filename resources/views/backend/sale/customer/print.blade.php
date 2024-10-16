@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Print Client</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Client</li>
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
                    @isset(auth()->user()->role->permission['permission']['customer']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Client</button>
                    @endisset
                    <button type="button" class="btn btn-info btn-sm" onclick="printableContent('printableContent')">
                        <i class="mdi mdi-printer-check"></i> Print
                    </button>
                </div>
                <div class="block-header block-header-default mb-4">
                    <div class="block-header block-header-default">
                        <div class="block-options">
                              <input class="ml-3 mr-1" type="checkbox"  id="sl" checked> S.L
                              <input class="ml-3 mr-1" type="checkbox"  id="image" checked> Image
                              <input class="ml-3 mr-1" type="checkbox"  id="name" checked> ID / Name
                              <input class="ml-3 mr-1" type="checkbox"  id="phone" checked> Phone
                              <input class="ml-3 mr-1" type="checkbox"  id="email" checked> Email
                              <input class="ml-3 mr-1" type="checkbox"  id="amount" checked> Total Amount
                              <input class="ml-3 mr-1" type="checkbox"  id="paid" checked> Paid + Return + Adjustment
                              <input class="ml-3 mr-1" type="checkbox"  id="due" checked> Due / Credit
                        </div>
                    </div>
                </div>
                <div id="printableContent">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th class="sl">S/N</th>
                                    <th class="image">Image</th>
                                    <th class="name">ID / Name</th>
                                    <th class="phone">Phone</th>
                                    <th class="email">Email</th>
                                    <th class="amount">Total Amount</th>
                                    <th class="paid">Paid + Return + Adjustment</th>
                                    <th class="due">Due / Credit</th>
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
                                <tr>
                                    <td class="sl">{{$startingSerial++}}</td>
                                    <td class="image"><img src="/{{$customer->image ? $customer->image : 'demo.svg'}}" height="50"></td>
                                    <td class="name">{{$customer -> customer_id}} <br> {{$customer -> customer_name}}</td>
                                    <td class="phone">{{$customer -> phone}}</td>
                                    <td class="email">{{$customer -> email}}</td>
                                    <td class="amount">{{$customer -> total_amount ? $customer -> total_amount : 0}}</td>
                                    <td class="paid">{{$customer -> paid_amount ? $customer -> paid_amount : 0}} + {{$customer -> return_amount ? $customer -> return_amount : 0}} ({{$customer -> paid_amount + $customer -> return_amount }})</td>
                                    <td class="due">@if($due_amount > 0) {{$due_amount}} <small>dr</small> @else {{$credit_amount}} <small>cr</small> @endif</td>
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