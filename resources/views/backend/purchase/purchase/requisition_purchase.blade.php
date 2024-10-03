@extends('backend.layouts.app')

@section('content')
    <style type="text/css">
        .block {
            margin-bottom: 0;
        }

        .new_supplier {
            display: none;
        }

        .setProductName p {
            padding: 12px 15px;
            box-shadow: 1px 1px 0px 2px #ddd;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 10px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Add Quotation Purchase</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Purchase</li>
                        <li class="breadcrumb-item active">Quotation Purchase</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['purchase']['index'])
            <a href="{{ route('purchase.index') }}" class="btn btn-primary btn-sm waves-effect waves-light">Purchase List</a>
        @endisset
    </div>

    <form method="post" action="{{ route('purchase.store') }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Date</label>
                                    <input type="date" readonly class="form-control" name="date"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <label class="form-label">Quotation Number</label>
                                <div>
                                    <select class="custom-select select2" name="requisition_id" id="requisition_id">
                                        <option value="">Select One</option>
                                        @foreach ($requisitions as $requisition)
                                            <option value="{{ $requisition->id }}">{{ $requisition->requisition_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3 pt-2">
                            <div class="col-4"><label class="form-label">Product Code</label></div>
                            <div class="col-3"><label class="form-label">Unit</label></div>
                            <div class="col-2 d-none"><label class="form-label">Purchase</label></div>
                            <div class="col-3"><label class="form-label">Sale Price</label></div>
                            <div class="col-2"><label class="form-label">Qty</label></div>
                            <div class="col-2 d-none"><label class="form-label">Amount</label></div>
                        </div>
                        <div class="add_item" id="add_item">
                            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="col-lg-12 d-none">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-md-4 pb-3">
                                <label class="form-label">Payment Method</label>
                                <div>
                                    <select class="custom-select select2" name="method_id" id="method_id" onchange="getAccount()">
                                        <option value="">Select One</option>
                                        @foreach ($methods as $method)
                                            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <label class="form-label">Account</label>
                                <div>
                                    <select class="custom-select select2" name="account_id" id="account_id" required>
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Sub Total</label>
                                    <input type="text" readonly id="sub_total" class="form-control" name="subtotal"
                                        value="0" required>
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-floating">
                                            <label class="form-label">Discount</label>
                                            <input type="text" class="form-control" name="discount" id="discount"
                                                onkeyup="discountValue()" value="0">
                                        </div>
                                    </div>
                                    <div class="col-2 m-auto text-center">
                                        <input type="checkbox" class="form-check-input" name="percentage" id="percentage"
                                            value="0"> %
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">After Discount Amount</label>
                                    <input type="text" class="form-control" readonly id="discount_price"
                                        name="discount_price" value="0">
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Vat (%)</label>
                                    <input type="text" class="form-control" name="vat" id="vat"
                                        onkeyup="vatValue()" value="0">
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Total</label>
                                    <input type="text" readonly class="form-control" name="total_amount"
                                        id="total_price" value="0">
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Paid</label>
                                    <input type="number" class="form-control" name="paid_amount" id="paid_amount"
                                        value="0">
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Due</label>
                                    <input type="text" readonly class="form-control" name="due_amount"
                                        id="due_amount" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 pb-3 text-center">
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Purchase</button>
            </div>
        </div>
    </form>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('#requisition_id').on('change', function() {
                let id = $(this).val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('get-requisition') }}",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        let appendHtml = '';
                        $.each(data.requisition.requisition_product, function(key, v) {
                            let product_id = v.product_id;
                            let getProductName = v.product ? v.product.product_name :
                                '';
                            let size = v.size;

                            appendHtml += `
                            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                                <div class="row mb-1">
                                    <input type="hidden" name="product_id[]" class="product_id" value="${product_id}">
                                    <div class="col-4">
                                        <input type="text" class="form-control" name="product_name[]" placeholder="Product Code.." value="${getProductName}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" disabled class="form-control" value="${v.unit.unit_name}">
                                        <input type="hidden" name=unit_id[] class="form-control" value="${v.unit.id}">
                                    </div>


                                    <div class="col-2 d-none">
                                        <input type="text" class="form-control" name="unit_price[]" placeholder="Purchase Price.."
                                            value="${(v.discount_amount / v.qty).toFixed()}" required readonly>
                                    </div>
                                    
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="sale_price[]" placeholder="Sale Price.." value="${v.product.sale_price}" required>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="buying_qty[]" placeholder="Qty.." value="${v.qty}" required readonly>
                                    </div>
                                    <div class="col-2 d-none">
                                        <input type="text" class="form-control single_subtotal" name="amount[]" readonly value="${v.discount_amount.toFixed(2)}">
                                    </div>
                                </div>
                            </div>
                        `;
                        });

                        $("#add_item").html(appendHtml);

                        // Call the subtotal function to update the subtotal
                        subtotal();
                    }
                });
            });

            $(document).on('keyup', '#paid_amount', function() {
                dueAmount();
            });

            $('#percentage').on('click', function() {
                $(this).val($(this).val() == 0 ? 1 : 0);
                $("#discount").val('');
                discountValue();
                vatValue();
                dueAmount();
            });

            $('#method_id').on('change', function() {
                getAccount();
            });
        });

        function subtotal() {
            let total_subtotal = 0;

            // Sum the values of all elements with the class single_subtotal
            $('.single_subtotal').each(function() {
                total_subtotal += parseFloat($(this).val()) || 0;
            });

            // Update the subtotal input field
            $('#sub_total').val(total_subtotal.toFixed(2));
            discountValue();
            vatValue();
            dueAmount();
        }

        function discountValue() {
            let discount = parseFloat($('#discount').val()) || 0;
            let sub_total = parseFloat($('#sub_total').val()) || 0;
            let percentage = $('#percentage').val() == 1;
            let discount_amount = percentage ? (sub_total * discount / 100) : discount;
            $('#discount_price').val((sub_total - discount_amount).toFixed(2));
            vatValue();
            dueAmount();
        }

        function vatValue() {
            let vat = parseFloat($('#vat').val()) || 0;
            let discount_price = parseFloat($('#discount_price').val()) || 0;
            let vat_amount = (discount_price * vat / 100);
            $('#total_price').val((discount_price + vat_amount).toFixed(2));
            dueAmount();
        }

        function dueAmount() {
            let paid_amount = parseFloat($('#paid_amount').val()) || 0;
            let total_price = parseFloat($('#total_price').val()) || 0;
            $('#due_amount').val((total_price - paid_amount).toFixed(2));
        }

        function getAccount() {
            let id = $('#method_id').val();
            let url = '/admin/data-get/account/' + id;
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(response) {
                    let html = '<option value="">Select One</option>';
                    response.forEach(element => {
                        html += `<option value="${element.id}">${element.account_name}</option>`;
                    });
                    $('#account_id').html(html);
                }
            });
        }
    </script>
@endsection
