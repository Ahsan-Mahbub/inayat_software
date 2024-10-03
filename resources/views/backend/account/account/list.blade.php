@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Account List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Account</li>
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
                    @isset(auth()->user()->role->permission['permission']['account']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Account</button>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('account.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Account  & Enter.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Method Name</th>
                                <th>Account Name</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_account as $account)
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$account -> method ? $account -> method -> method_name : "N/A"}}</td>
                                <td>{{$account -> account_name}}</td>
                                <td>{{$account -> details}}</td>
                                <td>
                                    <form action="{{ route('account.destroy', $account->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['account']['edit'])
                                        <a data-toggle="modal"  data-target="#edit_modal" id="editaccount"
                                            data="{{ $account->id }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['account']['destroy'])
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
                    {{ $all_account->appends(request()->except('page'))->links() }}
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('account.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Method <span class="text-danger">*</span></label>
                            <select class="custom-select select2" name="method_id" required="">
                                <option value="">Select method</option>
                                @foreach($methods as $method)
                                <option value="{{$method->id}}">{{$method->method_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom01" name="account_name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Account Details </label>
                            <textarea class="form-control" id="validationCustom02" name="details" placeholder="Details"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Opening Balance <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="validationCustom01" name="total_amount" placeholder="Opening Balance" required="" value="0">
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('account.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="account_id" name="id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Method <span class="text-danger">*</span></label>
                            <select class="custom-select select2" id="method_id" name="method_id" required="">
                                <option value="">Select method</option>
                                @foreach($methods as $method)
                                <option value="{{$method->id}}">{{$method->method_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Account Details </label>
                            <textarea class="form-control" id="details" name="details" placeholder="Details"></textarea>
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
        $(document).on("click", "#editaccount", function() {
            let id = $(this).attr("data");
            $.ajax({
                url: "/admin/account/edit/" + id,
                type: "get",
                dataType: "json",
                success: function(response) {
                    $("#account_id").val(response.id);
                    $("#method_id").val(response.method_id);
                    $("#account_name").val(response.account_name);
                    $("#details").val(response.details);
                }
            })
        })
    </script>
@endsection