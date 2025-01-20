@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Client List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Client</li>
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
                    @isset(auth()->user()->role->permission['permission']['customer']['dues'])
                    <a href="{{route('receivable.dues')}}" class="btn btn-danger btn-sm waves-effect waves-light">Dues Client</a>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['customer']['create'])
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-md">Add Client</button>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['customer']['print'])
                    <a href="{{route('customer.print')}}" class="btn btn-warning btn-sm waves-effect waves-light">Print Client</a>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['customer']['message'])
                    <a href="{{route('customer.message')}}" class="btn btn-dark btn-sm waves-effect waves-light">Send Message</a>
                    @endisset
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label>Search:<form method="get" action="{{route('customer.search')}}"><input type="text" class="form-control mt-2" placeholder="Search by Client ID, Name, Phone, Email.." name="search" id="search" value="{{$search}}" style="width: 100%"> <input type="submit" class="d-none"></form></label>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Creator Name</th>
                                <th>Image</th>
                                <th>ID / Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Total Amount</th>
                                <th>Paid + Return + Adjustment</th>
                                <th>Due / Credit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
    
    
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($all_customer as $customer)
                            @php
                                $due_amount = $customer->total_amount - ($customer->paid_amount + $customer->return_amount + $customer->adjustment_amount);
                                $credit_amount = abs($due_amount);
                            @endphp
                            <tr>
                                <td>{{$startingSerial++}}</td>
                                <td>{{$customer->creator ? $customer->creator->name : ''}}</td>
                                <td><img src="/{{$customer->image ? $customer->image : 'demo.svg'}}" height="50"></td>
                                <td>{{$customer -> customer_id}} <br> {{$customer -> customer_name}}</td>
                                <td>{{$customer -> phone}}</td>
                                <td>{{$customer -> email}}</td>
                                <td>{{$customer -> total_amount ? $customer -> total_amount : 0}}</td>
                                <td>{{$customer -> paid_amount ? $customer -> paid_amount : 0}} + {{$customer -> return_amount ? $customer -> return_amount : 0}} ({{$customer -> paid_amount + $customer -> return_amount }})</td>
                                <td>@if($due_amount > 0) {{$due_amount}} <small>dr</small> @else {{$credit_amount}} <small>cr</small> @endif</td>
                                <td>
                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="post"
                                        accept-charset="utf-8">
                                        @isset(auth()->user()->role->permission['permission']['customer']['transaction'])
                                        <a href="{{route('customer.transaction', $customer->id)}}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-money-bill-wave text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['customer']['profile'])
                                        <a href="{{route('customer.show', $customer->id)}}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-user text-white"></i>
                                        </a>
                                        @endisset
                                        @isset(auth()->user()->role->permission['permission']['customer']['edit'])
                                        <a data-toggle="modal"  data-target="#edit_modal" id="editcustomer"
                                            data="{{ $customer->id }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="far fa-edit text-white"></i>
                                        </a>
                                        @endisset
                                        @csrf
                                        @method('delete')
                                        @isset(auth()->user()->role->permission['permission']['customer']['destroy'])
                                        <?php
                                            $match_url = url('/admin/receivable/list');
                                            $currentUrl = url()->current();
                                        ?>
                                        @if($match_url != $currentUrl)
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
                    {{ $all_customer->appends(request()->except('page'))->links() }}
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Add Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('customer.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Customer Name *</label>
                            <input type="text" class="form-control" id="validationCustom01" name="customer_name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email </label>
                            <input type="email" class="form-control" id="validationCustom02" name="email" placeholder="Email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Phone Number (Max 11 digits. Without +88)</label>
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
                            <label for="validationCustom04">Delivery Address</label>
                            <textarea class="form-control" id="validationCustom04" name="delivery_address" placeholder="Delivery Address"></textarea>
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
                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Edit Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate="" action="{{route('customer.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="customer_id" name="id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Client Name *</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Name" required="">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Phone Number (Max 11 digits. Without +88)</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Designation </label>
                            <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom03">Company Name </label>
                            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom04">Delivery Address</label>
                            <textarea class="form-control" id="delivery_address" name="delivery_address" placeholder="Delivery Address"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom05">Image </label>
                            <div class="col-lg-12">
                                <input type='file' class="form-control" id="" name="image" onchange="readURL2(this);" />
                                <img id="image2" class="customer_image" height="200" width="250" alt="property" /><br>
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
        $(document).on("click", "#editcustomer", function() {
            let id = $(this).attr("data");
            $.ajax({
                url: "/admin/customer/edit/" + id,
                type: "get",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#customer_id").val(response.id);
                    $("#customer_name").val(response.customer_name);
                    $("#email").val(response.email);
                    $("#phone").val(response.phone);
                    $("#address").val(response.address);
                    $("#designation").val(response.designation);
                    $("#company_name").val(response.company_name);
                    $("#delivery_address").val(response.delivery_address);
                    $('.customer_image').attr('src', response.image ? '/'+ response.image  : '/demo.svg');
                }
            })
        })
    </script>
@endsection