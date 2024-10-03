@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Supplier List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Supplier</li>
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
                    @isset(auth()->user()->role->permission['permission']['supplier']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Supplier</button>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('supplier.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Supplier ID, Name, Phone, Email.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Image</th>
                                <th>ID / Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{-- <th>Total Amount</th> --}}
                                {{-- <th>Paid Amount + Return Amount</th> --}}
                                {{-- <th>Credit / Due</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            
                            @foreach($all_supplier as $supplier)
                            @php
                                $due_amount = $supplier -> total_amount - ($supplier -> paid_amount + $supplier->return_amount);
                                $credit_amount = abs($due_amount);
                            @endphp

                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td><img src="/{{$supplier->image ? $supplier->image : 'demo.svg'}}" height="50"></td>
                                <td>{{$supplier -> supplier_id}} <br> {{$supplier -> supplier_name}}</td>
                                <td>{{$supplier -> phone}}</td>
                                <td>{{$supplier -> email}}</td>
                                {{-- <td>{{$supplier -> total_amount ? $supplier -> total_amount : 0}}</td> --}}
                                {{-- <td>{{$supplier -> paid_amount ? $supplier -> paid_amount : 0}} + {{$supplier -> return_amount ? $supplier -> return_amount : 0}} ({{$supplier -> paid_amount + $supplier -> return_amount }})</td> --}}
                                {{-- <td>@if($due_amount > 0) {{$due_amount}} <small>dr</small> @else {{$credit_amount}} <small>cr</small> @endif</td> --}}
                                <td>
                                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="post"
                                        accept-charset="utf-8">
                                        {{-- <a href="{{route('supplier.transaction', $supplier->id)}}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-money-bill-wave text-white"></i>
                                        </a> --}}
                                        @isset(auth()->user()->role->permission['permission']['supplier']['profile'])
                                        <a href="{{route('supplier.show', $supplier->id)}}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-user text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['supplier']['edit'])
                                        <a data-toggle="modal"  data-target="#edit_modal" id="editsupplier"
                                            data="{{ $supplier->id }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['supplier']['destroy'])
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
                    {{ $all_supplier->appends(request()->except('page'))->links() }}
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('supplier.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Supplier Name *</label>
                            <input type="text" class="form-control" id="validationCustom01" name="supplier_name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email </label>
                            <input type="email" class="form-control" id="validationCustom02" name="email" placeholder="Email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Phone Number </label>
                            <input type="tel" class="form-control" id="validationCustom03" name="phone" placeholder="Phone">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Designation </label>
                            <input type="text" class="form-control" id="validationCustom03" name="designation" placeholder="Designation">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Company Name </label>
                            <input type="text" class="form-control" id="validationCustom03" name="company_name" placeholder="Company Name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Address</label>
                            <textarea class="form-control" id="validationCustom04" name="address" placeholder="Address"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom05">Image </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-control" id="validation05" name="image" onchange="readURL(this);" />
                                <img id="image" src="/demo.svg" height="200" width="250" alt="property" /><br>
                            </div>
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('supplier.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="supplier_id" name="id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Supplier Name *</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Phone Number </label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Designation </label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Company Name </label>
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom05">Image </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-control" id="" name="image" onchange="readURL2(this);" />
                                <img id="image2" class="supplier_image" height="200" width="250" alt="property" /><br>
                            </div>
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image2')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script type="text/javascript">
        $(document).on("click", "#editsupplier", function() {
            let id = $(this).attr("data");
            $.ajax({
                url: "/admin/supplier/edit/" + id,
                type: "get",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#supplier_id").val(response.id);
                    $("#supplier_name").val(response.supplier_name);
                    $("#email").val(response.email);
                    $("#phone").val(response.phone);
                    $("#designation").val(response.designation);
                    $("#company_name").val(response.company_name);
                    $("#address").val(response.address);
                    $('.supplier_image').attr('src', response.image ? '/'+ response.image  : '/demo.svg');
                }
            })
        })
    </script>
@endsection