@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Purchase Return List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Purchase Return</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-4">
                    @isset(auth()->user()->role->permission['permission']['purchase-return']['create'])
                    <a href="{{route('purchase.return.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Purchase Return</a>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Supplier Name</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                {{-- <th>Amount</th> --}}
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_purchase_return as $return)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($return->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$return->purchase ? $return->purchase->invoice : ''}}</td>
                                <td>{{$return->supplier ? $return->supplier->supplier_name : 'N/A'}}</td>
                                <td>{{$return->product ? $return->product->product_name : ''}}</td>
                                <td>{{$return->unit ? $return->unit->unit_name : ''}}</td>
                                <td>{{$return->qty}}</td>
                                {{-- <td>{{$return->amount}}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $all_purchase_return->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection