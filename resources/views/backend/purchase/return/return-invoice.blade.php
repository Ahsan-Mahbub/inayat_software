@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Return : {{ $purchase->invoice }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Purchase Return</li>
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
                <form action="{{ route('purchase.return.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Supplier Name</label>
                            <input type="hidden" name="supplier_id" value="{{ $purchase->supplier_id }}">
                            <input class="form-control" value="{{$purchase->supplier ? $purchase->supplier->supplier_name : ''}}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Invoice</label>
                            <input type="hidden" id="purchase_id" name="purchase_id" value="{{ $purchase->id }}">
                            <input class="form-control" value="{{$purchase->invoice}}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Date</label>
                            <input class="form-control" type="date" name="date" required min="{{$purchase->date}}">
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <h4 class="header-title mt-4 mb-3">All Product : {{$purchase->invoice}}</h4>
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                        <th>Product Code &nbsp;</th>
                                        <th>Unit &nbsp;</th>
                                        <th>Now Stock Qty &nbsp;</th>
                                        <th>Return Qty &nbsp;</th>
                                        {{-- <th>Return Amount &nbsp;</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase_products as $purchase_product) 
                                    <tr>
                                        <?php
                                            $purchase_return = App\Models\PurchaseReturn::where('purchase_id', $purchase->id)->where('product_id', $purchase_product->product_id)->first();
                                        ?>
                                        <td>{{$purchase_product->product ? $purchase_product->product->product_name : ''}}</td>
                                        <td>
                                            {{$purchase_product->unit ? $purchase_product->unit->unit_name : ''}}
                                            <input type="hidden" name=unit_id[] class="form-control" value="{{$purchase_product->unit ? $purchase_product->unit->id : ''}}">
                                        </td>
                                        <input type="hidden" value="{{$purchase_product->product_id}}" name="product_id[]">
                                        <input type="hidden" value="{{$purchase_product->id}}" name="purchase_product_id[]">
                                        <td>
                                            <input class="form-control price" type="number" id="stock_qty-{{$purchase_product->id}}"
                                                name="stock_qty" @if($purchase_return) value="{{$purchase_product->qty - $purchase_return->qty}}" @else value="{{$purchase_product->qty}}" @endif placeholder="Stock Qty" readonly
                                                required>
                                        </td>
                                        <td>
                                            <input class="form-control return-qty" type="number" id="qty-{{$purchase_product->id}}"
                                                name="qty[]" @if($purchase_return) max="{{$purchase_product->qty - $purchase_return->qty}}" @else max="{{$purchase_product->qty}}" @endif placeholder="Return Qty" purchase_product_id="{{$purchase_product->id}}">
                                        </td>
                                        <td class="d-none">
                                            <input class="form-control return_price" type="number" id="amount-{{$purchase_product->id}}"
                                                name="amount[]" value="0" placeholder="Return Product Amount" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="d-none">
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
        var purchase_product_id = $(this).attr('purchase_product_id');

        $.ajax({
            type: "GET",
            url: "{{route('purchase.return.get.product')}}",
            data: {
                purchase_product_id: purchase_product_id,
            },
            success: function(result) {
                let return_qty = 0;
                for (let i = 0; i < result.purchase_return.length; i++) {
                    return_qty += result.purchase_return[i].qty;
                }
                var stock_qty =result.qty - return_qty;
                $(`#stock_qty-${purchase_product_id}`).val(stock_qty);
                var price = result.discount_amount/stock_qty;
                var stock_qty = $(`#qty-${purchase_product_id}`).val();
                subtotal(result.id, price, stock_qty);

                totalReturnAmount();
            }
        })
    })

    function subtotal(purchase_product_id,price, qty)
    {
        var amount = parseInt(price*qty);
        $(`#amount-${purchase_product_id}`).val(amount ? amount : 0);

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