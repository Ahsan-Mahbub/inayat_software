<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="/" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (isset(auth()->user()->role->permission['permission']['budget']['index']) || isset(auth()->user()->role->permission['permission']['budget']['create']) || isset(auth()->user()->role->permission['permission']['head']['index']) || isset(auth()->user()->role->permission['permission']['sub-head']['index']) || isset(auth()->user()->role->permission['permission']['expense']['index']) || isset(auth()->user()->role->permission['permission']['expense']['create']))
                <li class="menu-title">Office Expense Module</li>
                    @if (isset(auth()->user()->role->permission['permission']['head']['index']) || isset(auth()->user()->role->permission['permission']['sub-head']['index']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-dice-multiple-outline"></i>
                            <span>Expense Head</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @isset(auth()->user()->role->permission['permission']['head']['index'])
                            <li><a href="{{route('head.index')}}">Expense Head</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['sub-head']['index'])
                            <li><a href="{{route('sub-head.index')}}">Expense Sub Head</a></li>
                            @endisset
                        </ul>
                    </li>
                    @endif
                    @if (isset(auth()->user()->role->permission['permission']['budget']['index']) || isset(auth()->user()->role->permission['permission']['budget']['create']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-dice-multiple-outline"></i>
                            <span>Employee Budget</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @isset(auth()->user()->role->permission['permission']['budget']['create'])
                            <li><a href="{{route('budget.create')}}">Add Budget</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['budget']['index'])
                            <li><a href="{{route('budget.index')}}">Budget List</a></li>
                            @endisset
                        </ul>
                    </li>
                    @endif
                    @if (isset(auth()->user()->role->permission['permission']['expense-requisition']['index']) || isset(auth()->user()->role->permission['permission']['expense-requisition']['create']))
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
                        <li class="">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-dice-multiple-outline"></i>
                                <span>Expense Requisition</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                @isset(auth()->user()->role->permission['permission']['expense-requisition']['create'])
                                <li><a href="{{route('expense.requisition.create')}}">Add Expense Requisition</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['expense-requisition']['index'])
                                <li><a href="{{route('expense.requisition.index')}}">Expense Requisition List</a></li>
                                @endisset
                            </ul>
                        </li>
                        @endif
                    @endif
                    @if (isset(auth()->user()->role->permission['permission']['expense']['index']) || isset(auth()->user()->role->permission['permission']['expense']['create']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-dice-multiple-outline"></i>
                            <span>Office Expense</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @isset(auth()->user()->role->permission['permission']['expense']['create'])
                            <li><a href="{{route('expense.create')}}">Add Expense</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['expense']['index'])
                            <li><a href="{{route('expense.index')}}">Expense List</a></li>
                            @endisset
                        </ul>
                    </li>
                    @endif
                @endif

                @if (isset(auth()->user()->role->permission['permission']['category']['index']) || isset(auth()->user()->role->permission['permission']['temperature']['index']) || isset(auth()->user()->role->permission['permission']['color']['index']) || isset(auth()->user()->role->permission['permission']['unit']['index']) || isset(auth()->user()->role->permission['permission']['watt']['index']) || isset(auth()->user()->role->permission['permission']['product']['index']) || isset(auth()->user()->role->permission['permission']['product']['create']) || isset(auth()->user()->role->permission['permission']['qr-code']['index']) || isset(auth()->user()->role->permission['permission']['barcode']['index']))
                
                    <li class="menu-title">Product Module</li>
                    @if (isset(auth()->user()->role->permission['permission']['category']['index']) || isset(auth()->user()->role->permission['permission']['temperature']['index']) || isset(auth()->user()->role->permission['permission']['color']['index']) || isset(auth()->user()->role->permission['permission']['unit']['index']) || isset(auth()->user()->role->permission['permission']['watt']['index']) || isset(auth()->user()->role->permission['permission']['product']['index']) || isset(auth()->user()->role->permission['permission']['product']['create']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-package-variant-closed"></i>
                            <span>Product</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @isset(auth()->user()->role->permission['permission']['category']['index'])
                            <li><a href="{{route('category.index')}}">Category</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['unit']['index'])
                            <li><a href="{{route('unit.index')}}">Unit</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['watt']['index'])
                            <li><a href="{{route('watt.index')}}">Watt</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['color']['index'])
                            <li><a href="{{route('color.index')}}">Body Color</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['temperature']['index'])
                            <li><a href="{{route('temperature.index')}}">Temperature</a></li>
                            @endisset
                            @if (isset(auth()->user()->role->permission['permission']['product']['create']) || isset(auth()->user()->role->permission['permission']['product']['index']))
                            <li class=""><a href="javascript: void(0);" class="has-arrow">Product</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @isset(auth()->user()->role->permission['permission']['product']['create'])
                                    <li><a href="{{route('product.create')}}">Add Product</a></li>
                                    @endisset
                                    @isset(auth()->user()->role->permission['permission']['product']['index'])
                                    <li><a href="{{route('product.index')}}">Product List</a></li>
                                    @endisset
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (isset(auth()->user()->role->permission['permission']['qr-code']['index']) || isset(auth()->user()->role->permission['permission']['barcode']['index']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi mdi-barcode-scan"></i>
                            <span>Code Generate</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @isset(auth()->user()->role->permission['permission']['qr-code']['index'])
                            <li><a href="{{ route('qr-code.index') }}">QR Code Print</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['barcode']['index'])
                            <li><a href="{{ route('barcode.index') }}">Bar Code Print</a></li>
                            @endisset
                        </ul>
                    </li>
                    @endif
                
                @endif


                @if (isset(auth()->user()->role->permission['permission']['sample-request']['index']) || isset(auth()->user()->role->permission['permission']['sample-request']['create']) || isset(auth()->user()->role->permission['permission']['sample-return']['index']) || isset(auth()->user()->role->permission['permission']['sample-return']['create']))
                
                    <li class="menu-title">Sample Request Module</li>
                    @if (isset(auth()->user()->role->permission['permission']['sample-request']['index']) || isset(auth()->user()->role->permission['permission']['sample-request']['create']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-package-variant-closed"></i>
                            <span>Sample Request</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @if (isset(auth()->user()->role->permission['permission']['sample-request']['index']) || isset(auth()->user()->role->permission['permission']['sample-request']['create']))
                            @isset(auth()->user()->role->permission['permission']['sample-request']['create'])
                            <li><a href="{{route('sample.request.create')}}">Add Sample Request</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['sample-request']['index'])
                            <li><a href="{{route('sample.request.index')}}">Sample Request List</a></li>
                            @endisset
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if (isset(auth()->user()->role->permission['permission']['sample-return']['index']) || isset(auth()->user()->role->permission['permission']['sample-return']['create']))
                        <li class="">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-dice-multiple-outline"></i>
                                <span>Sample Return</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                @isset(auth()->user()->role->permission['permission']['sample-return']['create'])
                                <li><a href="{{route('sample.return.create')}}">Add Sample Return</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['sample-return']['index'])
                                <li><a href="{{route('sample.return.index')}}">Sample Return List</a></li>
                                @endisset
                            </ul>
                        </li>
                    @endif
                
                @endif

                

                @if (isset(auth()->user()->role->permission['permission']['customer']['index'])  || isset(auth()->user()->role->permission['permission']['sale']['index']) || isset(auth()->user()->role->permission['permission']['sale']['create']) || isset(auth()->user()->role->permission['permission']['sale']['requisition']) || isset(auth()->user()->role->permission['permission']['sale-return']['index']) || isset(auth()->user()->role->permission['permission']['sale-return']['create']) || isset(auth()->user()->role->permission['permission']['sale-requisition']['index']) || isset(auth()->user()->role->permission['permission']['sale-requisition']['create']))
                <li class="menu-title">Sales Module</li>
                @isset(auth()->user()->role->permission['permission']['customer']['index'])
                <li>
                    <a href="{{route('customer.index')}}" class="waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span>Client</span>
                    </a>
                </li>
                @endisset
                @if (isset(auth()->user()->role->permission['permission']['sale-requisition']['index']) || isset(auth()->user()->role->permission['permission']['sale-requisition']['create']))
                <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-dice-multiple-outline"></i>
                        <span>Sale Quotation</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        @isset(auth()->user()->role->permission['permission']['sale-requisition']['create'])
                        <li><a href="{{route('sale.requisition.create')}}">Add Quotation</a></li>
                        @endisset
                        @isset(auth()->user()->role->permission['permission']['sale-requisition']['index'])
                        <li><a href="{{route('sale.requisition.index')}}">Quotation List</a></li>
                        @endisset
                    </ul>
                </li>
                @endif

                @if (isset(auth()->user()->role->permission['permission']['sale']['index']) || isset(auth()->user()->role->permission['permission']['sale']['create']) || isset(auth()->user()->role->permission['permission']['sale']['requisition']) || isset(auth()->user()->role->permission['permission']['sale-return']['index']) || isset(auth()->user()->role->permission['permission']['sale-return']['create']))
                <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-dice-multiple-outline"></i>
                        <span>Sales</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        @if (isset(auth()->user()->role->permission['permission']['sale']['index']) || isset(auth()->user()->role->permission['permission']['sale']['create']) || isset(auth()->user()->role->permission['permission']['sale']['requisition']))
                        <li class=""><a href="javascript: void(0);" class="has-arrow">Sales</a>
                            <ul class="sub-menu" aria-expanded="true">
                                @isset(auth()->user()->role->permission['permission']['sale']['create'])
                                <li><a href="{{route('sale.create')}}">Direct Sale</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['sale']['requisition'])
                                <li><a href="{{route('sale.requisition')}}">Quotation Sale</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['sale']['index'])
                                <li><a href="{{route('sale.index')}}">Sale List</a></li>
                                @endisset
                            </ul>
                        </li>
                        @endif
                        @if (isset(auth()->user()->role->permission['permission']['sale-return']['index']) || isset(auth()->user()->role->permission['permission']['sale-return']['create']))
                        <li class=""><a href="javascript: void(0);" class="has-arrow">Sales Return</a>
                            <ul class="sub-menu" aria-expanded="true">
                                @isset(auth()->user()->role->permission['permission']['sale-return']['create'])
                                <li><a href="{{route('sale.return.create')}}">Add Sale Return</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['sale-return']['index'])
                                <li><a href="{{route('sale.return.index')}}">Sale Return List</a></li>
                                @endisset
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @endif
                @isset(auth()->user()->role->permission['permission']['discount']['index'])
                <li>
                    <a href="{{route('discount.index')}}" class="waves-effect">
                        <i class="mdi mdi mdi-minus-box"></i>
                        <span>Discount</span>
                    </a>
                </li>
                @endisset

                @if (isset(auth()->user()->role->permission['permission']['requisition']['index']) || isset(auth()->user()->role->permission['permission']['requisition']['create']) || isset(auth()->user()->role->permission['permission']['supplier']['index']) || isset(auth()->user()->role->permission['permission']['purchase']['create']) || isset(auth()->user()->role->permission['permission']['purchase']['index']) || isset(auth()->user()->role->permission['permission']['purchase']['requisition']) || isset(auth()->user()->role->permission['permission']['purchase-return']['index']) || isset(auth()->user()->role->permission['permission']['purchase-return']['create']))
                <li class="menu-title">Purchase Module</li>
                @isset(auth()->user()->role->permission['permission']['supplier']['index'])
                <li>
                    <a href="{{route('supplier.index')}}" class="waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span>Supplier</span>
                    </a>
                </li>
                @endisset
                @if (isset(auth()->user()->role->permission['permission']['requisition']['index']) || isset(auth()->user()->role->permission['permission']['requisition']['create']))
                <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-dice-multiple-outline"></i>
                        <span>Purchase Quotation</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        @isset(auth()->user()->role->permission['permission']['requisition']['create'])
                        <li><a href="{{route('requisition.create')}}">Add Quotation</a></li>
                        @endisset
                        @isset(auth()->user()->role->permission['permission']['requisition']['index'])
                        <li><a href="{{route('requisition.index')}}">Quotation List</a></li>
                        @endisset
                    </ul>
                </li>
                @endif
                @if (isset(auth()->user()->role->permission['permission']['purchase']['qty-update']) || isset(auth()->user()->role->permission['permission']['purchase']['create']) || isset(auth()->user()->role->permission['permission']['purchase']['index']) || isset(auth()->user()->role->permission['permission']['purchase']['requisition']) || isset(auth()->user()->role->permission['permission']['purchase-return']['index']) || isset(auth()->user()->role->permission['permission']['purchase-return']['create']))
                <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-dice-multiple-outline"></i>
                        <span>Purchase</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        @if (isset(auth()->user()->role->permission['permission']['purchase']['qty-update']) || isset(auth()->user()->role->permission['permission']['purchase']['create']) || isset(auth()->user()->role->permission['permission']['purchase']['index']) || isset(auth()->user()->role->permission['permission']['purchase']['requisition']))
                        <li class=""><a href="javascript: void(0);" class="has-arrow">Purchase</a>
                            <ul class="sub-menu" aria-expanded="true">
                                @isset(auth()->user()->role->permission['permission']['purchase']['create'])
                                <li><a href="{{route('purchase.create')}}">Direct Purchase</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['purchase']['requisition'])
                                <li><a href="{{route('purchase.requisition')}}">Quotation Purchase</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['purchase']['index'])
                                <li><a href="{{route('purchase.index')}}">Purchase List</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['purchase']['qty-update'])
                                <li><a href="{{route('purchase.qty')}}">Product Qty Update</a></li>
                                @endisset
                            </ul>
                        </li>
                        @endif
                        @if (isset(auth()->user()->role->permission['permission']['purchase-return']['index']) || isset(auth()->user()->role->permission['permission']['purchase-return']['create']))
                        <li class=""><a href="javascript: void(0);" class="has-arrow">Purchase Return</a>
                            <ul class="sub-menu" aria-expanded="true">
                                @isset(auth()->user()->role->permission['permission']['purchase-return']['create'])
                                <li><a href="{{route('purchase.return.create')}}">Add Purchase Return</a></li>
                                @endisset
                                @isset(auth()->user()->role->permission['permission']['purchase-return']['index'])
                                <li><a href="{{route('purchase.return.index')}}">Purchase Return List</a></li>
                                @endisset
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @endif

                @if (isset(auth()->user()->role->permission['permission']['inventory']['index']))
                <li class="menu-title">Inventory Module</li>
                <li>
                    <a href="{{route('inventory.index')}}" class="waves-effect">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('inventory.employee')}}" class="waves-effect">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <span>Employee / Dealer Inventory</span>
                    </a>
                </li>
                @endif

                @if (isset(auth()->user()->role->permission['permission']['payment_mathod']['index']) || isset(auth()->user()->role->permission['permission']['account']['index']) || isset(auth()->user()->role->permission['permission']['customer']['receive']) || isset(auth()->user()->role->permission['permission']['account']['dues']))
                <li class="menu-title">Accounts Module</li>
                    @if (isset(auth()->user()->role->permission['permission']['payment_mathod']['index']) || isset(auth()->user()->role->permission['permission']['account']['index']) || isset(auth()->user()->role->permission['permission']['customer']['receive']) || isset(auth()->user()->role->permission['permission']['account']['dues']))
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-dice-multiple-outline"></i>
                            <span>Accounts</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            {{-- <li><a href="{{route('head.index')}}">Entry Head</a></li> --}}
                            @if (isset(auth()->user()->role->permission['permission']['payment_mathod']['index']) || isset(auth()->user()->role->permission['permission']['account']['index']))
                            <li class=""><a href="javascript: void(0);" class="has-arrow">Payment Method</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @isset(auth()->user()->role->permission['permission']['payment_mathod']['index'])
                                    <li><a href="{{route('method.index')}}">Payment Method</a></li>
                                    @endisset
                                    @isset(auth()->user()->role->permission['permission']['account']['index'])
                                    <li><a href="{{route('account.index')}}">Account</a></li>
                                    @endisset
                                </ul>
                            </li>
                            @endif
                            @if (isset(auth()->user()->role->permission['permission']['customer']['receive']) || isset(auth()->user()->role->permission['permission']['customer']['dues']))
                            <li class=""><a href="javascript: void(0);" class="has-arrow">Receivable</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @isset(auth()->user()->role->permission['permission']['customer']['dues'])
                                    <li><a href="{{route('receivable.dues')}}">Dues</a></li>
                                    @endisset
                                    @isset(auth()->user()->role->permission['permission']['customer']['receive'])
                                    <li><a href="{{route('receivable.index')}}">All Client</a></li>
                                    @endisset
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                @endif

                @if (isset(auth()->user()->role->permission['permission']['report']['sample-request']) || isset(auth()->user()->role->permission['permission']['report']['budget-expense']) || isset(auth()->user()->role->permission['permission']['report']['expense']) || isset(auth()->user()->role->permission['permission']['report']['budget']) || isset(auth()->user()->role->permission['permission']['report']['sale-purchase']) || isset(auth()->user()->role->permission['permission']['report']['sale']) || isset(auth()->user()->role->permission['permission']['report']['sale-requisition']) || isset(auth()->user()->role->permission['permission']['report']['purchase']) || isset(auth()->user()->role->permission['permission']['report']['purchase-requisition']))
                <li class="menu-title">Report Module</li>
                    @isset(auth()->user()->role->permission['permission']['report']['sample-request'])
                    <li>
                        <a href="{{route('report.sample.request')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-box"></i>
                            <span>Sample Request Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['sale-requisition'])
                    <li>
                        <a href="{{route('report.sale.requisition')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-outline"></i>
                            <span>Sales Quotation Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['sale'])
                    <li>
                        <a href="{{route('report.sale')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-box"></i>
                            <span>Sales Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['purchase-requisition'])
                    <li>
                        <a href="{{route('report.purchase.requisition')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-outline"></i>
                            <span>Purchase Quotation Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['purchase'])
                    <li>
                        <a href="{{route('report.purchase')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-box"></i>
                            <span>Purchase Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['sale-purchase'])
                    <li>
                        <a href="{{route('report.all-employee')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-outline"></i>
                            <span>Employee Sale & Purchase Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['budget'])
                    <li>
                        <a href="{{route('report.budget')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-box"></i>
                            <span>Budget Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['expense-requisition'])
                    <li>
                        <a href="{{route('report.expense.requisition')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-outline"></i>
                            <span>Expense Requisition Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['expense'])
                    <li>
                        <a href="{{route('report.expense')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-box"></i>
                            <span>Expense Report</span>
                        </a>
                    </li>
                    @endisset
                    @isset(auth()->user()->role->permission['permission']['report']['budget-expense'])
                    <li>
                        <a href="{{route('report.all-account-budget-expense')}}" class="waves-effect">
                            <i class="mdi mdi-file-pdf-outline"></i>
                            <span>Account Budget & Expense Report</span>
                        </a>
                    </li>
                    @endisset
                @endif
                

                @if (isset(auth()->user()->role->permission['permission']['role']['index']) || isset(auth()->user()->role->permission['permission']['permission']['index']))
                    <li class="menu-title">RBAC</li>
                    <li class="">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi mdi-shield-star"></i>
                            <span>RBAC</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @isset(auth()->user()->role->permission['permission']['role']['index'])
                                <li><a href="{{route('role.index')}}">Role</a></li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['permission']['index'])
                                <li><a href="{{route('permission.index')}}">Permission</a></li>
                            @endisset
                        </ul>
                    </li>
                @endif
                @isset(auth()->user()->role->permission['permission']['user']['index'])
                <li>
                    <a href="{{route('user.index')}}" class="waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span>Employee</span>
                    </a>
                </li>
                @endisset
                @isset(auth()->user()->role->permission['permission']['setting']['index'])
                <li class="menu-title">Setting</li>
                <li>
                    <a href="{{route('setting.index')}}" class="waves-effect">
                        <i class="mdi mdi-cogs"></i>
                        <span>Setting</span>
                    </a>
                </li>
                @endisset
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->