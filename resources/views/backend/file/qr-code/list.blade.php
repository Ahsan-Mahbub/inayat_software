@extends('backend.layouts.app')
@section('content')
<style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">QR Code</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">QR Code</li>
                    <li class="breadcrumb-item active">Print</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body pb-0">

                <div class="text-right mb-4">
                	<form action="{{ route('qr-code.destroy') }}" method="POST">
                        <button type="button" class="btn btn-info no-print" onclick="printDiv('qrcodeToPrint')">
                            <i class="mdi mdi-printer-check"></i>&nbsp; Print QR Code
                        </button>
                        @csrf
                        <button type="submit" name="" class="btn btn-danger delete-confirm" title="Delete QR Code">
                            <i class="far fa-trash-alt"></i> &nbsp; Clear All
                        </button>
                    </form>
                </div>
                
            </div>
            <div class="card-body pt-0">
                <!-- Table -->
                <div class="push">
                    <div class="row">
                        <div class="p-0" id="qrcodeToPrint">
                            <div class="qrcode-container">
                                @if(count($all_qrcode) > 0)
                                    @foreach ($all_qrcode as $qrcode)
                                        @for ($i = 0; $i < $qrcode->quantity; $i++)
                                            @if($qrcode->product)
                                                <div class="single-qrcode" style="width: 50mm; height: 25mm; box-sizing: border-box; margin: 0; padding: 0; page-break-inside: avoid;">
                                                    <div style="display: flex; height: 100%;">
                                                        <div style="display: inline; margin: auto;">
                                                            <?php
                                                                $qrcode_gen = $qrcode->product ? $qrcode->product->sku : 'N/A';
                                                            ?>
                                                            {{ QrCode::size(50)->generate($qrcode_gen) }}
                                                        </div>
                                                        <div style="display: inline; padding-left:10px; margin: auto; width: 75%">
                                                            <b style="color: #000; display: block; font-size: 10px;">INAYAT LIGHTING</b>
                                                            <span style="color: #000; display: block; font-size: 10px;">{{ $qrcode->product ? $qrcode->product->sku : 'N/A' }}</span>
                                                            @if($qrcode->watt_id)
                                                            <span style="color: #000; display: block; font-size: 10px;">WATT - {{ $qrcode->watt ? $qrcode->watt->watt_name : 'N/A' }}</span>
                                                            @endif
                                                            @if($qrcode->color_id)
                                                            <span style="color: #000; display: block; font-size: 10px;">BODY COLOR - {{ $qrcode->color ? $qrcode->color->color_name : 'N/A' }}</span>
                                                            @endif
                                                            @if($qrcode->temperature_id)
                                                            <span style="color: #000; display: block; font-size: 10px;">TEMP. -  {{ $qrcode->temperature ? $qrcode->temperature->temperature_name : 'N/A' }}</span>
                                                            @endif
                                                            @if($qrcode->dimmable_type)
                                                            <span style="color: #000; display: block; font-size: 10px;">DIMMABLE TYPE - {{ $qrcode->dimmable_type }}</span>
                                                            @endif
                                                            @if($qrcode->size)
                                                            <span style="color: #000; display: block; font-size: 10px;">SIZE - {{ $qrcode->size }}</span>
                                                            @endif
                                                            @if($qrcode->patch_type)
                                                            <span style="color: #000; display: block; font-size: 10px;">PATCH/PIN - {{ $qrcode->patch_type }}</span>
                                                            @endif
                                                            @if($qrcode->channel_type)
                                                            <span style="color: #000; display: block; font-size: 10px;">CHANNEL/ADAPTER - {{ $qrcode->channel_type }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor
                                    @endforeach
                                @else
                                    <span class="text-danger"> No QR Code Found for Print</span>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- END Table -->
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div>
                    <h5 class="p-2">Add Product QR Code</h5>                    
                </div>
                <div class="mt-3">
                    <!-- Form -->
                    <form action="{{ route('qr-code.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Product Code *</label>
                                <select class="custom-select select2" id="product_id" name="product_id"
                                    style="width: 100%;" data-placeholder="Choose one.." required>
                                    <option value="" selected>Choose one..</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->sku }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Watt</label>
                                <select class="custom-select select2" id="watt_id" name="watt_id"
                                    style="width: 100%;" data-placeholder="Choose one..">
                                    <option value="" selected>Choose one..</option>
                                    @foreach ($watts as $watt)
                                    <option value="{{ $watt->id }}">{{ $watt->watt_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Body Color</label>
                                <select class="custom-select select2" id="color_id" name="color_id"
                                    style="width: 100%;" data-placeholder="Choose one..">
                                    <option value="" selected>Choose one..</option>
                                    @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Temperature</label>
                                <select class="custom-select select2" id="temperature_id" name="temperature_id"
                                    style="width: 100%;" data-placeholder="Choose one..">
                                    <option value="" selected>Choose one..</option>
                                    @foreach ($temperatures as $temperature)
                                    <option value="{{ $temperature->id }}">{{ $temperature->temperature_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Dimmable Type</label>
                                <select class="custom-select select2" id="dimmable_type" name="dimmable_type"
                                    style="width: 100%;" data-placeholder="Choose one..">
                                    <option value="" selected>Choose one..</option>
                                    <option value="Dimmable">Dimmable</option>
                                    <option value="Non Dimmable">Non Dimmable</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Size</label>
                                <input type="text" name="size" id="size" class="form-control" placeholder="Size">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Patch Option</label>
                                <select class="custom-select select2" id="patch_type" name="patch_type"
                                    style="width: 100%;" data-placeholder="Choose one..">
                                    <option value="" selected>Choose one..</option>
                                    <option value="Patch">Patch</option>
                                    <option value="Pin">Pin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">Channel Option</label>
                                <select class="custom-select select2" id="channel_type" name="channel_type"
                                    style="width: 100%;" data-placeholder="Choose one..">
                                    <option value="" selected>Choose one..</option>
                                    <option value="Channel">Channel</option>
                                    <option value="Adapter">Adapter</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">Quantity *</label>
                                <input type="text" name="quantity" id="quantity" required class="form-control" placeholder="Quantity">
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm text-center">
                            <button type="submmit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </form> 
                    <!-- END Form -->                   
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('script')
<script>
    function printDiv(divId) {
        var content = document.getElementById(divId).innerHTML;
        var myWindow = window.open('', '', 'width=1200,height=600');
        myWindow.document.write('<html><head><title>Print qrcode</title>');
        myWindow.document.write('<style>');
        myWindow.document.write('@media print { .no-print { display: none; } }');
        myWindow.document.write('body { font-family: Arial, sans-serif; }');
        myWindow.document.write('</style>');
        myWindow.document.write('</head><body>');
        myWindow.document.write(content);
        myWindow.document.write('</body></html>');
        myWindow.document.close();
        myWindow.focus();
        myWindow.print();
    }
</script>
@endsection