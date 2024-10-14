@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Quotation List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Purchase Quotation</li>
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
                    @isset(auth()->user()->role->permission['permission']['requisition']['create'])
                    <a href="{{route('requisition.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">Add Quotation</a>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('requisition.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Quotation Number & Enter.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Requisitor</th>
                                <th>Editor</th>
                                <th>Quotation Number</th>
                                <th>Supplier Name</th>
                                {{-- <th>Total Amount</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_requisition as $requisition)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($requisition->date);
                                        $date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$date}}
                                </td>
                                <td>{{$requisition->creator ? $requisition->creator->name : 'N/A'}}</td>
                                <td>{{$requisition->editor ? $requisition->editor->name : 'N/A'}}</td>
                                <td>{{$requisition -> requisition_number}}</td>
                                <td>{{$requisition->supplier ? $requisition->supplier->supplier_name : 'N/A'}}</td>
                                {{-- <td>{{$requisition -> total_amount}}</td> --}}
                                <td>
                                    @isset(auth()->user()->role->permission['permission']['requisition']['approve'])
                                        @if ($requisition->status == 0)
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pending <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                    <a class="dropdown-item"
                                                            href="{{ route('requisition.active', $requisition->id) }}">Approved</a>
                                                    <a class="dropdown-item"
                                                            href="{{ route('requisition.deactive', $requisition->id) }}">Rejected</a>
                                                </div>
                                            </div>
                                        @elseif ($requisition->status == 1)
                                            <button class="btn btn-sm btn-success" type="button">
                                                Approved
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-danger" type="button">
                                                Rejected
                                            </button>
                                        @endif
                                    @endisset
                                </td>
                                <td>
                                    <form action="{{ route('requisition.destroy', $requisition->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['requisition']['view'])
                                        <a href="{{ route('requisition.show', $requisition->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-eye text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['requisition']['edit'])
                                        <a href="{{ route('requisition.edit', $requisition->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['requisition']['destroy'])
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
                    {{ $all_requisition->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection