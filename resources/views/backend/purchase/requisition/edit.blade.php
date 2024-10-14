@extends('backend.layouts.app')
@section('content')
    <style type="text/css">
        .block {
            margin-bottom: 0;
        }
        .new_supplier{
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
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Update Quotation</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Purchase Quotation</li>
                        <li class="breadcrumb-item active">Update Quotation</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['requisition']['index'])
        <a href="{{route('requisition.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Quotation List</a>
        @endisset
    </div>

    <form method="post" action="{{route('requisition.update', $requisition->id)}}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-3 pb-3">
                                <div class="form-floating">
                                    <label class="form-label">Date</label>
                                    <input type="date" readonly class="form-control" name="date" value="{{$requisition->date}}">
                                    <input type="hidden" name="creator_id" value="{{$requisition->creator_id}}">
                                    <input type="hidden" name="requisition_main" value="{{$requisition->duplicate_requ ? $requisition->duplicate_requ : $requisition->id}}">
                                </div>
                            </div>
                            <div class="col-md-3 pb-3">
                                <label class="form-label">Supplier Name</label>
                                <div class="">
                                    <select class="custom-select select2" name="supplier_id" id="supplier_id" onchange="getSupplierInfo()" required>
                                        <option value="">Select One</option>
                                        @if ($supplier)
                                            <option value="{{ $supplier->id }}" {{$requisition->supplier_id == $supplier->id ? 'selected' : ''}}>{{ $supplier->supplier_name }} @if($supplier->phone) - {{$supplier->phone}} @endif @if($supplier->company_name) - {{$supplier->company_name}} @endif</option>
                                        @endif
                                    </select>
                                </div>
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
                            <div class="col-3">
                                <label class="form-label">Unit</label>
                            </div>
                            {{-- <div class="col-2">
                                <label class="form-label">Price</label>
                            </div> --}}
                            <div class="col-3">
                                <label class="form-label">Qty</label>
                            </div>
                            {{-- <div class="col-2">
                                <label class="form-label">Amount</label>
                            </div> --}}
                            <div class="col-2">
                                <label class="form-label">Action</label>
                            </div>
                        </div>
                        <div class="add_item" id="add_item">
                            @foreach($requisition->requisitionProduct as $product)
                            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                                <div class="row mb-1">
                                    <input type="hidden" name="product_id[]"  class="product_id product_id-{{$product->id}}"  value="{{$product->product_id}}">
    
                                    <div class="col-4">
                                        <input type="text" class="form-control search_product search_product-{{$product->id}}" id="first_product_row" name="product_name[]" placeholder="Search by Product Code.." value="{{$product->product ? $product->product->product_name : ''}}" readonly >
                                    </div>

                                    <div class="col-3">
                                        <select class="custom-select unit-{{$product->id}}" required="" name="unit_id[]" id="unit_id" required random_number="202112">
                                            <option value="">Select One</option>
                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}" {{$product->unit_id == $unit->id ? 'selected' : '' }}>{{$unit->unit_name}}</option>
                                            @endforeach
                                        </select>
                                    </div> 

                                    <div class="col-2 d-none">
                                        <input type="text" id="textToNumber" class="form-control unitPrice-{{$product->id}}" name="unit_price[]" value="{{$product->amount / $product->qty}}" placeholder="Price.." required>
                                    </div>                        
                                    <div class="col-3">
                                        <input type="text" class="form-control buyingQty-{{$product->id}}" name="buying_qty[]" value="{{$product->qty}}" placeholder="Qty.." required>
                                    </div>
                                    <div class="col-2 d-none">
                                        <input type="text" class="form-control amount amount-{{$product->id}} single_subtotal single_subtotal-{{$product->id}}" value="{{$product->amount}}" name="amount[]" id="single_subtotal" readonly value="0">
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
                                     value="{{$requisition->subtotal}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 pb-3 text-center">
                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                    Update Quotation
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
            
            $("body").on("keyup", ".search_product-202112", function(e) {
                var random_number = 202112;
                var className = "search_product-" + random_number;
                var classNameID = "product_id-" + random_number;
                var priceClassName = "unitPrice-" + random_number;
        
                let searchData = e.target.value;
                let searchDataLength = searchData.length;
                var searchProductUrl = "{{ route('requisition.search.product') }}";
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
                                    var gen_class_name ="setProductName-" + result.rand;
                                    $("." + className).val(product_id);
                                    $(".show_get_search_product").html('');
        
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ route('get-product-details') }}",
                                        type: "POST",
                                        data: {
                                            product_id: product_id
                                        },
                                        success: function(resp) {
                                            $("." +classNameID).val(resp.productDetails.id);
                                            $("." +className).val(resp.productDetails.product_name);
                                            $("." +priceClassName).val(resp.productDetails.purchase_price ? resp.productDetails.purchase_price : 0);

        
                                            let buyingPriceElements =document.getElementsByClassName('unitPrice-' +random_number);
                                            let buyingQtyElements =document.getElementsByClassName('buyingQty-' +random_number);
                                            let vatElements =document.getElementsByClassName('vat-' +random_number);
                                            let amountElements =document.getElementsByClassName('amount-' +random_number);
                                            
                                            var buyingPrice = 0;
                                            var buyingQty = 0;
                                            var vat = 0;
                                            Array.from(buyingPriceElements).forEach((buyingPriceElement) => {
                                                console.log(buyingPriceElement);
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
                                                    var price = $('.unitPrice-' +random_number).val();
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
                                <div class="col-3">
                                    <select class="custom-select unit-${random_number}" required="" name="unit_id[]" id="unit_id" required random_number="${random_number}">
                                        ${unitOptions}
                                    </select>
                                </div> 
                                <div class="col-2 d-none">
                                    <input type="text" id="textToNumber" class="form-control unitPrice-${random_number}" name="unit_price[]" placeholder="Price.." required>
                                </div>                            
                                <div class="col-3">
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
                    toastr.warning(" Product Removed", "Remove");
                });
                var className = "search_product-" + random_number;
                var classNameID = "product_id-" + random_number;
                var priceClassName = "unitPrice-" + random_number;
                
                $("body").on("keyup", "." + className, function(e) {
                    let searchData = e.target.value;
                    let searchDataLength = searchData.length;
                    var searchProductUrl = "{{ route('requisition.search.product') }}";
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
                                            url: "{{ route('get-product-details') }}",
                                            type: "POST",
                                            data: {
                                                product_id: product_id
                                            },
                                            success: function(resp) {
                                                $("." +classNameID).val(resp.productDetails.id);
                                                $("." +className).val(resp.productDetails.product_name);
                                                $("." +priceClassName).val(resp.productDetails.purchase_price ? resp.productDetails.purchase_price : 0);
                                                let buyingPriceElements =document.getElementsByClassName('unitPrice-' +random_number);
                                                let buyingQtyElements =document.getElementsByClassName('buyingQty-' +random_number);
                                                let vatElements =document.getElementsByClassName('vat-' +random_number);
                                                let amountElements =document.getElementsByClassName('amount-' +random_number);
                                                var buyingPrice = 0;
                                                var buyingQty = 0;
                                                var vat = 0;
                                                Array.from(buyingPriceElements).forEach((buyingPriceElement) => {
                                                    console.log(buyingPriceElement);
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
                                                        var price = $('.unitPrice-' +random_number).val();
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
                toastr.warning(" Product Removed", "Remove");
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
        };
    </script> 
@endsection
