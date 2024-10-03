@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$customer->customer_name}} - Invoices</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Receivable</li>
                    <li class="breadcrumb-item active">Collection Amount</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Quotation</th>
                                <th>Invoice</th>
                                <th>Challan</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Return</th>
                                <th>Due</th>
                                <th class="text-center">Schedule
                                    <table class="table table-bordered table-striped table-hover mt-2 mb-0">
                                        <thead>
                                            <tr>
                                                <th width="60%">Date</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($sale->date);
                                        $date = date('d-m-Y', $timestamp);
                                        $return_amount = App\Models\SaleReturn::where('sale_id', $sale->id)->sum('amount');
                                        $payment_dates = json_decode($sale->payment_date, true);
                                        $payment_amounts = json_decode($sale->payment_amount, true);
                                    ?>
                                    {{$date}}
                                </td>
                                <td> @if($sale->requisition)<a href="{{route('sale.requisition.show', $sale->requisition->id)}}" target="_blan">{{$sale->requisition->requisition_number}}</a>@endif</td>
                                <td><a href="{{route('sale.show', $sale->id)}}" target="_blan">{{$sale -> invoice}}</a></td>
                                <td><a href="{{route('sale.challan', $sale->id)}}" target="_blan">{{$sale -> challan}}</a></td>
                                <td>{{$sale -> total_amount}}</td>
                                <td>{{$sale->paid_amount}}</td>
                                <td>{{$return_amount}}</td>
                                <td>{{$sale -> due_amount + $return_amount}}</td>
                                <td>
                                    <table class="table table-bordered table-striped table-hover">
                                        <tbody>
                                            @if($payment_dates && $payment_amounts)
                                                @foreach ($payment_dates as $index => $date)
                                                <tr>
                                                    <td width="60%">
                                                        <?php
                                                            $timestamp = strtotime($date);
                                                            $e_date = date('d-m-Y', $timestamp);
                                                        ?>
                                                        {{$e_date}}
                                                    </td>
                                                    <td>{{ $payment_amounts[$index] }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('customer.transaction.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <div class="block-content block-content-full">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Quotation</th>
                                        <th>Invoice</th>
                                        <th>Total &nbsp;</th>
                                        <th>Paid &nbsp;</th>
                                        <th>Return &nbsp;</th>
                                        <th>Due &nbsp;</th>
                                        <th>Now Pay* &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <?php
                                        $return_amount = App\Models\SaleReturn::where('sale_id', $sale->id)->sum('amount');
                                        $due_amount = $sale -> due_amount + $return_amount;
                                    ?>
                                    @if($due_amount > 0)
                                        <tr>
                                            @php
                                                $sl = 1;
                                            @endphp
                                            <td>{{$sl++}}</td>
                                            <td> @if($sale->requisition)<a href="{{route('sale.requisition.show', $sale->requisition->id)}}" target="_blan">{{$sale->requisition->requisition_number}}</a>@endif</td>
                                            <td><a href="{{route('sale.show', $sale->id)}}" target="_blan">{{$sale -> invoice}}</a></td>
                                            <td>{{$sale -> total_amount}}</td>
                                            <td>{{$sale->paid_amount}}</td>
                                            <td>{{$return_amount}}</td>
                                            <td>{{$due_amount}}</td>
                                            @if($due_amount > 0)
                                            <td>
                                                <input type="hidden" value="{{$sale->id}}" name="sale_id[]">
                                                <input class="form-control price" type="number" max="{{ intval($due_amount, 0) }}"
                                                    min="0" name="amount[]" placeholder="Pay Amount"
                                                    value="0" required onkeyup="row_total_price()">
                                            </td>
                                            @endif
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <table class="table table-bordered table-striped table-sm">
                                        <tr>
                                            <td class="text-center">Date *</td>
                                            <td>
                                                <input class="form-control" type="date" required name="date">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Payment Method *</td>
                                            <td>
                                                <select class="custom-select select2" name="method_id" id="method_id"
                                                    required="" onchange="getAccount()">
                                                    <option value="">Please select</option>
                                                    @foreach ($methods as $method)
                                                        <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Account *</td>
                                            <td>
                                                <select class="custom-select select2" id="account_id" name="account_id"
                                                    required="">
                                                    <option value="">Please select</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Now Pay Amount *</td>
                                            <td>
                                                <input class="form-control" readonly value="0" id="total_amount" name="total_amount" required>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 text-right">
                                    <button Type="submit" class="btn btn-primary">
                                        Pay Amount
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="">
                    <h4 class="header-title">All Transaction :</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Account</th>
                                    <th>Invoice</th>
                                    <th>Paid Amount</th>
                                    @isset(auth()->user()->role->permission['permission']['customer']['transaction-delete'])
                                    <th>Action</th>
                                    @endisset
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
                                    <td>{{$transaction->method ? $transaction->method->method_name : 'N/A'}} </td>
                                    <td>{{$transaction->account ? $transaction->account->account_name : 'N/A'}}</td>
                                    <td>{{$transaction->sale ? $transaction->sale->invoice : 'N/A'}}</td>
                                    <td>{{$transaction -> amount}}</td>
                                    @isset(auth()->user()->role->permission['permission']['customer']['transaction-delete'])
                                    <td>
                                        <form action="{{ route('customer.transaction.destroy', $transaction->id) }}" method="post"
                                            accept-charset="utf-8">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger delete-confirm">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endisset
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="font-w700 text-right">Total Paid</td>
                                    <td class="font-w700">{{ $customer->paid_amount }}</td>
                                    @isset(auth()->user()->role->permission['permission']['customer']['transaction-delete'])
                                    <td></td>
                                    @endisset
                                </tr>
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
    <script type="text/javascript">
        function getAccount() {
            let id = $("#method_id").val();
            let url = '/admin/data-get/account/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    let html = '';
                    html += '<option value="">Please select</option>'
                    response.forEach(element => {
                        html += '<option value=' + element.id + '>' + element.account_name + '</option>'
                    });
                    $("#account_id").html(html);

                }
            });
        }
        $(document).ready(function() {
            var total = 0;
            $('.due_price').each(function() {
                total += parseInt($(this).val());
                $('#total_amount').val(total);
            });
        });

        function row_total_price() {
            var total = 0;
            $('.price').each(function() {
                total += parseInt($(this).val());
                $('#total_amount').val(total);
            });
        }
    </script>
@endsection