@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Update Permission</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Permission</li>
                    <li class="breadcrumb-item active">Update Permission</li>
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
                <form class="needs-validation" novalidate="" action="{{route('permission.update', $permission->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label>Role <span class="text-danger">*</span></label>
                                <select class="custom-select select2" name="role_id" required="">
                                    <option value="">Select role</option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{$role->id == $permission->role_id ? 'selected' : ''}}>{{$role->role_name}}</option>
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['role']['index']) checked @endisset name="permission[role][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['role']['create']) checked @endisset name="permission[role][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['role']['edit']) checked @endisset name="permission[role][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['role']['destroy']) checked @endisset name="permission[role][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['permission']['index']) checked @endisset name="permission[permission][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['permission']['create']) checked @endisset name="permission[permission][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['permission']['edit']) checked @endisset name="permission[permission][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['permission']['destroy']) checked @endisset name="permission[permission][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['user']['index']) checked @endisset name="permission[user][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['user']['create']) checked @endisset name="permission[user][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['user']['edit']) checked @endisset name="permission[user][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['user']['destroy']) checked @endisset name="permission[user][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['category']['index']) checked @endisset name="permission[category][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['category']['create']) checked @endisset name="permission[category][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['category']['edit']) checked @endisset name="permission[category][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['category']['destroy']) checked @endisset name="permission[category][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['unit']['index']) checked @endisset name="permission[unit][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['unit']['create']) checked @endisset name="permission[unit][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['unit']['edit']) checked @endisset name="permission[unit][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['unit']['destroy']) checked @endisset name="permission[unit][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['watt']['index']) checked @endisset name="permission[watt][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['watt']['create']) checked @endisset name="permission[watt][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['watt']['edit']) checked @endisset name="permission[watt][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['watt']['destroy']) checked @endisset name="permission[watt][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['color']['index']) checked @endisset name="permission[color][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['color']['create']) checked @endisset name="permission[color][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['color']['edit']) checked @endisset name="permission[color][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['color']['destroy']) checked @endisset name="permission[color][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['temperature']['index']) checked @endisset name="permission[temperature][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['temperature']['create']) checked @endisset name="permission[temperature][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['temperature']['edit']) checked @endisset name="permission[temperature][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['temperature']['destroy']) checked @endisset name="permission[temperature][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['discount']['index']) checked @endisset name="permission[discount][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['discount']['create']) checked @endisset name="permission[discount][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['discount']['edit']) checked @endisset name="permission[discount][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['discount']['destroy']) checked @endisset name="permission[discount][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['product']['index']) checked @endisset name="permission[product][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['product']['create']) checked @endisset name="permission[product][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['product']['edit']) checked @endisset name="permission[product][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['product']['destroy']) checked @endisset name="permission[product][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Print</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['product']['print']) checked @endisset name="permission[product][print]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Export</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['product']['export']) checked @endisset name="permission[product][export]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['employee']['index']) checked @endisset name="permission[employee][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['employee']['create']) checked @endisset name="permission[employee][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['employee']['edit']) checked @endisset name="permission[employee][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['employee']['destroy']) checked @endisset name="permission[employee][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['qr-code']['index']) checked @endisset name="permission[qr-code][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Barcode</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['barcode']['index']) checked @endisset name="permission[barcode][index]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['requisition']['index']) checked @endisset name="permission[requisition][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['requisition']['create']) checked @endisset name="permission[requisition][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['requisition']['edit']) checked @endisset name="permission[requisition][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">View</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['requisition']['view']) checked @endisset name="permission[requisition][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approve Status</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['requisition']['approve']) checked @endisset name="permission[requisition][approve]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['requisition']['destroy']) checked @endisset name="permission[requisition][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['supplier']['index']) checked @endisset name="permission[supplier][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['supplier']['create']) checked @endisset name="permission[supplier][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['supplier']['edit']) checked @endisset name="permission[supplier][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['supplier']['destroy']) checked @endisset name="permission[supplier][destroy]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Profile</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['supplier']['profile']) checked @endisset name="permission[supplier][profile]" value="1">
                                                </td>
                                            </tr>  
                                            {{-- <tr>
                                                <td class="text-left">Transaction</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['supplier']['transaction']) checked @endisset name="permission[supplier][transaction]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['index']) checked @endisset name="permission[purchase][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Direct Purchase</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['create']) checked @endisset name="permission[purchase][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Requisition Purchase</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['requisition']) checked @endisset name="permission[purchase][requisition]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Edit</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['edit']) checked @endisset name="permission[purchase][edit]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Invoice</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['view']) checked @endisset name="permission[purchase][view]" value="1">
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['destroy']) checked @endisset name="permission[purchase][destroy]" value="1">
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td class="text-left">Qty Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase']['qty-update']) checked @endisset name="permission[purchase][qty-update]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase-return']['index']) checked @endisset name="permission[purchase-return][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['purchase-return']['create']) checked @endisset name="permission[purchase-return][create]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-request']['index']) checked @endisset name="permission[sample-request][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-request']['create']) checked @endisset name="permission[sample-request][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Edit</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-request']['edit']) checked @endisset name="permission[sample-request][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-request']['destroy']) checked @endisset name="permission[sample-request][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">View</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-request']['view']) checked @endisset name="permission[sample-request][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approve Status</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-request']['approve']) checked @endisset name="permission[sample-request][approve]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-return']['index']) checked @endisset name="permission[sample-return][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sample-return']['create']) checked @endisset name="permission[sample-return][create]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-requisition']['index']) checked @endisset name="permission[sale-requisition][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-requisition']['create']) checked @endisset name="permission[sale-requisition][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Edit</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-requisition']['edit']) checked @endisset name="permission[sale-requisition][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-requisition']['destroy']) checked @endisset name="permission[sale-requisition][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">View</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-requisition']['view']) checked @endisset name="permission[sale-requisition][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approve Status</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-requisition']['approve']) checked @endisset name="permission[sale-requisition][approve]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['index']) checked @endisset name="permission[customer][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Receivable All List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['receive']) checked @endisset name="permission[customer][receive]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Receivable Dues List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['dues']) checked @endisset name="permission[customer][dues]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['create']) checked @endisset name="permission[customer][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['edit']) checked @endisset name="permission[customer][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['destroy']) checked @endisset name="permission[customer][destroy]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Profile</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['profile']) checked @endisset name="permission[customer][profile]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Transaction</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['transaction']) checked @endisset name="permission[customer][transaction]" value="1">
                                                </td>
                                            </tr>     
                                            <tr>
                                                <td class="text-left">Transaction Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['transaction-delete']) checked @endisset name="permission[customer][transaction-delete]" value="1">
                                                </td>
                                            </tr>       
                                            <tr>
                                                <td class="text-left">Print List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['print']) checked @endisset name="permission[customer][print]" value="1">
                                                </td>
                                            </tr>         
                                            <tr>
                                                <td class="text-left">Send Message</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['customer']['message']) checked @endisset name="permission[customer][message]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['index']) checked @endisset name="permission[sale][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Direct Sale</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['create']) checked @endisset name="permission[sale][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Requisition Sale</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['requisition']) checked @endisset name="permission[sale][requisition]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['destroy']) checked @endisset name="permission[sale][destroy]" value="1">
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td class="text-left">Invoice</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['view']) checked @endisset name="permission[sale][view]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Challan</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['challan']) checked @endisset name="permission[sale][challan]" value="1">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="text-left">Payment Schedule</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale']['schedule']) checked @endisset name="permission[sale][schedule]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-return']['index']) checked @endisset name="permission[sale-return][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sale-return']['create']) checked @endisset name="permission[sale-return][create]" value="1">
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
                                                <td class="text-left">Inventory</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['inventory']['index']) checked @endisset name="permission[inventory][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Employee/Dealer Inventory</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['inventory']['dealer']) checked @endisset name="permission[inventory][dealer]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Print</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['inventory']['print']) checked @endisset name="permission[inventory][print]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['payment_mathod']['index']) checked @endisset name="permission[payment_mathod][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['payment_mathod']['create']) checked @endisset name="permission[payment_mathod][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['payment_mathod']['edit']) checked @endisset name="permission[payment_mathod][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['payment_mathod']['destroy']) checked @endisset name="permission[payment_mathod][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['account']['index']) checked @endisset name="permission[account][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['account']['create']) checked @endisset name="permission[account][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['account']['edit']) checked @endisset name="permission[account][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['account']['destroy']) checked @endisset name="permission[account][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['head']['index']) checked @endisset name="permission[head][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['head']['create']) checked @endisset name="permission[head][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['head']['edit']) checked @endisset name="permission[head][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['head']['destroy']) checked @endisset name="permission[head][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sub-head']['index']) checked @endisset name="permission[sub-head][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sub-head']['create']) checked @endisset name="permission[sub-head][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sub-head']['edit']) checked @endisset name="permission[sub-head][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['sub-head']['destroy']) checked @endisset name="permission[sub-head][destroy]" value="1">
                                                </td>
                                            </tr>
                                        </table>
                                    </div> 

                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped text-center ">
                                            <tr>
                                                <th colspan="2">Budget</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">List</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['budget']['index']) checked @endisset name="permission[budget][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['budget']['create']) checked @endisset name="permission[budget][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['budget']['edit']) checked @endisset name="permission[budget][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['budget']['destroy']) checked @endisset name="permission[budget][destroy]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense-requisition']['index']) checked @endisset name="permission[expense-requisition][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense-requisition']['create']) checked @endisset name="permission[expense-requisition][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense-requisition']['edit']) checked @endisset name="permission[expense-requisition][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense-requisition']['destroy']) checked @endisset name="permission[expense-requisition][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approved</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense-requisition']['approved']) checked @endisset name="permission[expense-requisition][approved]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['index']) checked @endisset name="permission[expense][index]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Add</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['create']) checked @endisset name="permission[expense][create]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Update</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['edit']) checked @endisset name="permission[expense][edit]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Delete</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['destroy']) checked @endisset name="permission[expense][destroy]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Approved</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['approved']) checked @endisset name="permission[expense][approved]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Total Received</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['received']) checked @endisset name="permission[expense][received]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Office Expense</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['expense']['office']) checked @endisset name="permission[expense][office]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['sample-request']) checked @endisset name="permission[report][sample-request]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sale Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['sale']) checked @endisset name="permission[report][sale]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sale Quotation Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['sale-requisition']) checked @endisset name="permission[report][sale-requisition]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Purchase Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['purchase']) checked @endisset name="permission[report][purchase]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Purchase Quotation Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['purchase-requisition']) checked @endisset name="permission[report][purchase-requisition]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Purchase & Sale Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['sale-purchase']) checked @endisset name="permission[report][sale-purchase]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Budget Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['budget']) checked @endisset name="permission[report][budget]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Expense Requisition Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['expense-requisition']) checked @endisset name="permission[report][expense-requisition]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Expense Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['expense']) checked @endisset name="permission[report][expense]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Budget & Expense Report</td>
                                                <td class="text-right">
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['report']['budget-expense']) checked @endisset name="permission[report][budget-expense]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['notification']['index']) checked @endisset name="permission[notification][index]" value="1">
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
                                                    <input type="checkbox" class="check-input" @isset($permission['permission']['setting']['index']) checked @endisset name="permission[setting][index]" value="1">
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