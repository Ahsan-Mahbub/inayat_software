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
            margin-bottom: 10px
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Add Purchase</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Purchase</li>
                        <li class="breadcrumb-item active">Add Purchase</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['product']['create'])
            <button type="button" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="modal"
                data-target=".bs-example-modal-md">Add Product</button>
        @endisset
        @isset(auth()->user()->role->permission['permission']['supplier']['create'])
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal"
                data-target=".bs-example-modal-md-supplier">Add Supplier</button>
        @endisset
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
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <label class="form-label">Supplier Name</label>
                                <div class="">
                                    <select class="custom-select select2" name="supplier_id" id="supplier_id"
                                        onchange="getSupplierInfo()">
                                        <option value="">Select One</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }} @if ($supplier->phone)
                                                    - {{ $supplier->phone }}
                                                @endif
                                            </option>
                                        @endforeach
                                        <option value="0">Add New Supplier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pb-3 new_supplier">
                                <div class="form-floating">
                                    <label class="form-label">Supplier Name</label>
                                    <input type="text" class="form-control" name="supplier_name" id="supplier_name"
                                        placeholder="Supplier Name">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3 new_supplier">
                                <div class="form-floating">
                                    <label class="form-label">Supplier Phone Number</label>
                                    <input type="tel" class="form-control" name="phone" id="supplier_phone"
                                        placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="col-md-12 text-center pb-2 text-success">
                                <strong id="amount_des"></strong><strong id="amount"></strong><small
                                    id="amount_type"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3 pt-2">
                            <div class="col-4">
                                <label class="form-label">Product Code</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Unit</label>
                            </div>
                            <div class="col-2 d-none">
                                <label class="form-label">Purchase</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Sale Price</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Qty</label>
                            </div>
                            <div class="col-2 d-none">
                                <label class="form-label">Amount</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Action</label>
                            </div>
                        </div>
                        <div class="add_item" id="add_item">
                            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                                <div class="row mb-1">

                                    <input type="hidden" name="product_id[]" class="product_id product_id-202112"
                                        value="">

                                    <div class="col-4">
                                        <input type="text" class="form-control search_product search_product-202112"
                                            id="first_product_row" name="product_name[]"
                                            placeholder="Search by Product Code.." value="">
                                    </div>
                                    <div class="col-2">
                                        <select class="custom-select unit-202112" required="" name="unit_id[]"
                                            id="unit_id" required random_number="202112">
                                            <option value="">Select One</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 d-none">
                                        <input type="text" id="textToNumber" class="form-control unitPrice-202112"
                                            name="unit_price[]" placeholder="Price.." required>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="textToNumber" class="form-control salePrice-202112"
                                            name="sale_price[]" placeholder="Sale Price.." required>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control buyingQty-202112" name="buying_qty[]"
                                            placeholder="Qty.." required>
                                    </div>
                                    <div class="col-2 d-none">
                                        <input type="text"
                                            class="form-control amount amount-202112 single_subtotal single_subtotal-202112"
                                            name="amount[]" id="single_subtotal" readonly value="0">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-success me-1 mb-1 addEvenMore">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row show_get_search_product">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 d-none">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-md-4 pb-3">
                                <label class="form-label">Payment Method</label>
                                <div class="">
                                    <select class="custom-select select2" name="method_id" id="method_id" onchange="getAccount()" required>
                                        <option value="">Select One</option>
                                        @foreach ($methods as $method)
                                            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <label class="form-label">Account</label>
                                <div class="">
                                    <select class="custom-select select2" name="account_id" id="account_id" required>
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Sub Total</label>
                                    <input type="text" readonly id="sub_total" class="form-control" name="subtotal"
                                        value="0">
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
                                        <input type="checkbox" class="form-check-input" name="percentage"
                                            id="percentage" value="0"> %
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
                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                    Purchase
                </button>
            </div>
        </div>
    </form>

    <div style="visibility: hidden;">
        <div class="whole_extra_item_add" id="whole_extra_item_add">
            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">

            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active product_tab" id="product_tab" data-toggle="tab"
                                        href="#product" role="tab">
                                        Product
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#category" role="tab">
                                        Category
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="product" role="tabpanel">
                                    <form class="needs-validation" novalidate="" action="{{ route('product.store') }}"
                                        method="post" id="add_product_form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom01">Product Code</label>
                                                <input type="text" class="form-control" id="validationCustom01"
                                                    placeholder="Product Code" name="sku">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Product Category</label>
                                                <div>
                                                    <select class="custom-select select2" name="category_id"
                                                        id="category_id" onchange="getSubCategory()">
                                                        <option value="">Select One</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">
                                                                {{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="category" role="tabpanel">
                                    <form class="needs-validation" novalidate="" action="{{ route('category.store') }}"
                                        id="add_category_form" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Category Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="validationCustom01"
                                                    name="category_name" placeholder="Category Name">
                                                <small class="text-danger" id="category-add-category_name"></small>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary" type="submit">Submit Quotation</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Add Modal --}}
    <div class="modal fade bs-example-modal-md-supplier" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate="" action="{{ route('supplier.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">Supplier Name *</label>
                                <input type="text" class="form-control" id="validationCustom01" name="supplier_name"
                                    placeholder="Name" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">Email </label>
                                <input type="email" class="form-control" id="validationCustom02" name="email"
                                    placeholder="Email">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom03">Phone Number </label>
                                <input type="tel" class="form-control" id="validationCustom03" name="phone"
                                    placeholder="Phone">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom03">Company Name </label>
                                <input type="text" class="form-control" id="validationCustom03" name="company_name"
                                    placeholder="Company Name">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom04">Address</label>
                                <textarea class="form-control" id="validationCustom04" name="address" placeholder="Address"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom04">Address</label>
                                <textarea class="form-control" id="validationCustom04" name="address" placeholder="Address"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom05">Image </label>
                                <div class="col-lg-12">
                                    <input type='file' class="form-control" id="validation05" name="image"
                                        onchange="readURL(this);" />
                                    <img id="image" src="/demo.svg" height="200" width="250"
                                        alt="property" /><br>
                                </div>
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
    {{-- End Add Modal --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $("body").on("keyup", ".search_product-202112", function(e) {
                var random_number = 202112;
                var className = "search_product-" + random_number;
                var classNameID = "product_id-" + random_number;
                var priceClassName = "unitPrice-" + random_number;
                var saleClassName = "salePrice-" + random_number;

                let searchData = e.target.value;
                let searchDataLength = searchData.length;
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "GET",
                    url: "purchase-search-product",
                    data: {
                        search: searchData,
                        searchDataLength: searchDataLength,
                    },
                    success: function(result) {
                        console.log(result);

                        var searchHtml = '';
                        $.each(result.products, function(key, v) {
                            var class_name =
                                `setProductName-${v.id}-${result.rand}`;
                            searchHtml += `
                                <div class="col-md-4 col-xl-3 col-12 stock_product" data-id="${v.id}" style="cursor: pointer;">
                                    <a class="block setProductName ${class_name}" rand="${result.rand}" product_id="${v.id}">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="font-size-lg font-w600">
                                                    ${v.product_name} ( ${v.category.category_name} )<br>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `
                            $(document).on('click', "." + class_name, function() {
                                var product_id = $(this).attr('product_id');
                                var rand = $(this).attr('rand');
                                var gen_class_name = "setProductName-" + result
                                    .rand;
                                $("." + className).val(product_id);
                                $(".show_get_search_product").html('');

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $(
                                            'meta[name="csrf-token"]'
                                        ).attr('content')
                                    },
                                    url: "{{ route('get-product-details') }}",
                                    type: "POST",
                                    data: {
                                        product_id: product_id
                                    },
                                    success: function(resp) {
                                        $("." + classNameID).val(
                                            resp.productDetails
                                            .id);
                                        $("." + className).val(resp
                                            .productDetails
                                            .product_name);
                                        $("." + priceClassName).val(
                                            resp.productDetails
                                            .purchase_price ?
                                            resp.productDetails
                                            .purchase_price : 0);
                                        $("." + saleClassName).val(
                                            resp.productDetails
                                            .sale_price ? resp
                                            .productDetails
                                            .sale_price : 0);

                                        let buyingPriceElements =
                                            document
                                            .getElementsByClassName(
                                                'unitPrice-' +
                                                random_number);
                                        let buyingQtyElements =
                                            document
                                            .getElementsByClassName(
                                                'buyingQty-' +
                                                random_number);
                                        let vatElements = document
                                            .getElementsByClassName(
                                                'vat-' +
                                                random_number);
                                        let amountElements =
                                            document
                                            .getElementsByClassName(
                                                'amount-' +
                                                random_number);

                                        var buyingPrice = 0;
                                        var buyingQty = 0;
                                        var vat = 0;
                                        Array.from(
                                                buyingPriceElements)
                                            .forEach((
                                                buyingPriceElement
                                            ) => {
                                                console.log(
                                                    buyingPriceElement
                                                );
                                                buyingPriceElement
                                                    .addEventListener(
                                                        'keyup',
                                                        function(
                                                            e) {
                                                            buyingPrice
                                                                =
                                                                e
                                                                .target
                                                                .value;
                                                            if (/^\d*$/
                                                                .test(
                                                                    buyingPrice
                                                                )
                                                            ) {
                                                                updateAmount
                                                                    ();
                                                                subtotal
                                                                    ();
                                                            } else {
                                                                buyingPriceElement
                                                                    .value =
                                                                    '';
                                                            }
                                                        }
                                                    );
                                            });
                                        Array.from(
                                                buyingQtyElements)
                                            .forEach((
                                                buyingQtyElement
                                            ) => {
                                                buyingQtyElement
                                                    .addEventListener(
                                                        'keyup',
                                                        function(
                                                            e) {
                                                            buyingQty
                                                                =
                                                                e
                                                                .target
                                                                .value;
                                                            if (/^\d*$/
                                                                .test(
                                                                    buyingQty
                                                                )
                                                            ) {
                                                                updateAmount
                                                                    ();
                                                                subtotal
                                                                    ();
                                                            } else {
                                                                buyingQtyElement
                                                                    .value =
                                                                    '';
                                                            }
                                                        }
                                                    );
                                            });

                                        function updateAmount() {
                                            Array.from(
                                                    amountElements)
                                                .forEach((
                                                    amountElement
                                                ) => {
                                                    var price =
                                                        $('.unitPrice-' +
                                                            random_number
                                                        )
                                                        .val();
                                                    var qty = $(
                                                            '.buyingQty-' +
                                                            random_number
                                                        )
                                                        .val();
                                                    amountElement
                                                        .value =
                                                        price *
                                                        qty;
                                                });
                                        }
                                    },
                                    error: function() {
                                        toastr.error(
                                            " Product Doesn't Added",
                                            "Error");
                                    }
                                });

                            });
                        })

                        if (searchHtml) {
                            $(".show_get_search_product").html(searchHtml);
                        } else {
                            $(".show_get_search_product").html(`
                                <div class="d-flex pl-3 pt-2 pb-2" style="justify-content: space-between;">
                                    <div>
                                        <span class="text-danger">Product Not Found</span>
                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Product</button>
                                    </div>
                                </div>
                            `);
                        }
                    },
                });
            });

            var counter = 0;
            $(document).on("click", ".addEvenMore", function() {
                function getRandomInt(min, max) {
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                const random_number = getRandomInt(100, 9999);
                let product_id = $(this).attr('product_id');
                var whole_extra_item_add = $("#whole_extra_item_add").html();
                var addItem = $("#add_item");
                var units = {!! json_encode($units) !!};
                var unitOptions = '<option value="">Select One</option>';
                units.forEach(function(unit) {
                    unitOptions += `<option value="${unit.id}">${unit.unit_name}</option>`;
                });
                addItem.append(`
                        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                            <div class="row mb-1">
        
                                <input type="hidden" name="product_id[]" class="product_id product_id-${random_number}" value="">
        
                                <div class="col-4">
                                    <input type="text" class="form-control search_product search_product-${random_number}" name="product_name[]" placeholder="Search by Product Code.." value="" >
                                </div>
                                <div class="col-2">
                                    <select class="custom-select unit-${random_number}" required="" name="unit_id[]" id="unit_id" required random_number="${random_number}">
                                        ${unitOptions}
                                    </select>
                                </div>

                                <div class="col-2 d-none">
                                    <input type="text" id="textToNumber" class="form-control unitPrice-${random_number}" name="unit_price[]"
                                        placeholder="Purchase Price.." required>
                                </div>
                               
                                <div class="col-2">
                                    <input type="text" id="textToNumber" class="form-control salePrice-${random_number}" name="sale_price[]" placeholder="Sale Price.." required>
                                </div>                             
                                <div class="col-2">
                                    <input type="text" class="form-control buyingQty-${random_number}" name="buying_qty[]" placeholder="Qty.." required>
                                </div>
                                <div class="col-2 d-none">
                                    <input type="text" class="form-control amount amount-${random_number} single_subtotal single_subtotal-${random_number}" name="amount[]" id="single_subtotal" readonly value="0">
                                </div>   
                                <div class="col-2">
                                    <button type="button" class="btn btn-success me-1 mb-1 addEvenMore">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger me-1 mb-1 removeEvenMore">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `);
                counter++;

                $(document).on("click", ".removeEvenMore", function(event) {
                    $(this).closest(".delete_whole_extra_item_add").remove();
                    subtotal();
                    discountValue();
                    vatValue();
                    dueAmount();
                    toastr.warning(" Product Removed", "Remove");
                });
                var className = "search_product-" + random_number;
                var classNameID = "product_id-" + random_number;
                var priceClassName = "unitPrice-" + random_number;
                var saleClassName = "salePrice-" + random_number;

                $("body").on("keyup", "." + className, function(e) {
                    let searchData = e.target.value;
                    let searchDataLength = searchData.length;
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: "GET",
                        url: "purchase-search-product",
                        data: {
                            search: searchData,
                            searchDataLength: searchDataLength,
                        },
                        success: function(result) {
                            // console.log(result);

                            var searchHtml = '';
                            $.each(result.products, function(key, v) {
                                var class_name =
                                    `setProductName-${v.id}-${result.rand}`;
                                searchHtml += `
                                    <div class="col-md-4 col-xl-3 col-12 stock_product" data-id="${v.id}" style="cursor: pointer;">
                                        <a class="block setProductName ${class_name}" rand="${result.rand}" product_id="${v.id}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="font-size-lg font-w600">
                                                        ${v.product_name}  ( ${v.category.category_name} ) <br>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                `
                                $(document).on('click', "." + class_name,
                                    function() {
                                        var product_id = $(this).attr(
                                            'product_id');
                                        var rand = $(this).attr('rand');
                                        var gen_class_name =
                                            "setProductName-" + result.rand;
                                        $("." + className).val(product_id);
                                        $(".show_get_search_product").html(
                                            '');

                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr(
                                                    'content')
                                            },
                                            url: "{{ route('get-product-details') }}",
                                            type: "POST",
                                            data: {
                                                product_id: product_id
                                            },
                                            success: function(
                                                resp) {
                                                $("." +
                                                        classNameID
                                                    )
                                                    .val(resp
                                                        .productDetails
                                                        .id);
                                                $("." +
                                                        className
                                                    )
                                                    .val(resp
                                                        .productDetails
                                                        .product_name
                                                    );
                                                $("." +
                                                        priceClassName
                                                    )
                                                    .val(resp
                                                        .productDetails
                                                        .purchase_price ?
                                                        resp
                                                        .productDetails
                                                        .purchase_price :
                                                        0);
                                                $("." +
                                                        saleClassName
                                                    )
                                                    .val(resp
                                                        .productDetails
                                                        .sale_price ?
                                                        resp
                                                        .productDetails
                                                        .sale_price :
                                                        0);

                                                let buyingPriceElements =
                                                    document
                                                    .getElementsByClassName(
                                                        'unitPrice-' +
                                                        random_number
                                                    );
                                                let buyingQtyElements =
                                                    document
                                                    .getElementsByClassName(
                                                        'buyingQty-' +
                                                        random_number
                                                    );
                                                let vatElements =
                                                    document
                                                    .getElementsByClassName(
                                                        'vat-' +
                                                        random_number
                                                    );
                                                let amountElements =
                                                    document
                                                    .getElementsByClassName(
                                                        'amount-' +
                                                        random_number
                                                    );

                                                var buyingPrice =
                                                    0;
                                                var buyingQty =
                                                    0;
                                                var vat = 0;
                                                Array.from(
                                                        buyingPriceElements
                                                    )
                                                    .forEach((
                                                        buyingPriceElement
                                                    ) => {
                                                        console
                                                            .log(
                                                                buyingPriceElement
                                                            );
                                                        buyingPriceElement
                                                            .addEventListener(
                                                                'keyup',
                                                                function(
                                                                    e
                                                                ) {
                                                                    buyingPrice
                                                                        =
                                                                        e
                                                                        .target
                                                                        .value;
                                                                    if (/^\d*$/
                                                                        .test(
                                                                            buyingPrice
                                                                        )
                                                                    ) {
                                                                        updateAmount
                                                                            ();
                                                                        subtotal
                                                                            ();
                                                                    } else {
                                                                        buyingPriceElement
                                                                            .value =
                                                                            '';
                                                                    }
                                                                }
                                                            );
                                                    });
                                                Array.from(
                                                        buyingQtyElements
                                                    )
                                                    .forEach((
                                                        buyingQtyElement
                                                    ) => {
                                                        buyingQtyElement
                                                            .addEventListener(
                                                                'keyup',
                                                                function(
                                                                    e
                                                                ) {
                                                                    buyingQty
                                                                        =
                                                                        e
                                                                        .target
                                                                        .value;
                                                                    if (/^\d*$/
                                                                        .test(
                                                                            buyingQty
                                                                        )
                                                                    ) {
                                                                        updateAmount
                                                                            ();
                                                                        subtotal
                                                                            ();
                                                                    } else {
                                                                        buyingQtyElement
                                                                            .value =
                                                                            '';
                                                                    }
                                                                }
                                                            );
                                                    });

                                                function updateAmount() {
                                                    Array.from(
                                                            amountElements
                                                        )
                                                        .forEach(
                                                            (
                                                                amountElement
                                                            ) => {
                                                                var price =
                                                                    $('.unitPrice-' +
                                                                        random_number
                                                                    )
                                                                    .val();
                                                                var qty =
                                                                    $('.buyingQty-' +
                                                                        random_number
                                                                    )
                                                                    .val();
                                                                amountElement
                                                                    .value =
                                                                    price *
                                                                    qty;
                                                            });
                                                }
                                            },
                                            error: function() {
                                                toastr.error(
                                                    " Product Doesn't Added",
                                                    "Error");
                                            }
                                        });

                                    });
                            })

                            if (searchHtml) {
                                $(".show_get_search_product").html(searchHtml);
                            } else {
                                $(".show_get_search_product").html(`
                                    <div class="d-flex pt-2 pl-3 pb-2" style="justify-content: space-between;">
                                        <div>
                                            <span class="text-danger">Product Not Found</span>
                                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Product</button>
                                        </div>
                                    </div>
                                `);
                            }
                        },
                    });
                });
            });

        });

        function subtotal() {
            var total_subtotal = 0;
            var single_subtotal_element = document.getElementsByClassName(
                "single_subtotal");
            Array.from(single_subtotal_element).forEach((ele) => {
                total_subtotal += parseInt(ele.value);
            });

            var sub_total_value = $("#sub_total").val(total_subtotal);
            discountValue();
            vatValue();
            dueAmount();
        };

        $(document).on('click', '#percentage', function() {
            var value = $(this).val();
            if (value == 0) {
                value = 1;
            } else {
                value = 0;
            }
            $(this).val(value);
            $("#discount").val('');
            vatValue();
            dueAmount();
        })

        function discountValue() {
            var value = $("#discount").val();
            var sub_total = $("#sub_total").val();
            let percentage = $("#percentage").val();

            if (percentage == 1) {
                var discount_price = (sub_total * value) / 100;
                var discounted_value = $("#discount_price").val(sub_total - discount_price);
            } else {
                var discount_price = sub_total - value;
                var discounted_value = $("#discount_price").val(discount_price);
            }
            vatValue();
            dueAmount();
            return discounted_value;
        }

        function vatValue() {
            var value = $("#vat").val();
            var discounted_price = parseFloat($("#discount_price").val());
            var vat_price = (discounted_price * value) / 100;
            var total_prices = $("#total_price").val(parseInt(discounted_price + vat_price));
            $("#due_amount").val(parseInt(discounted_price + vat_price));
            discountValue();
            dueAmount();
            return total_prices;
        }

        function dueAmount() {
            var paid_amount = $("#paid_amount").val();
            var total_amount = $("#total_price").val();
            due_amount = $("#due_amount").val(parseInt(total_amount - paid_amount));
        }

        $(document).on('keyup', '#paid_amount', function() {
            dueAmount();
        })



        $(document).on('change', '#supplier_id', function() {
            var supplier_id = $(this).val();
            if (supplier_id == '0') {
                $('.new_supplier').show();
                $('#supplier_name').attr("required", true);
            } else {
                $('.new_supplier').hide();
                $('#supplier_name').attr("required", false);
            }
        });

        function getAccount() {
            let id = $("#method_id").val();
            let url = '/admin/data-get/account/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    let html = '';
                    html += `<option value="">` + 'Select One' + `</option>`
                    response.forEach(element => {
                        html += '<option value=' + element.id + '>' + element.account_name +
                            '</option>'
                    });
                    $("#account_id").html(html);
                }
            });
        }

        function getSupplierInfo() {
            let id = $("#supplier_id").val();
            let url = '/admin/data-get/supplier/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    if (id == 0) {
                        $("#amount_des").html('Supplier Balance : ')
                        $("#amount").html(0);
                        $("#amount_type").html('')
                    } else {
                        if (response.total_amount - (response.paid_amount + response.return_amount) > 0) {
                            $("#amount_des").html(response.supplier_name + ' Balance : ')
                            $("#amount").html(response.total_amount - (response.paid_amount + response
                                .return_amount));
                            $("#amount_type").html(' (dr)')
                        } else {
                            $("#amount_des").html(response.supplier_name + ' Balance : ')
                            $("#amount").html(Math.abs(response.total_amount - (response.paid_amount + response
                                .return_amount)));
                            $("#amount_type").html(' (cr)')
                        }
                    }
                }
            });
        }


        $(document).on('change', '#unit_id', function() {
            var unit_id = $(this).val();
            var random_number = $(this).attr('random_number');
            var product_id = $(`.product_id-${random_number}`).val();

            $.ajax({
                type: "GET",
                url: "{{ route('requisition.get.product') }}",
                data: {
                    product_id: product_id,
                    unit_id: unit_id,
                },
                success: function(result) {
                    // if (result.purchase_product) {
                    //     purchase_rate = result.purchase_product.amount / result.purchase_product.qty
                    //     $(`.unitPrice-${random_number}`).val(purchase_rate);
                    //     $(`.salePrice-${random_number}`).val(result.purchase_product
                    //         .actual_sale_amount);
                    // } else {
                    //     $(`.unitPrice-${random_number}`).val(result.product.purchase_price ? result
                    //         .product.purchase_price : 0);
                    //     $(`.salePrice-${random_number}`).val(result.product.sale_price ? result.product
                    //         .sale_price : 0);
                    // }
                    $(`.unitPrice-${random_number}`).val(result.product.purchase_price ? result
                            .product.purchase_price : 0);
                    $(`.salePrice-${random_number}`).val(result.product.sale_price ? result.product
                        .sale_price : 0);
                }
            })
        })
    </script>

    <script>
        $(document).on('submit', '#add_product_form', function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            const href = $(this).attr('action');
            $.ajax({
                url: href,
                method: "POST",
                data: fd,
                catch: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(resp) {
                    if (resp.status == 'success') {
                        $('#add_product_form')[0].reset();
                        $('.bs-example-modal-md').modal('hide');
                        toastr.success(resp.message);
                    }
                    if (resp.status == 'error') {
                        $.each(resp.errors, function(i, error) {
                            $("#product-add-" + i).attr('style', 'color:red');
                            $("#product-add-" + i).html(error);
                            setTimeout(function() {
                                $('#product-add-' + i).css({
                                    'display': 'none'
                                });
                            }, [3000]);
                        });
                    }
                },
                error: function(err) {
                    toastr.error('Something went wrong!');
                }
            });
        });

        $(document).on('submit', '#add_category_form', function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            const href = $(this).attr('action');
            $.ajax({
                url: href,
                method: "POST",
                data: fd,
                catch: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(resp) {
                    if (resp.status == 'success') {
                        $('#add_category_form')[0].reset();
                        toastr.success(resp.message);
                    }
                    if (resp.status == 'error') {
                        $.each(resp.errors, function(i, error) {
                            $("#category-add-" + i).attr('style', 'color:red');
                            $("#category-add-" + i).html(error);
                            setTimeout(function() {
                                $('#category-add-' + i).css({
                                    'display': 'none'
                                });
                            }, [3000]);
                        });
                    }
                },
                error: function(err) {
                    toastr.error('Something went wrong!');
                }
            });
        });

        $(document).on('click', '#product_tab', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('get-all-purchase-data') }}",
                method: "GET",
                success: function(resp) {
                    var sizeHtml = '';
                    var categoryHtml = '';
                    categoryHtml += `<option value="">` + 'Select One' + `</option>`
                    $.each(resp.categories, function(key, v) {
                        categoryHtml += `
                            <option value="${v.id}">${v.category_name}</option>
                        `;
                    });
                    $("#category_id").html(categoryHtml);
                },
                error: function(err) {
                    toastr.error('Something went wrong!');
                }
            });
        });
    </script>
@endsection

