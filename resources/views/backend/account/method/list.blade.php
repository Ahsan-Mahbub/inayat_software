@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Method List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Method</li>
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
                    @isset(auth()->user()->role->permission['permission']['payment_mathod']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Method</button>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('method.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Method  & Enter.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Method Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_method as $method)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$method -> method_name}}</td>
                                <td>
                                    @isset(auth()->user()->role->permission['permission']['payment_mathod']['edit'])
                                    <a data-toggle="modal"  data-target="#edit_modal" id="editmethod"
                                        data="{{ $method->id }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="far fa-edit text-white"></i>
                                    </a>
                                    @endisset
                                    @isset(auth()->user()->role->permission['permission']['payment_mathod']['destroy'])
                                    {{-- <form action="{{ route('method.destroy', $method->id) }}" method="post"
                                        accept-charset="utf-8">
                                        
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger delete-confirm">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form> --}}
                                    @endisset
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $all_method->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

{{-- Add Modal --}}
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('method.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Method Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom01" name="method_name" placeholder="Name" required="">
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Add Modal --}}

{{-- Edit Modal --}}
<div class="modal fade bs-example-modal-md" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('method.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="method_id" name="id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Method Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="method_name" name="method_name" placeholder="Name" required="">
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Edit Modal --}}
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("click", "#editmethod", function() {
            let id = $(this).attr("data");
            $.ajax({
                url: "/admin/method/edit/" + id,
                type: "get",
                dataType: "json",
                success: function(response) {
                    $("#method_id").val(response.id);
                    $("#method_name").val(response.method_name);
                }
            })
        })
    </script>
@endsection