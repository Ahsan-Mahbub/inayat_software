@extends('backend.layouts.app')
@section('content')
<style>
    .quick-link .col-lg-3 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 25%;
        flex: 0 0 20%;
        max-width: 20%;
    }
</style>
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
        <div class="">
            <div class="quick-link">
                <div class="row">
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
                    @isset(auth()->user()->role->permission['permission']['inventory']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('inventory.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/inventory-1488878-1259960.png?f=webp&w=256" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Inventory</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['customer']['dues'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('receivable.dues')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/client-2118312-1785007.png?f=webp&w=256" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Dues Client</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset


                    @isset(auth()->user()->role->permission['permission']['budget']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('budget.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/budget-44-444115.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Employee Budget</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['expense']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('expense.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/financial-expenses-3d-icon-download-in-png-blend-fbx-gltf-file-formats--cost-investment-accounting-finance-banking-money-pack-icons-4755624.png?f=webp" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Employee Expense</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['permission']['index'])
                    <div class="col-lg-3 col-md-3 pt-3">
                        <div class="border text-center bg-dark p-1" style="border-radius: 10px">
                            <a href="{{route('permission.index')}}">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/secure-access-permissions-5334939-4455484.png" width="70%">
                                    </div>
                                    <div class="col-7 m-auto">
                                        <h5 class="font-size-15 text-white">Permission</h5>
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