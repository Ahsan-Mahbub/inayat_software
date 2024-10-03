@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Role List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Role</li>
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
                    @isset(auth()->user()->role->permission['permission']['role']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Role</button>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('role.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Role  & Enter.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_role as $role)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$role -> role_name}}</td>
                                <td>
                                    <form action="{{ route('role.destroy', $role->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['role']['edit'])
                                        <a data-toggle="modal"  data-target="#edit_modal" id="editrole"
                                            data="{{ $role->id }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['role']['destroy'])
                                        @if(!in_array($role->id, [1,4,5,6,11,12]))
                                        <button type="submit"
                                            class="btn btn-sm btn-danger delete-confirm">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                        @endif
                                        @endisset
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $all_role->appends(request()->except('page'))->links() }}
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('role.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom01" name="role_name" placeholder="Name" required="">
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('role.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="role_id" name="id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Name" required="">
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
        $(document).on("click", "#editrole", function() {
            let id = $(this).attr("data");
            $.ajax({
                url: "/admin/role/edit/" + id,
                type: "get",
                dataType: "json",
                success: function(response) {
                    $("#role_id").val(response.id);
                    $("#role_name").val(response.role_name);
                }
            })
        })
    </script>
@endsection