@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Employee List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Employee</li>
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
                    @isset(auth()->user()->role->permission['permission']['employee']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Employee</button>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <form method="get" action="{{route('user.search')}}">
                                <div class="col-sm-12 col-md-3">
                                    <label>Head (GM):</label>
                                    <select class="custom-select select2" name="head_id">
                                        <option value="">Select Head</option>
                                        @foreach($head_users as $user)
                                        <option value="{{$user->id}}">{{$user->name}} @if($user->role_id) ({{$user->role ? $user->role->role_name : ''}}) @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label>Head (Manager):</label>
                                    <select class="custom-select select2" name="subhead_id">
                                        <option value="">Select Head</option>
                                        @foreach($subhead_users as $user)
                                        <option value="{{$user->id}}">{{$user->name}} @if($user->role_id) ({{$user->role ? $user->role->role_name : ''}}) @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label>Search:<input type="text" class="form-control mt-2" placeholder="Search by Employee Name, Email, Phone  & Enter.." name="search" id="search" value="{{$search}}" style="width: 100%"> </label>
                                </div>
                                <input type="submit" class="d-none">
                            </form>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Image</th>
                                <th>Head</th>
                                <th>Role</th>
                                <th>Employee Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_user as $user)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td><img style="width: auto; height: 50px;"
                                    src="{{ $user->image ? '/' . $user->image : '/demo.svg' }}"></td>
                                <td>{{$user->head ? $user->head->name : ''}} @if($user->subhead_id) /<br> {{$user->subhead ? $user->subhead->name : ''}} @endif</td>
                                <td>{{$user->role ? $user->role->role_name : ''}}</td>
                                <td>{{$user -> name}}</td>
                                <td>{{$user -> email}}</td>
                                <td>{{$user -> phone}}</td>
                                <td>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['employee']['edit'])
                                        <a data-toggle="modal"  data-target="#edit_modal" id="edituser"
                                            data="{{ $user->id }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['employee']['destroy'])
                                        @if($user->id != 1)
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
                    {{ $all_user->appends(request()->except('page'))->links() }}
                </div>
                
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

{{-- Add Modal --}}
<div class="modal fade bs-example-modal-md" tabindex="-1" user="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Head (GM)</label>
                            <select class="custom-select select2" name="head_id">
                                <option value="">Select Head (GM)</option>
                                @foreach($head_users as $user)
                                <option value="{{$user->id}}">{{$user->name}} @if($user->role_id) ({{$user->role ? $user->role->role_name : ''}}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Head (Manager)</label>
                            <select class="custom-select select2" name="subhead_id">
                                <option value="">Select Head (Manager)</option>
                                @foreach($subhead_users as $user)
                                <option value="{{$user->id}}">{{$user->name}} @if($user->role_id) ({{$user->role ? $user->role->role_name : ''}}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Role <span class="text-danger">*</span></label>
                            <select class="custom-select select2" name="role_id" required="">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Employee Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="validationCustom02" name="email" placeholder="Email" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom03">Phone Number</label>
                            <input type="text" class="form-control" id="validationCustom03" name="phone" placeholder="Phone Number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04">Joining Date</label>
                            <input type="date" class="form-control" id="validationCustom04" name="joining_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom05">Salary</label>
                            <input type="number" class="form-control" id="validationCustom05" name="salary" placeholder="Salary">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom06">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="validationCustom06" name="m_password" placeholder="Password" required="">
                        </div>
                        <div class="col-12">
                            <label>Image</label>
                            <input type='file' class="form-group" name="image" onchange="readURL(this);" />
                            <img id="blah" src="/demo.svg" class="pt-2" height="200" width="auto" alt="profile" /><br>
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
<div class="modal fade bs-example-modal-md" id="edit_modal" tabindex="-1" user="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('user.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="user_id" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Head</label>
                            <select class="custom-select select2" name="head_id" id="head_id">
                                <option value="">Select Head</option>
                                @foreach($head_users as $user)
                                <option value="{{$user->id}}">{{$user->name}} @if($user->role_id) ({{$user->role ? $user->role->role_name : ''}}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Head (Manager)</label>
                            <select class="custom-select select2" name="subhead_id" id="subhead_id">
                                <option value="">Select Head (Manager)</option>
                                @foreach($subhead_users as $user)
                                <option value="{{$user->id}}">{{$user->name}} @if($user->role_id) ({{$user->role ? $user->role->role_name : ''}}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Role <span class="text-danger">*</span></label>
                            <select class="custom-select select2" id="role_id" name="role_id" required="">
                                <option value="">Select role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Employee Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom03">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04">Joining Date</label>
                            <input type="date" class="form-control" id="joining_date" name="joining_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom05">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" placeholder="Salary">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom03">Password (if changes)</label>
                            <input type="password" class="form-control"  name="m_password" placeholder="Password">
                        </div>
                        <div class="col-12">
                            <label>Image</label>
                            <input type='file' class="form-group" name="image" onchange="readURL2(this);" />
                            <img id="blah2" src="" class="profile_image pt-2" height="200" width="auto" alt="profile" /><br>
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
        $(document).on("click", "#edituser", function() {
            let id = $(this).attr("data");
            $.ajax({
                url: "/admin/user/edit/" + id,
                type: "get",
                dataType: "json",
                success: function(response) {
                    $("#user_id").val(response.id);
                    $("#name").val(response.name);
                    $("#head_id").val(response.head_id);
                    $("#subhead_id").val(response.subhead_id);
                    $("#role_id").val(response.role_id);
                    $("#email").val(response.email);
                    $("#phone").val(response.phone);
                    $("#designation").val(response.designation);
                    $("#joining_date").val(response.joining_date);
                    $("#salary").val(response.salary);
                    $('.profile_image').attr('src', response.image ? '/' + response.image : '/demo.svg');
                }
            })
        })
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah2')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection