@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Purchase List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Purchase</li>
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
                        @isset(auth()->user()->role->permission['permission']['purchase']['create'])
                            <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-sm waves-effect waves-light">Add
                                Purchase</a>
                        @endisset
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label>Search:<form method="get" action="{{ route('purchase.search') }}"><input
                                                type="text" class="form-control mt-2"
                                                placeholder="Search by Invoice Enter.." name="search" id="search"
                                                value="{{ $search }}" style="width: 100%"> <input type="submit"
                                                class="d-none"></form></label>
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Purchaser</th>
                                    <th>Requisition Number</th>
                                    <th>Invoice</th>
                                    <th>Supplier Name</th>
                                    {{-- <th>Total Amount</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($all_purchase as $purchase)
                                    <tr>
                                        <td>{{ $startingSerial++ }}</td>
                                        <td>
                                            <?php
                                            $timestamp = strtotime($purchase->date);
                                            $date = date('d-m-Y', $timestamp);
                                            ?>
                                            {{ $date }}
                                        </td>
                                        <td>{{ $purchase->creator ? $purchase->creator->name : 'N/A' }}</td>
                                        <td>{{ $purchase->requisition ? $purchase->requisition->requisition_number : 'N/A' }}
                                        </td>
                                        <td>{{ $purchase->invoice }}</td>
                                        <td>{{ $purchase->supplier ? $purchase->supplier->supplier_name : 'N/A' }}</td>
                                        {{-- <td>{{ $purchase->total_amount }}</td> --}}
                                        <td>
                                            {{-- <a href="{{ route('purchase.transaction', $purchase->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-money-bill-wave text-white"></i>
                                    </a> --}}
                                            <form action="{{ route('purchase.destroy', $purchase->id) }}" method="post"
                                                accept-charset="utf-8">
                                                @isset(auth()->user()->role->permission['permission']['purchase']['view'])
                                                <a href="{{ route('purchase.show', $purchase->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="far fa-eye text-white"></i>
                                                </a>
                                                @endisset
                                                @isset(auth()->user()->role->permission['permission']['purchase']['edit'])
                                                {{-- <a href="{{ route('purchase.edit', $purchase->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="far fa-edit text-white"></i>
                                                </a> --}}
                                                @endisset
                                                @csrf
                                                @method('delete')
                                                @isset(auth()->user()->role->permission['permission']['purchase']['destroy'])
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
                        {{ $all_purchase->appends(request()->except('page'))->links() }}
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
