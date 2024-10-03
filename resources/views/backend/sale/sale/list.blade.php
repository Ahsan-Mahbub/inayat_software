@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Sale List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Sale</li>
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
                @isset(auth()->user()->role->permission['permission']['sale']['create'])
                <div class="text-right mb-4">
                    <a href="{{route('sale.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Sale</a>
                </div>
                @endisset

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('sale.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Invoice Enter.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Seller</th>
                                <th>Invoice</th>
                                <th>Quotation</th>
                                <th>Client Name</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_sale as $sale)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($sale->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$sale->creator ? $sale->creator->name : 'N/A'}}</td>
                                <td>{{$sale -> invoice}}</td>
                                <td>{{$sale->requisition ? $sale->requisition->requisition_number : 'N/A'}}</td>
                                <td>{{$sale->customer ? $sale->customer->customer_name : 'N/A'}}</td>
                                <td>{{$sale -> total_amount}}</td>
                                <td>{{$sale -> paid_amount}}</td>
                                <?php
                                    $return = App\Models\SaleReturn::where('sale_id', $sale->id)->sum('amount');
                                ?>
                                <td>{{$sale -> due_amount - $return}}</td>
                                <td>
                                    <form action="{{ route('sale.destroy', $sale->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['sale']['schedule'])
                                        <a href="{{ route('sale.schedule', $sale->id) }}"
                                            class="btn btn-sm btn-dark">
                                            <i class="far fa-calendar text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['sale']['view'])
                                        <a href="{{ route('sale.show', $sale->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-eye text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['sale']['challan'])
                                        <a href="{{ route('sale.challan', $sale->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-truck text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['sale']['destroy'])
                                            <button type="submit"
                                                class="btn btn-sm btn-danger delete-confirm">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        @endisset
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $all_sale->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection