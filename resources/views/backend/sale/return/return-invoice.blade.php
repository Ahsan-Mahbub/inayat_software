@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Return : {{ $sale->invoice }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Sale Return</li>
                    <li class="breadcrumb-item active">Return Product</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('sale.return.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Customer Name</label>
                            <input type="hidden" name="customer_id" value="{{ $sale->customer_id }}">
                            <input class="form-control" value="{{$sale->customer ? $sale->customer->customer_name : ''}}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Invoice</label>
                            <input type="hidden" id="sale_id" name="sale_id" value="{{ $sale->id }}">
                            <input class="form-control" value="{{$sale->invoice}}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Date</label>
                            <input class="form-control" type="date" name="date" required min="{{$sale->date}}">
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <h4 class="header-title mt-4 mb-3">All Product : {{$sale->invoice}}</h4>
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                        <th>Product Code &nbsp;</th>
                                        <th>Watt &nbsp;</th>
                                        <th>Now Sale Qty &nbsp;</th>
                                        <th>Return Qty &nbsp;</th>
                                        <th>Return Amount &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale_products as $sale_product) 
                                    <tr>
                                        <?php
                                            $sale_return = App\Models\SaleReturn::where('sale_id', $sale->id)->where('product_id', $sale_product->product_id)->first();
                                        ?>

                                        <td>{{$sale_product->product ? $sale_product->product->product_name : ''}}</td>
                                        <input type="hidden" value="{{$sale_product->product_id}}" name="product_id[]">
                                        <input type="hidden" value="{{$sale_product->id}}" name="sale_product_id[]">
                                        <td>
                                            {{$sale_product->unit ? $sale_product->unit->unit_name : ''}}
                                            <input type="hidden" name=unit_id[] class="form-control" value="{{$sale_product->unit ? $sale_product->unit->id : ''}}">
                                        </td>

                                        <td>
                                            <input class="form-control price" type="number" id="sale_qty-{{$sale_product->id}}"
                                                name="sale_qty" @if($sale_return) value="{{$sale_product->qty - $sale_return->qty}}" @else value="{{$sale_product->qty}}" @endif placeholder="Sale Qty" readonly
                                                required>
                                        </td>
                                        <td>
                                            <input class="form-control return-qty" type="number" id="qty-{{$sale_product->id}}"
                                                name="qty[]" @if($sale_return) max="{{$sale_product->qty - $sale_return->qty}}" @else max="{{$sale_product->qty}}" @endif placeholder="Return Qty" sale_product_id="{{$sale_product->id}}">
                                        </td>
                                        <td>
                                            <input class="form-control return_price" type="number" id="amount-{{$sale_product->id}}"
                                                name="amount[]" value="0" placeholder="Return Product Amount" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" class="text-right">Total Return Amount</td>
                                        <td>
                                            <input class="form-control" id="total_return_amount"
                                                name="total_return_amount" value="0" readonly
                                                required>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="submit">Return Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('script')
<script>

    $(document).on('keyup', '.return-qty', function(){
        var sale_product_id = $(this).attr('sale_product_id');
        var unit_id = $(`#unit_id-${sale_product_id}`).val();

        $.ajax({
            type: "GET",
            url: "{{route('sale.return.get.product')}}",
            data: {
                sale_product_id: sale_product_id,
            },
            success: function(result) {
                if(unit_id == result.product.primary_unit_id)
                {
                    let return_qty = 0;
                    for (let i = 0; i < result.sale_return.length; i++) {
                        return_qty += result.sale_return[i].qty;
                    }
                    var sale_qty =result.qty - return_qty;
                    $(`#sale_qty-${sale_product_id}`).val(sale_qty);
                    var price = result.discount_amount/sale_qty;
                    var sale_qty = $(`#qty-${sale_product_id}`).val();
                    subtotal(result.id, price, sale_qty);

                }else if(unit_id == result.product.second_unit_id)
                {
                    let return_qty = 0;
                    for (let i = 0; i < result.sale_return.length; i++) {
                        return_qty += result.sale_return[i].qty;
                    }

                    var sale_qty =((result.qty - return_qty)*result.product.conversation_factor);
                    $(`#sale_qty-${sale_product_id}`).val(sale_qty);
                    var price = result.discount_amount/sale_qty;
                    var sale_qty = $(`#qty-${sale_product_id}`).val();
                    subtotal(result.id, price, sale_qty);
                    
                }else if(unit_id == result.product.third_unit_id)
                {
                    let return_qty = 0;
                    for (let i = 0; i < result.sale_return.length; i++) {
                        return_qty += result.sale_return[i].qty;
                    }

                    var sale_qty =((result.qty - return_qty)*result.product.conversation_factor)*result.product.second_conversation_factor;
                    $(`#sale_qty-${sale_product_id}`).val(sale_qty);
                    var price = result.discount_amount/sale_qty;
                    var sale_qty = $(`#qty-${sale_product_id}`).val();
                    subtotal(result.id, price, sale_qty);
                }
                totalReturnAmount();
            }
        })
    })

    function subtotal(sale_product_id,price, qty)
    {
        var amount = parseInt(price*qty);
        $(`#amount-${sale_product_id}`).val(amount ? amount : 0);

    }

    function totalReturnAmount() {
        var total_return_amount = 0;
        var single_subtotal_element = document.getElementsByClassName(
            "return_price");
        Array.from(single_subtotal_element).forEach((ele) => {
            total_return_amount += ele.value ? parseInt(ele.value) : 0;
        });

        $("#total_return_amount").val(total_return_amount);
    };
</script>
@endsection