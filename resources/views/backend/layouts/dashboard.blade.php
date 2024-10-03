@extends('backend.layouts.app')
@section('content')
<!-- start page title -->
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Dashboard</h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">Dashboard</li>
              </ol>
          </div>
          
      </div>
  </div>
</div>     
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="text-center mt-5 mb-4">
                            <h5 style="font-weight: 700">Welcome to {{$info->company_name}}</h5>
                            <p class="text-muted mb-4" style="font-weight: 600">Inventory Management Software</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    @isset(auth()->user()->role->permission['permission']['expense']['received'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('budget.employee')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/6491/6491550.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Total Received</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['expense']['office'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('expense.head')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/5501/5501375.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Office Expense</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['product']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('product.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/product-5806313-4863042.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Product Create</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['qr-code']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('qr-code.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/package-location-8697111-6996247.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">QR Code Print</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['requisition']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('requisition.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/requisition-1659069-1408026.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Purchase Quotation</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['purchase']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('purchase.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/purchase-9687788-7887647.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Product Purchase</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['purchase-return']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('purchase.return.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/parcel-return-6914199-5668381.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Purchase Return</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['sale-requisition']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('sale.requisition.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/requisition-1659069-1408026.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Sale Quotation</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['sale']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('sale.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/box-9270441-7607615.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Product Sale</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['sale-return']['create'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('sale.return.create')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/product-return-4889676-4076853.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Sale Return</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection