@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Return : {{ $sample->invoice }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Sample Return</li>
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
                <form action="{{ route('sample.return.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label>Creator Name</label>
                            <input type="hidden" name="creator_id" value="{{ $sample->creator_id }}">
                            <input class="form-control" value="{{$sample->creator ? $sample->creator->name : ''}}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Customer Name</label>
                            <input type="hidden" name="customer_id" value="{{ $sample->customer_id }}">
                            <input class="form-control" value="{{$sample->customer ? $sample->customer->customer_name : ''}}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Request Number</label>
                            <input type="hidden" id="sample_id" name="request_id" value="{{ $sample->id }}">
                            <input class="form-control" value="{{$sample->request_number}}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Date</label>
                            <input class="form-control" type="date" name="date" required min="{{$sample->date}}">
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <h4 class="header-title mt-4 mb-3">All Product : {{$sample->invoice}}</h4>
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                        <th>Product Code &nbsp;</th>
                                        <th>Watt &nbsp;</th>
                                        <th>Now Sample Qty &nbsp;</th>
                                        <th>Return Qty &nbsp;</th>
                                        <th class="d-none">Return Amount &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sample_products as $sample_product) 
                                    <tr>
                                        <?php
                                            $sample_return = App\Models\SampleReturn::where('request_id', $sample->id)->where('product_id', $sample_product->product_id)->first();
                                        ?>

                                        <td>{{$sample_product->product ? $sample_product->product->product_name : ''}}</td>
                                        <input type="hidden" value="{{$sample_product->product_id}}" name="product_id[]">
                                        <input type="hidden" value="{{$sample_product->id}}" name="sample_product_id[]">
                                        <td>
                                            {{$sample_product->unit ? $sample_product->unit->unit_name : ''}}
                                            <input type="hidden" name=unit_id[] class="form-control" value="{{$sample_product->unit ? $sample_product->unit->id : ''}}">
                                        </td>

                                        <td>
                                            <input class="form-control price" type="number" id="sample_qty-{{$sample_product->id}}"
                                                name="sample_qty" @if($sample_return) value="{{$sample_product->qty - $sample_return->qty}}" @else value="{{$sample_product->qty}}" @endif placeholder="sample Qty" readonly
                                                required>
                                        </td>
                                        <td>
                                            <input class="form-control return-qty" type="number" id="qty-{{$sample_product->id}}"
                                                name="qty[]" @if($sample_return) max="{{$sample_product->qty - $sample_return->qty}}" @else max="{{$sample_product->qty}}" @endif placeholder="Return Qty" sample_product_id="{{$sample_product->id}}">
                                        </td>
                                        <td class="d-none">
                                            <input class="form-control return_price" type="number" id="amount-{{$sample_product->id}}"
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
        var sample_product_id = $(this).attr('sample_product_id');
        var unit_id = $(`#unit_id-${sample_product_id}`).val();

        $.ajax({
            type: "GET",
            url: "{{route('sample.return.get.product')}}",
            data: {
                sample_product_id: sample_product_id,
            },
            success: function(result) {
                if(unit_id == result.product.primary_unit_id)
                {
                    let return_qty = 0;
                    for (let i = 0; i < result.sample_return.length; i++) {
                        return_qty += result.sample_return[i].qty;
                    }
                    var sample_qty =result.qty - return_qty;
                    $(`#sample_qty-${sample_product_id}`).val(sample_qty);
                    var price = result.discount_amount/sample_qty;
                    var sample_qty = $(`#qty-${sample_product_id}`).val();
                    subtotal(result.id, price, sample_qty);

                }else if(unit_id == result.product.second_unit_id)
                {
                    let return_qty = 0;
                    for (let i = 0; i < result.sample_return.length; i++) {
                        return_qty += result.sample_return[i].qty;
                    }

                    var sample_qty =((result.qty - return_qty)*result.product.conversation_factor);
                    $(`#sample_qty-${sample_product_id}`).val(sample_qty);
                    var price = result.discount_amount/sample_qty;
                    var sample_qty = $(`#qty-${sample_product_id}`).val();
                    subtotal(result.id, price, sample_qty);
                    
                }else if(unit_id == result.product.third_unit_id)
                {
                    let return_qty = 0;
                    for (let i = 0; i < result.sample_return.length; i++) {
                        return_qty += result.sample_return[i].qty;
                    }

                    var sample_qty =((result.qty - return_qty)*result.product.conversation_factor)*result.product.second_conversation_factor;
                    $(`#sample_qty-${sample_product_id}`).val(sample_qty);
                    var price = result.discount_amount/sample_qty;
                    var sample_qty = $(`#qty-${sample_product_id}`).val();
                    subtotal(result.id, price, sample_qty);
                }
                totalReturnAmount();
            }
        })
    })

    function subtotal(sample_product_id,price, qty)
    {
        var amount = parseInt(price*qty);
        $(`#amount-${sample_product_id}`).val(amount ? amount : 0);

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