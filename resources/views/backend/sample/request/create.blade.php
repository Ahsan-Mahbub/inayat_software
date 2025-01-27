@extends('backend.layouts.app')
@section('content')
    <style type="text/css">
        .block {
            margin-bottom: 0;
        }
        .new_customer{
            display: none;
        }
        .setProductName p{
            padding: 12px 15px;
            box-shadow: 1px 1px 0px 2px #ddd;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 10px
        }
        .des-editor{
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Add Sample Request</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Sample Request</li>
                        <li class="breadcrumb-item active">Add Sample Request</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['customer']['create'])
        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Client</button>
        @endisset
        @isset(auth()->user()->role->permission['permission']['sample-request']['index'])
        <a href="{{route('sample.request.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Sample Request List</a>
        @endisset
    </div>
    <form method="post" action="{{route('sample.request.store')}}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Date</label>
                                    <input type="date" readonly class="form-control" name="date" value="<?php echo date('Y-m-d');?>">
                                </div>
                            </div>
                            @if(Auth::user()->role_id == 1)
                            <div class="col-md-3 pb-3">
                                <label class="form-label">Creator Name</label>
                                <div class="">
                                    <select class="custom-select select2" name="user_id" id="user_id" required="">
                                        <option value="">Select One</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} - ({{$user->role ? $user->role->role_name : 'N/A'}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3 pb-3">
                                <label class="form-label">Client Name</label>
                                <div class="">
                                    <select class="custom-select select2" name="customer_id" id="customer_id" onchange="getCustomerInfo()" required="">
                                        <option value="">Select One</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }} @if($customer->phone) - {{$customer->phone}} @endif @if($customer->company_name) - {{$customer->company_name}} @endif</option>
                                        @endforeach
                                        <option value="0">Add New Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pb-3 new_customer">
                                <div class="form-floating">
                                    <label class="form-label">Client Name</label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Client Name">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3 new_customer">
                                <div class="form-floating">
                                    <label class="form-label">Client Phone Number</label>
                                    <input type="tel" class="form-control" name="phone" id="customer_phone" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="col-md-12 text-center pb-2 text-success">
                                <strong id="amount_des"></strong><strong id="amount"></strong><small id="amount_type"></small>
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
                                <label class="form-label">Product</label>
                            </div>
                            <div class="col-1">
                                <label class="form-label">Des.</label>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Unit</label>
                            </div>
                            <div class="d-none">
                                <label class="form-label">Sale</label>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Qty</label>
                            </div>
                            <div class="d-none">
                                <label class="form-label">Amount</label>
                            </div>
                            <div class="col-1">
                                <label class="form-label">Action</label>
                            </div>
                        </div>
                        <div class="add_item" id="add_item">
                            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                                <div class="row mb-1">
    
                                    <input type="hidden" name="product_id[]" class="product_id product_id-202112" value="">
    
                                    <div class="col-4">
                                        <input type="text" class="form-control search_product search_product-202112" name="product_name[]" placeholder="Search by Product Code.." value="" >
                                    </div>
                                    <div class="col-1">
                                        <input type="checkbox" id="showDes-202112">
                                        <input type="hidden" value="0" name="des_show[]" id="valueDes-202112">
                                    </div>
                                    <div class="col-3">
                                        <select class="custom-select unit-202112" required="" name="unit_id[]" id="unit_id" required random_number="202112">
                                            <option value="">Select One</option>
                                            @foreach($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>  
                                    <div class="d-none">
                                        <input type="hidden" id="textToNumber" class="form-control purchasePrice-202112" name="purchase_price[]" placeholder="Purchase Price.." readonly required>
                                        <input type="text" id="textToNumber" class="form-control salePrice-202112" name="unit_price[]" placeholder="Sale Price.." required readonly>
                                    </div>                             
                                    <div class="col-3">
                                        <input type="text" class="form-control buyingQty-202112" name="buying_qty[]" placeholder="Qty.." required>
                                        
                                        <div class="mt-1"><span>Total Stock : </span><span class="stock-202112">0</span></div> 
                                    </div>
                                    <div class="d-none">
                                        <input type="text" class="form-control amount amount-202112 single_subtotal single_subtotal-202112" name="amount[]" id="single_subtotal" readonly value="0">
                                    </div>   
                                    <div class="col-1">
                                        <button type="button" class="btn btn-success me-1 mb-1 addEvenMore">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="col-12 des-editor des-editor-202112 mt-2">
                                        <textarea class="form-control editor" id="description-202112" name="description[]" placeholder="Description"></textarea>
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

                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Sub Total</label>
                                    <input type="text" readonly id="sub_total" class="form-control" name="subtotal"
                                        required="" value="0">
                                </div>

                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Discount</label>
                                    <select name="discount" class="form-control" id="discount" onclick="discountValue()">
                                        <option value="0">Select One</option>
                                        @if($discount)
                                            @for ($i = 1; $i <= $discount->discount; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">After Discount Amount</label>
                                    <input type="text" class="form-control" readonly id="discount_price"
                                        name="discount_price" required="" value="0">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">VAT (%)</label>
                                    <input type="text" class="form-control" name="vat" id="vat"
                                        onkeyup="vatValue()" required="" value="0">
                                    <input type="hidden" id="vat_price">
                                    <input type="hidden" id="vat_actual_price" name="vat_amount">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">TAX (%)</label>
                                    <input type="text" class="form-control" name="tax" id="tax"
                                        onkeyup="taxValue()" required="" value="0">
                                    <input type="hidden" id="tax_price">
                                    <input type="hidden" id="tax_actual_price" name="tax_amount">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">AIT (%)</label>
                                    <input type="text" class="form-control" name="ait" id="ait"
                                        onkeyup="aitValue()" required="" value="0">
                                    <input type="hidden" id="ait_price">
                                    <input type="hidden" id="ait_actual_price" name="ait_amount">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Total</label>
                                    <input type="text" readonly class="form-control" name="total_amount"
                                        id="total_price" required="" value="0">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="validationCustom04">Terms & Condition : </label> <input type="checkbox" name="show_terms" value="1">
                <textarea class="form-control editor" name="trams_condition" placeholder="Terms & Condition">{{$info->sample_trams}}</textarea>
            </div>
            <div class="col-md-12 pb-3 text-center">
                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                    Submit Sample Request
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

    {{-- Add Modal --}}
    <div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate="" action="{{route('customer.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">Client Name *</label>
                                <input type="text" class="form-control" id="validationCustom01" name="customer_name" placeholder="Name" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">Email </label>
                                <input type="email" class="form-control" id="validationCustom02" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom03">Phone Number </label>
                                <input type="tel" class="form-control" id="validationCustom03" name="phone" placeholder="Phone">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom03">Designation </label>
                                <input type="text" class="form-control" id="validationCustom03" name="designation" placeholder="Designation">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom03">Company Name </label>
                                <input type="text" class="form-control" id="validationCustom03" name="company_name" placeholder="Company Name">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom04">Address</label>
                                <textarea class="form-control" id="validationCustom04" name="address" placeholder="Address"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom04">Delivery Address</label>
                                <textarea class="form-control" id="validationCustom04" name="delivery_address" placeholder="Delivery Address"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom05">Image </label>
                                <div class="col-lg-12">
                                    <input type='file' class="form-control" id="validation05" name="image" onchange="readURL(this);" />
                                    <img id="image" src="/demo.svg" height="200" width="250" alt="property" /><br>
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
            // Initialize TinyMCE
            tinymce.init({
                selector: '.editor',
                setup: function(editor) {
                    editor.on('init', function(e) {
                        // Ensure the editor is hidden initially if the parent is hidden
                        if (!$(editor.targetElm).parent().is(":visible")) {
                            editor.hide();
                        }
                    });
                }
            });

            // Toggle description textarea visibility based on checkbox
            $('#showDes-202112').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                    $('#valueDes-202112').val(1);
                    $('.des-editor-202112').show();
                    tinymce.get('description-202112').show();
                } else {
                    $('#valueDes-202112').val(0);
                    tinymce.get('description-202112').hide();
                    $('.des-editor-202112').hide();
                }
            });

            $("body").on("keyup", ".search_product-202112", function(e) {
                var random_number = 202112;
                var className = "search_product-" + random_number;
                var classNameID = "product_id-" + random_number;
                var priceClassName = "salePrice-" + random_number;
                var purchaseClassName = "purchasePrice-" + random_number;
                var desIdName = "description-" + random_number;

                let searchData = e.target.value;
                let searchDataLength = searchData.length;
                
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "GET",
                    url: "sample-request-search-product",
                    data: {
                        search: searchData,
                        searchDataLength: searchDataLength,
                    },
                    success: function(result) {

                        var searchHtml = '';
                        $.each(result.products, function(key, v) {
                            var class_name = `setProductName-${v.id}-${result.rand}`;
                            searchHtml += `
                                <div class="col-md-4 col-xl-3 col-12 requisition_product" data-id="${v.id}" style="cursor: pointer;">
                                    <a class="block setProductName ${class_name}" rand="${result.rand}" product_id="${v.id}">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="font-size-lg font-w600">
                                                    ${v.product_name} ( ${v.category.category_name} ) <br>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `
                            $(document).on('click', "." + class_name, function() {
                                var product_id = $(this).attr('product_id');
                                var rand = $(this).attr('rand');
                                var gen_class_name ="setProductName-" + result.rand;
                                $("." + className).val(product_id);
                                $(".show_get_search_product").html('');

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('sample-request-get-product-details') }}",
                                    type: "POST",
                                    data: {
                                        product_id: product_id
                                    },
                                    success: function(resp) {
                                        $("." +classNameID).val(resp.productDetails.id);
                                        $("." +className).val(resp.productDetails.product_name);
                                        $("." +priceClassName).val(resp.productDetails.sale_price ? resp.productDetails.sale_price : 0);
                                        $("." +purchaseClassName).val(resp.productDetails.purchase_price ? resp.productDetails.purchase_price : 0);
                                        tinymce.get(desIdName).setContent(resp.productDetails.description);

                                        let buyingPriceElements =document.getElementsByClassName('salePrice-' +random_number);
                                        let buyingQtyElements =document.getElementsByClassName('buyingQty-' +random_number);
                                        let vatElements =document.getElementsByClassName('vat-' +random_number);
                                        let taxElements =document.getElementsByClassName('tax-' +random_number);
                                        let aitElements =document.getElementsByClassName('ait-' +random_number);
                                        let amountElements =document.getElementsByClassName('amount-' +random_number);

                                        var buyingPrice = 0;
                                        var buyingQty = 0;
                                        var vat = 0;
                                        var tax = 0;
                                        var ait = 0;
                                        Array.from(buyingPriceElements).forEach((buyingPriceElement) => {
                                            
                                            buyingPriceElement.addEventListener('keyup',function(e) {
                                                    buyingPrice=e.target.value;
                                                    if (/^\d*$/.test(buyingPrice)) {
                                                        updateAmount();
                                                        subtotal();
                                                    } else {
                                                        buyingPriceElement.value ='';
                                                    }
                                                }
                                            );
                                        });
                                        Array.from(buyingQtyElements).forEach((buyingQtyElement) => {
                                            buyingQtyElement.addEventListener('keyup',function(e) {
                                                        buyingQty=e.target.value;
                                                        if (/^\d*$/.test(buyingQty)) {
                                                            updateAmount();
                                                            subtotal();
                                                        } else {
                                                            buyingQtyElement.value ='';
                                                        }
                                                    }
                                                );
                                        });

                                        function updateAmount() {Array.from(amountElements).forEach((amountElement) => {
                                                var price = $('.salePrice-' +random_number).val();
                                                var qty = $('.buyingQty-' +random_number).val();
                                                amountElement.value =price * qty;
                                            });
                                        }
                                    },
                                    error: function() {
                                        toastr.error(" Product Doesn't Added","Error");
                                    }
                                });

                            });
                        })

                        if(searchHtml)
                        {
                            $(".show_get_search_product").html(searchHtml);    
                        }else{
                            $(".show_get_search_product").html(`
                                <div class="d-flex pl-3 pt-2 pb-2" style="justify-content: space-between;">
                                    <div>
                                        <span class="text-danger">Product Not Found</span>
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
                                <div class="col-1">
                                    <input type="checkbox" id="showDes-${random_number}">
                                    <input type="hidden" value="0" name="des_show[]" id="valueDes-${random_number}">
                                </div>
                                <div class="col-3">
                                    <select class="custom-select unit-${random_number}" required="" name="unit_id[]" id="unit_id" required random_number="${random_number}">
                                        ${unitOptions}
                                    </select>
                                </div> 
                                <div class="d-none">
                                    <input type="hidden" id="textToNumber" class="form-control purchasePrice-${random_number}" name="purchase_price[]" placeholder="Purchase Price.." readonly required>
                                    <input type="text" id="textToNumber" class="form-control salePrice-${random_number}" name="unit_price[]" placeholder="Sale Price.." required readonly>
                                </div>                             
                                <div class="col-3">
                                    <input type="text" class="form-control buyingQty-${random_number}" name="buying_qty[]" placeholder="Qty.." required>

                                    <div class="mt-1"><span>Total Stock : </span><span class="stock-${random_number}">0</span></div> 
                                </div>
                                <div class="d-none">
                                    <input type="text" class="form-control amount amount-${random_number} single_subtotal single_subtotal-${random_number}" name="amount[]" id="single_subtotal" readonly value="0">
                                </div>   
                                <div class="col-1">
                                    <button type="button" class="btn btn-success me-1 mb-1 addEvenMore">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger me-1 mb-1 removeEvenMore">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <div class="col-12 des-editor des-editor-${random_number} mt-2">
                                    <textarea class="form-control editor" id="description-${random_number}" name="description[]" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                    `);

                

                // Use delegated event binding to handle dynamically generated elements
                $(document).on('change', `#showDes-${random_number}`, function() {
                    const editor = tinymce.get(`description-${random_number}`);
                    if ($(this).is(':checked')) {
                        $(`#valueDes-${random_number}`).val(1);
                        $(`.des-editor-${random_number}`).show();
                        if (editor) {
                            editor.show();
                        }
                    } else {
                        if (editor) {
                            editor.hide();
                        }
                        $(`#valueDes-${random_number}`).val(0);
                        $(`.des-editor-${random_number}`).hide();
                    }
                });

                // Initialize TinyMCE editor for the dynamically generated textarea
                tinymce.init({
                    selector: `#description-${random_number}`,
                    height: 150,
                    setup: function(editor) {
                        editor.on('init', function() {
                            // Initially hide the editor if checkbox is not checked
                            if (!$(`#showDes-${random_number}`).is(':checked')) {
                                editor.hide();
                            }
                        });
                    }
                });

                counter++;

                $(document).on("click", ".removeEvenMore", function(event) {
                    $(this).closest(".delete_whole_extra_item_add").remove();
                    subtotal();
                    discountValue();
                    vatValue();
                    taxValue();
                    aitValue();
                    toastr.warning(" Product Removed", "Remove");
                });
                var className = "search_product-" + random_number;
                var classNameID = "product_id-" + random_number;
                var priceClassName = "salePrice-" + random_number;
                var purchaseClassName = "purchasePrice-" + random_number;
                var desIdName = "description-" + random_number;
                
                $("body").on("keyup", "." + className, function(e) {
                    let searchData = e.target.value;
                    let searchDataLength = searchData.length;
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: "GET",
                        url: "sample-request-search-product",
                        data: {
                            search: searchData,
                            searchDataLength: searchDataLength,
                        },
                        success: function(result) {

                            var searchHtml = '';
                            $.each(result.products, function(key, v) {
                                var class_name =
                                    `setProductName-${v.id}-${result.rand}`;
                                searchHtml += `
                                <div class="col-md-4 col-xl-3 col-12 requisition_product" data-id="${v.id}" style="cursor: pointer;">
                                    <a class="block setProductName ${class_name}" rand="${result.rand}" product_id="${v.id}">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="font-size-lg font-w600 mb-0">
                                                    ${v.product_name} ( ${v.category.category_name} ) <br>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `
                                $(document).on('click', "." + class_name, function() {
                                        var product_id = $(this).attr('product_id');
                                        var rand = $(this).attr('rand');
                                        var gen_class_name ="setProductName-" + result.rand;
                                        $("." + className).val(product_id);
                                        $(".show_get_search_product").html('');

                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "{{ route('sample-request-get-product-details') }}",
                                            type: "POST",
                                            data: {
                                                product_id: product_id
                                            },
                                            success: function(resp) {
                                                $("." +classNameID).val(resp.productDetails.id);
                                                $("." +className).val(resp.productDetails.product_name);
                                                $("." +priceClassName).val(resp.productDetails.sale_price ? resp.productDetails.sale_price : 0);
                                                $("." +purchaseClassName).val(resp.productDetails.purchase_price ? resp.productDetails.purchase_price : 0);
                                                
                                                tinymce.get(desIdName).setContent(resp.productDetails.description);

                                                let buyingPriceElements =document.getElementsByClassName('salePrice-' +random_number);
                                                let buyingQtyElements =document.getElementsByClassName('buyingQty-' +random_number);
                                                let vatElements =document.getElementsByClassName('vat-' +random_number);
                                                let taxElements =document.getElementsByClassName('tax-' +random_number);
                                                let aitElements =document.getElementsByClassName('ait-' +random_number);
                                                let amountElements =document.getElementsByClassName('amount-' +random_number);


                                                var buyingPrice = 0;
                                                var buyingQty = 0;
                                                var vat = 0;
                                                var tax = 0;
                                                var ait = 0;
                                                Array.from(buyingPriceElements).forEach((buyingPriceElement) => {
                                                    
                                                    buyingPriceElement.addEventListener('keyup',function(e) {
                                                            buyingPrice=e.target.value;
                                                            if (/^\d*$/.test(buyingPrice)) {
                                                                updateAmount();
                                                                subtotal();
                                                            } else {
                                                                buyingPriceElement.value ='';
                                                            }
                                                        }
                                                    );
                                                });
                                                Array.from(buyingQtyElements).forEach((buyingQtyElement) => {
                                                    buyingQtyElement.addEventListener('keyup',function(e) {
                                                                buyingQty=e.target.value;
                                                                if (/^\d*$/.test(buyingQty)) {
                                                                    updateAmount();
                                                                    subtotal();
                                                                } else {
                                                                    buyingQtyElement.value ='';
                                                                }
                                                            }
                                                        );
                                                });

                                                function updateAmount() {Array.from(amountElements).forEach((amountElement) => {
                                                        var price = $('.salePrice-' +random_number).val();
                                                        var qty = $('.buyingQty-' +random_number).val();
                                                        amountElement.value =price * qty;
                                                    });
                                                }
                                            },
                                            error: function() {
                                                toastr.error(" Product Doesn't Added","Error");
                                            }
                                        });

                                    });
                            })

                            if(searchHtml)
                            {
                                $(".show_get_search_product").html(searchHtml);    
                            }else{
                                $(".show_get_search_product").html(`
                                    <div class="d-flex pt-2 pl-3 pb-2" style="justify-content: space-between;">
                                        <div>
                                            <span class="text-danger">Product Not Found</span>
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
            var single_subtotal_element = document.getElementsByClassName("single_subtotal");
            Array.from(single_subtotal_element).forEach((ele) => {
                total_subtotal += parseInt(ele.value);
            });
            $("#sub_total").val(total_subtotal);
            calculateValues();
        }

        // $(document).on('click', '#percentage', function() {
        //     var value = $(this).val();
        //     $(this).val(value == 0 ? 1 : 0);
        //     $("#discount").val('');
        //     calculateValues();
        // })

        function discountValue() {
            calculateValues();
        }
        function vatValue() {
            calculateValues();
        }
        function taxValue() {
            calculateValues();
        }

        function aitValue() {
            calculateValues();
        }

        function calculateValues() {
            var sub_total = parseFloat($("#sub_total").val()) || 0;
            var discount = parseFloat($("#discount").val()) || 0;
            var vat = parseFloat($("#vat").val()) || 0;
            var tax = parseFloat($("#tax").val()) || 0;
            var ait = parseFloat($("#ait").val()) || 0;
            var isPercentage = 1;

            // Calculate discount
            var discount_value = isPercentage ? (sub_total * discount / 100) : discount;
            var discounted_price = sub_total - discount_value;
            $("#discount_price").val(discounted_price.toFixed(2));

            // Calculate VAT
            var vat_value = (discounted_price * vat / 100);
            var price_with_vat = discounted_price + vat_value;
            $("#vat_price").val(price_with_vat.toFixed(2));
            $("#vat_actual_price").val(vat_value.toFixed(2));

            // Calculate Tax
            var tax_value = (price_with_vat * tax / 100);
            var price_with_tax = price_with_vat + tax_value;
            $("#tax_price").val(price_with_tax.toFixed(2));
            $("#tax_actual_price").val(tax_value.toFixed(2));

            // Calculate AIT
            var ait_value = (price_with_tax * ait / 100);
            var price_with_ait = price_with_tax + ait_value;
            $("#ait_price").val(price_with_ait.toFixed(2));
            $("#ait_actual_price").val(ait_value.toFixed(2));

            // Set total price
            $("#total_price").val(price_with_ait.toFixed(2));
        }

        $(document).on('change', '#unit_id', function(){
            var unit_id = $(this).val();
            var random_number = $(this).attr('random_number');
            var product_id = $(`.product_id-${random_number}`).val();

            $.ajax({
                type: "GET",
                url: "{{route('sample.request.get.product')}}",
                data: {
                    product_id: product_id,
                    unit_id: unit_id,
                },
                success: function(result) {
                    if(result.available_stock > 0)
                    {
                        if((result.purchase_product.amount / result.purchase_product.qty) > 0){
                            var purchase_rate = result.purchase_product.amount / result.purchase_product.qty;
                            $(`.purchasePrice-${random_number}`).val(purchase_rate);
                        }

                        if(result.product.sale_price > 0){
                            $(`.salePrice-${random_number}`).val(result.purchase_product.product.sale_price);
                        }else{
                            var unit_rate = result.purchase_product.actual_sale_amount;
                            $(`.salePrice-${random_number}`).val(unit_rate);
                            $(`.salePrice-${random_number}`).val(result.purchase_product.actual_sale_amount);
                        }
                        var stock = result.available_stock;
                        $(`.stock-${random_number}`).text(stock);
                    }
                    else{
                        // Sale
                        $(`.stock-${random_number}`).text(0);
                    }
                }
            })
        })

    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).on('change', '#customer_id', function(){
            var customer_id = $(this).val();
            if (customer_id == '0') {
                $('.new_customer').show();
                $('#customer_name').attr("required", true);
            }
            else{
                $('.new_customer').hide();
                $('#customer_name').attr("required", false);
            }
        });

        function getCustomerInfo() {
            let id = $("#customer_id").val();
            let url = '/admin/data-get/customer/' + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    if(id == 0)
                    {
                        $("#amount_des").html('Client Balance : ');
                        $("#amount").html(0);
                        $("#amount_type").html('');
                    }else{
                        if(response.total_amount - (response.paid_amount + response.return_amount) > 0){
                            $("#amount_des").html(response.customer_name +' Balance : ')
                            $("#amount").html(response.total_amount - (response.paid_amount + response.return_amount));
                            $("#amount_type").html(' (dr)')
                        }else{
                            $("#amount_des").html(response.customer_name +' Balance : ')
                            $("#amount").html(Math.abs(response.total_amount - (response.paid_amount + response.return_amount)));
                            $("#amount_type").html(' (cr)')
                        }
                    }
                }
            });
        }
    </script> 
@endsection
