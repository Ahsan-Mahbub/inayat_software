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
                <h4 class="mb-0 font-size-18">Update Sample Request</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Sample Request</li>
                        <li class="breadcrumb-item active">Update Sample Request</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['sample-request']['index'])
        <a href="{{route('sample.request.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Sample Request List</a>
        @endisset
    </div>
    <form method="post" action="{{route('sample.request.update', $request->id)}}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Date</label>
                                    <input type="date" readonly class="form-control" name="date" value="{{$request->date}}">
                                    <input type="hidden" class="form-control" name="creator_id" value="{{$request->creator_id}}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <label class="form-label">Client Name</label>
                                <div class="">
                                    <select class="custom-select select2" name="customer_id" id="customer_id" onchange="getCustomerInfo()" required="">
                                        <option value="">Select One</option>
                                        @if ($customer)
                                            <option value="{{ $customer->id }}" {{$request->customer_id == $customer->id ? 'selected' : ''}}>{{ $customer->customer_name }} @if($customer->phone) - {{$customer->phone}} @endif @if($customer->company_name) - {{$customer->company_name}} @endif</option>
                                        @endif
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
                            <input type="hidden" name="request_main" value="{{$request->duplicate_requ ? $request->duplicate_requ : $request->id}}">
                            
                            @foreach($request->requestProduct as $product)
                            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                                    <div class="row mb-1">
        
                                        <input type="hidden" name="product_id[]" class="product_id product_id-{{$product->id}}" value="{{$product->product_id}}">
        
                                        <div class="col-4">
                                            <input type="text" class="form-control search_product search_product-{{$product->id}}" name="product_name[]" placeholder="Search by Product Code.." value="{{$product->product ? $product->product->product_name : ''}}" readonly>
                                        </div>
                                        <div class="col-1">
                                            <input type="checkbox" class="showDes" random="{{$product->id}}" id="showDes-{{$product->id}}" @if($product->des_show == 1) checked @endif>
                                            <input type="hidden" @if($product->des_show == 1) value="1" @else value="0" @endif name="des_show[]" id="valueDes-{{$product->id}}">
                                        </div>
                                        <div class="col-3">
                                            <select class="custom-select unit-{{$product->id}}" required="" name="unit_id[]" id="unit_id">
                                                @foreach($units as $unit)
                                                <option value="{{$unit->id}}" {{$product->unit_id == $unit->id ? 'selected' : '' }}>{{$unit->unit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                        <div class="d-none">
                                            <input type="hidden" id="textToNumber" class="form-control purchasePrice-{{$product->id}}" name="purchase_price[]" placeholder="Purchase Price.." value="{{$product->purchase_price}}" readonly required>
                                            <input type="text" id="textToNumber" class="form-control salePrice-{{$product->id}}" name="unit_price[]" placeholder="Sale Price.." value="{{$product->sale_price}}" required readonly>
                                        </div>                             
                                        <div class="col-3">
                                            <input type="text" class="form-control buyingQty buyingQty-{{$product->id}}" name="buying_qty[]" value="{{$product->qty}}" random={{$product->id}} placeholder="Qty.." required>
                                        </div>
                                        <div class="d-none">
                                            <input type="text" class="form-control amount amount-{{$product->id}} single_subtotal single_subtotal-{{$product->id}}" name="amount[]" value="{{$product->amount}}" id="single_subtotal" readonly value="0">
                                        </div>   
                                        <div class="col-1">
                                            <button type="button" class="btn btn-success me-1 mb-1 addEvenMore">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger me-1 mb-1 removeEvenMore">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <div class="col-12 des-editor des-editor-{{$product->id}} mt-2" @if($product->des_show == 1) style="display:block" @endif>
                                            <textarea class="form-control editor" id="description-{{$product->id}}" name="description[]" placeholder="Description">{{$product->description}}</textarea>
                                        </div>
                                    </div>
                            </div>
                            @endforeach
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
                                        required="" value="{{$request->subtotal ? $request->subtotal : 0}}">
                                </div>

                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-floating">
                                            <label class="form-label">Discount</label>
                                            {{-- <input type="text" class="form-control" name="discount" id="discount"
                                                onkeyup="discountValue()" required="" value="0"> --}}
                                            <select name="discount" class="form-control" id="discount" onclick="discountValue()">
                                                <option value="0">Select One</option>
                                                @if($discount)
                                                    @for ($i = 1; $i <= $discount->discount; $i++)
                                                        <option value="{{ $i }}" {{ $request->discount == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2 m-auto text-center">
                                        <input type="checkbox" class="form-check-input" name="percentage" id="percentage"
                                            @if($request->percentage == 1) value="1" checked @else value="0" @endif> %
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">After Discount Amount</label>
                                    <input type="text" class="form-control" readonly id="discount_price"
                                        name="discount_price" required="" value="{{$request->discount_price ? $request->discount_price : 0}}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">VAT (%)</label>
                                    <input type="text" class="form-control" name="vat" id="vat"
                                        onkeyup="vatValue()" required="" value="{{$request->vat ? $request->vat : 0}}">
                                    <input type="hidden" id="vat_price">
                                    <input type="hidden" id="vat_actual_price" name="vat_amount" value="{{$request->vat_amount ? $request->vat_amount : 0}}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">TAX (%)</label>
                                    <input type="text" class="form-control" name="tax" id="tax"
                                        onkeyup="taxValue()" required="" value="{{$request->tax ? $request->tax : 0}}">
                                    <input type="hidden" id="tax_price">
                                    <input type="hidden" id="tax_actual_price" name="tax_amount" value="{{$request->tax_amount}}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">AIT (%)</label>
                                    <input type="text" class="form-control" name="ait" id="ait"
                                        onkeyup="aitValue()" required="" value="{{$request->ait ? $request->ait : 0}}">
                                    <input type="hidden" id="ait_price">
                                    <input type="hidden" id="ait_actual_price" name="ait_amount" value="{{$request->ait ? $request->ait : 0}}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Total</label>
                                    <input type="text" readonly class="form-control" name="total_amount"
                                        id="total_price" required="" value="{{$request->total_amount}}">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label for="validationCustom04">Terms & Condition : </label> <input type="checkbox" name="show_terms" value="1" @if($request->show_terms == 1) checked @endif>
                <textarea class="form-control editor" name="trams_condition" placeholder="Terms & Condition">{{$request->trams_condition}}</textarea>
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
            $('.showDes').on('change', function() {
                var random_number = $(this).attr('random');
                alert(random_number);
                if ($(this).is(':checked')) {
                    $(this).val('1');
                    $('#valueDes-'+random_number).val(1);
                    $('.des-editor-'+random_number).show();
                    tinymce.get('description-'+random_number).show();
                } else {
                    $('#valueDes-'+random_number).val(0);
                    tinymce.get('description-'+random_number).hide();
                    $('.des-editor-'+random_number).hide();
                }
            });

            $("body").on("keyup click", ".buyingQty", function(e) {
                var random_number = $(this).attr('random');

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
                            // alert(buyingPrice);
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
                var unitOptions = '';
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
                                    <select class="custom-select unit-${random_number}" required="" name="unit_id[]" id="unit_id">
                                        ${unitOptions}
                                    </select>
                                </div> 
                                <div class="d-none">
                                    <input type="hidden" id="textToNumber" class="form-control purchasePrice-${random_number}" name="purchase_price[]" placeholder="Purchase Price.." readonly required>
                                    <input type="text" id="textToNumber" class="form-control salePrice-${random_number}" name="unit_price[]" placeholder="Sale Price.." required readonly>
                                </div>                             
                                <div class="col-3">
                                    <input type="text" class="form-control buyingQty-${random_number}" name="buying_qty[]" placeholder="Qty.." required>
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
                var desIdName = "description-" + random_number;
                
                $("body").on("keyup", "." + className, function(e) {
                    let searchData = e.target.value;
                    let searchDataLength = searchData.length;
                    var searchProductUrl = "{{ route('sample.request-search') }}";
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: "GET",
                        url: searchProductUrl,
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
                                <div class="col-md-4 col-xl-3 col-12 request_product" data-id="${v.id}" style="cursor: pointer;">
                                    <a class="block setProductName ${class_name}" rand="${result.rand}" product_id="${v.id}">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="font-size-lg font-w600 mb-0">
                                                    ${v.product_name} <br>
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

            $(document).on("click", ".removeEvenMore", function(event) {
                $(this).closest(".delete_whole_extra_item_add").remove();
                subtotal();
                discountValue();
                vatValue();
                taxValue();
                aitValue();
                toastr.warning(" Product Removed", "Remove");
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

        $(document).on('click', '#percentage', function() {
            var value = $(this).val();
            $(this).val(value == 0 ? 1 : 0);
            $("#discount").val('');
            calculateValues();
        })

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
            var isPercentage = $("#percentage").val() == 1;

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

    </script>
    <script>
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
