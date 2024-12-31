@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Add Permission</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Permission</li>
                    <li class="breadcrumb-item active">Add Permission</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right mb-4">
        @isset(auth()->user()->role->permission['permission']['permission']['index'])
        <a href="{{route('permission.index')}}" class="btn btn-primary btn-sm waves-effect waves-light">Permission List</a>
        @endisset
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('permission.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label>Role <span class="text-danger">*</span></label>
                                <select class="custom-select select2" name="role_id" required="">
                                    <option value="">Select role</option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->role_name}}</option>
                                    @endforeach
                                </select>

                                @error('role_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5"></div>
                        <div class="col-md-3 m-auto">
                            <button type="button" class="isCheckAll btn btn-info" id="isCheckAll" status="true">Check All</button>                         
                        </div>

                        

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Role</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[role][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[role][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[role][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[role][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Permission</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[permission][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[permission][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[permission][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[permission][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">User</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[user][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[user][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[user][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[user][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Categoy</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[category][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[category][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[category][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[category][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Unit</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[unit][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[unit][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[unit][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[unit][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Watt</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[watt][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[watt][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[watt][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[watt][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Body Color</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[color][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[color][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[color][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[color][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Temperature</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[temperature][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[temperature][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[temperature][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[temperature][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Discount</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[discount][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[discount][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[discount][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[discount][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Product</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[product][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[product][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[product][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[product][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Print</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[product][print]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Export</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[product][export]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Employee</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[employee][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[employee][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[employee][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[employee][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">QR / Bar Code</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">QR Code</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[qr-code][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Barcode</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[barcode][index]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Purchase Quotation</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[requisition][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[requisition][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[requisition][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">View</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[requisition][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approve Status</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[requisition][approve]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[requisition][destroy]" value="1">
                                                </td>
                                            </tr> 
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Supplier</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[supplier][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[supplier][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[supplier][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[supplier][destroy]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Profile</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[supplier][profile]" value="1">
                                                </td>
                                            </tr>  
                                            {{-- <tr>
                                                <td class="text-left">Transaction</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[supplier][transaction]" value="1">
                                                </td>
                                            </tr>                                            --}}
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center">
                                            <tr>
                                                <th colspan="2">Purchase</th>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Direct Purchase</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Requisition Purchase</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][requisition]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Invoice</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][view]" value="1">
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td class="text-left">Edit</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][edit]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][destroy]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Qty Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase][qty-update]" value="1">
                                                </td>
                                            </tr>   
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Purchase Return</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase-return][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[purchase-return][create]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Sample Request</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-request][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-request][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Edit</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-request][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-request][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">View</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-request][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approve Status</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-request][approve]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 

                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Sample Return</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-return][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sample-return][create]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 

                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Sale Quotation</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-requisition][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-requisition][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Edit</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-requisition][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-requisition][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">View</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-requisition][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approve Status</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-requisition][approve]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Client</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Receivable All List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][receive]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Receivable Dues List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][dues]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][destroy]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Profile</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][profile]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Transaction</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][transaction]" value="1">
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td class="text-left">Transaction Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][transaction-delete]" value="1">
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td class="text-left">Print List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][print]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Send Message</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[customer][message]" value="1">
                                                </td>
                                            </tr>                                           
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center">
                                            <tr>
                                                <th colspan="2">Sale</th>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Direct Sale</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Requisition Sale</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][requisition]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Invoice</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][view]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Challan</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][challan]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Payment Schedule</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale][schedule]" value="1">
                                                </td>
                                            </tr>   
                                        </table>
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Sale Return</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-return][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sale-return][create]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Inventory</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[inventory][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Print</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[inventory][print]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Payment Method</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[payment_mathod][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[payment_mathod][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[payment_mathod][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[payment_mathod][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Account </th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[account][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[account][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[account][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[account][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                                                  
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Entry Head</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[head][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[head][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[head][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[head][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 

                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Entry Sub Head</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sub-head][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sub-head][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sub-head][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[sub-head][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Employee Budget</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[budget][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[budget][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[budget][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[budget][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Expense Requisition</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense-requisition][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense-requisition][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense-requisition][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense-requisition][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approved</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense-requisition][approved]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Office Expense</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approved</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][approved]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Total Received</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][received]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Office Expense</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[expense][office]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>  
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Report</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sample Request Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][sample-request]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sale Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][sale]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sale Quotation Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][sale-requisition]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Purchase Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][purchase]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Purchase Quotation Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][purchase-requisition]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Purchase & Sale Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][sale-purchase]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Budget Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][budget]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Expense Requisition Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][expense-requisition]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Expense Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][expense]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Budget & Expense Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[report][budget-expense]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Notification</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Notification</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[notification][index]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Setting</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Setting</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" name="permission[setting][index]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
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

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#isCheckAll').on('click', function(){
            var status = $(this).attr('status');
            if (status == 'true') {
                $(".check-input").prop('checked', true);
                $(this).attr('status', 'false');
                $(this).text('Uncheck All');
            } 
            if (status == 'false') {
                $(".check-input").prop('checked', false);
                $(this).attr('status', 'true');
                $(this).text('Check All');
            }
        });
    });
</script>
@endsection