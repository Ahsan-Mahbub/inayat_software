@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Sample Request List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Sample Request</li>
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
                        @isset(auth()->user()->role->permission['permission']['sample-request']['create'])
                            <a href="{{ route('sample.request.create') }}"
                                class="btn btn-primary btn-sm waves-effect waves-light">Add Sample Request</a>
                        @endisset
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label>Search:<form method="get" action="{{ route('sample.request.search') }}">
                                            <input type="text" class="form-control mt-2"
                                                placeholder="Search by Request Number & Enter.." name="search"
                                                id="search" value="{{ $search }}" style="width: 100%"> <input
                                                type="submit" class="d-none"></form></label>
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Requisitor</th>
                                    <th>Editor</th>
                                    <th>Request Number</th>
                                    <th>Client Name</th>
                                    <th>Status</th>
                                    <th>Return Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($all_request as $request)
                                    <tr>
                                        <td>{{ $startingSerial++ }}</td>
                                        <td>
                                            <?php
                                            $timestamp = strtotime($request->date);
                                            $date = date('d-m-Y', $timestamp);
                                            ?>
                                            {{ $date }}
                                        </td>
                                        <td>{{ $request->creator ? $request->creator->name : 'N/A' }}</td>
                                        <td>{{ $request->editor ? $request->editor->name : 'N/A' }}</td>
                                        <td>{{ $request->request_number }}</td>
                                        <td>{{ $request->customer ? $request->customer->customer_name : 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($request->status == 0)
                                                @isset(auth()->user()->role->permission['permission']['sample-request']['approve'])
                                                    @if (!in_array(Auth::user()->role_id, [5, 6]))
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                Pending <i class="mdi mdi-chevron-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                                style="">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('sample.request.active', $request->id) }}">Approved</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('sample.request.deactive', $request->id) }}">Rejected</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-sm btn-info" type="button">
                                                            Pending
                                                        </button>
                                                    @endif
                                                @endisset
                                                @php
                                                    $hasApprovePermission = isset(
                                                        auth()->user()->role->permission['permission'][
                                                            'sample-request'
                                                        ]['approve'],
                                                    )
                                                        ? auth()->user()->role->permission['permission'][
                                                            'sample-request'
                                                        ]['approve']
                                                        : false;
                                                @endphp

                                                @if (!$hasApprovePermission)
                                                    <button class="btn btn-sm btn-info" type="button">
                                                        Pending
                                                    </button>
                                                @endif
                                            @elseif ($request->status == 1)
                                                <button class="btn btn-sm btn-success" type="button">
                                                    Approved
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-danger" type="button">
                                                    Rejected
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                                $product = App\Models\SampleRequestProduct::where('request_id', $request->id)->sum('qty');
                                                $return_product = App\Models\SampleReturn::where('request_id', $request->id)->sum('qty');
                                                $main_qty = $product - $return_product; 
                                            ?>
                                            @if($main_qty <= 0)
                                            <span class="badge badge-pill badge-success">Return</span>
                                            @else
                                            <span class="badge badge-pill badge-warning">Not Return</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('sample.request.destroy', $request->id) }}"
                                                method="post" accept-charset="utf-8">
                                                @isset(auth()->user()->role->permission['permission']['sample-request']['view'])
                                                    <a href="{{ route('sample.request.show', $request->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="far fa-eye text-white"></i>
                                                    </a>
                                                @endisset
                                                @isset(auth()->user()->role->permission['permission']['sample-request']['edit'])
                                                    <a href="{{ route('sample.request.edit', $request->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="far fa-edit text-white"></i>
                                                    </a>
                                                @endisset
                                                @csrf
                                                @method('delete')
                                                @isset(auth()->user()->role->permission['permission']['sample-request']['destroy'])
                                                    <button type="submit" class="btn btn-sm btn-danger delete-confirm">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                @endisset
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $all_request->appends(request()->except('page'))->links() }}
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
