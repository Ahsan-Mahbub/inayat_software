@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{$supplier->supplier_name}} - Pay Amount</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Supplier</li>
                    <li class="breadcrumb-item active">Pay Amount</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
    $due_amount = ($supplier->total_amount - ($supplier->paid_amount + $supplier->return_amount));
    $credit = abs($due_amount);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('supplier.transaction.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                    <div class="block-content block-content-full">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Supplier Name &nbsp;</th>
                                        <th>Total Purchase Amount &nbsp;</th>
                                        <th>Total Paid + Return Amount &nbsp;</th>
                                        <th>@if($due_amount > 0) Due @else Credit @endif &nbsp;</th>
                                        @if($due_amount > 0)
                                        <th>Now Pay* &nbsp;</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->total_amount }}</td>
                                        <td>{{ $supplier->paid_amount }} + {{ $supplier->return_amount }} = {{ $supplier->paid_amount + $supplier->return_amount }}</td>
                                        <td>
                                            @if($due_amount > 0) {{ $due_amount }} @else {{$credit}} @endif
                                        </td>
                                        @if($due_amount > 0)
                                        <td>
                                            <input class="form-control price" type="number" max="{{ $due_amount }}"
                                                min="0" name="amount" placeholder="Pay Amount"
                                                value="{{ $due_amount }}" required onkeyup="row_total_price()">
                                        </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">All Transaction :</h4>
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
                                                <select class="custom-select select2" id="method_id" name="method_id"
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
                                            <td class="text-center">@if($due_amount > 0) Now Pay Amount @else Credit Amount @endif *</td>
                                            <td>
                                                <input class="form-control" @if($due_amount > 0) readonly @endif @if($due_amount > 0) value="{{$due_amount}}" @else value="0" @endif id="total_amount" name="total_amount" required>
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