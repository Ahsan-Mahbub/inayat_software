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
            <h4 class="mb-0 font-size-18">Bar Code</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Bar Code</li>
                    <li class="breadcrumb-item active">Print</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-5">
        <div class="card">
            <div class="card-body pb-0">

                <div class="text-right mb-4">
                	<form action="{{ route('barcode.destroy') }}" method="POST">
                        <button type="button" class="btn btn-info no-print" onclick="printDiv('barcodeToPrint')">
                            <i class="mdi mdi-printer-check"></i>&nbsp; Print Bar Code
                        </button>
                        @csrf
                        <button type="submit" name="" class="btn btn-danger delete-confirm" title="Delete Bar Code">
                            <i class="far fa-trash-alt"></i> &nbsp; Clear All
                        </button>
                    </form>
                </div>
                
            </div>
            <div class="card-body pt-0">
                <!-- Table -->
                <div class="push">
                    <div class="row">
                        <div class="" id="barcodeToPrint">
                            <div class="barcode-container" style="text-align: center">
                                @if(count($all_barcode) > 0)
                                    @foreach ($all_barcode as $barcode)
                                        @for ($i = 0; $i < $barcode->quantity; $i++)
                                            <div class="single-barcode" style="border: 1px solid gray; width: 280px; padding: 5px; text-align: center;">
                                                <b style="color: #000; display: block;">INAYAT LIGHTING</b>
                                                <?php
                                                    $barcode_gen = $barcode->product->sku;
                                                ?>
                                                <span style="padding: 3px 0; text-align: -webkit-center;">
                                                    <?php echo DNS1D::getBarcodeHTML($barcode_gen, 'C39',1.2,23);?>
                                                </span>
                                                <span style="color: #000; display: block; font-size: 13px;">{{ $barcode->product ? $barcode->product->sku : 'N/A' }}</span>
                                                @if($barcode->watt_id)
                                                <span style="color: #000; display: block; font-size: 13px;">WATT - {{ $barcode->watt ? $barcode->watt->watt_name : 'N/A' }}</span>
                                                @endif
                                                @if($barcode->color_id)
                                                <span style="color: #000; display: block; font-size: 13px;">BODY COLOR - {{ $barcode->color ? $barcode->color->color_name : 'N/A' }}</span>
                                                @endif
                                                @if($barcode->temperature_id)
                                                <span style="color: #000; display: block; font-size: 13px;">TEMPERATURE -  {{ $barcode->temperature ? $barcode->temperature->temperature_name : 'N/A' }}</span>
                                                @endif
                                                @if($barcode->dimmable_type)
                                                <span style="color: #000; display: block; font-size: 13px;">DIMMABLE TYPE - {{ $barcode->dimmable_type }}</span>
                                                @endif
                                                @if($barcode->size)
                                                <span style="color: #000; display: block; font-size: 13px;">SIZE - {{ $barcode->size }}</span>
                                                @endif
                                                @if($barcode->patch_type)
                                                <span style="color: #000; display: block; font-size: 13px;">PATCH/PIN - {{ $barcode->patch_type }}</span>
                                                @endif
                                                @if($barcode->channel_type)
                                                <span style="color: #000; display: block; font-size: 13px;">CHANNEL/ADAPTER - {{ $barcode->channel_type }}</span>
                                                @endif
                                            </div>
                                        @endfor
                                    @endforeach
                                @else
                                    <span class="text-danger"> No Bar Code Found for Print</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Table -->
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="card">
            <div class="card-body">
                <div>
                    <h5 class="p-2">Add Product Bar Code</h5>                    
                </div>
                <div class="mt-3">
                    <!-- Form -->
                    <form id="action-form" action="{{ route('barcode.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="action-type" name="action_type" value="">
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
                        <button type="button" class="btn btn-primary" id="save-button" data-value="save">
                            Save
                        </button>
                        <button type="button" class="btn btn-dark" id="download-button" data-value="download">
                            Download Image
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
    document.getElementById('save-button').addEventListener('click', function() {
        var value = this.getAttribute('data-value');
        document.getElementById('action-type').value = value;
        document.getElementById('action-form').submit();
    });
    
    document.getElementById('download-button').addEventListener('click', function() {
        var value = this.getAttribute('data-value');
        document.getElementById('action-type').value = value;
        document.getElementById('action-form').submit();
    });
</script>
    
<script>
    function printDiv(divId) {
        var content = document.getElementById(divId).innerHTML;
        var myWindow = window.open('', '', 'width=1200,height=600');
        myWindow.document.write('<html><head><title>Print Barcode</title>');
        myWindow.document.write('<style>@media print { .no-print { display: none; } }</style>');
        myWindow.document.write('</head><body>');
        myWindow.document.write(content);
        myWindow.document.write('</body></html>');
        myWindow.document.close();
        myWindow.focus();
        myWindow.print();
    }
</script>
@endsection