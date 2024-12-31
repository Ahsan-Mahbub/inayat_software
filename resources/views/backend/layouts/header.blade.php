<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box bg-light">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/logo2.jpeg" alt="" height="35">
                    </span>
                    <span class="logo-lg">
                        <img src="/logo.jpeg" alt="" height="65">
                    </span>
                </a>
  
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/logo2.jpeg" alt="" height="35">
                    </span>
                    <span class="logo-lg">
                        <img src="/logo.jpeg" alt="" height="65">
                    </span>
                </a>
            </div>
  
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-backburger"></i>
            </button>
        </div>
  
        <div class="d-flex">
  
            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>
            @isset(auth()->user()->role->permission['permission']['notification']['index'])
            <div class="dropdown d-inline-block">
              <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-bell-outline"></i>
                  <span class="badge badge-danger badge-pill">{{$total_notification}}</span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                  aria-labelledby="page-header-notifications-dropdown">
                  <div class="p-3">
                      <div class="row align-items-center">
                          <div class="col">
                              <h6 class="m-0 font-weight-medium text-uppercase"> Notifications </h6>
                          </div>
                      </div>
                  </div>
                  <div data-simplebar style="max-height: 230px;">
                      @foreach($notifications as $notification)
                      @if($notification->customer)
                      <a href="{{route('customer.transaction', $notification->customer->id)}}" class="text-reset notification-item">
                          <div class="media">
                              <div class="avatar-xs mr-3">
                                  <span class="avatar-title bg-primary rounded-circle font-size-16">
                                      <img src="/{{$notification->customer->image ? $notification->customer->image : 'demo.svg'}}" height="45">
                                  </span>
                              </div>
                              <div class="media-body">
                                  <h6 class="mt-0 mb-1">Collection Money</h6>
                                  <div class="font-size-12 text-muted">
                                      <p class="mb-1">There is a day to collect the due amount from "{{$notification->customer->customer_name}}". Invoice number is {{$notification->sale->invoice}}. The amount is {{$notification->amount}} tk.</p>
                                      <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                          <?php
                                              $timestamp = strtotime($notification->date);
                                              $notification_date = date('d-m-Y', $timestamp);
                                          ?>
                                          {{$notification_date}} 
                                      </p>
                                  </div>
                              </div>
                          </div>
                      </a>
                      @else
                      <a><h6 class="mt-0 mb-1" style="margin: 10px;">Notified Customer Delete</h6></a>
                      @endif
                      @endforeach
                  </div>
                  <div class="p-2 border-top">
                      <a class="btn-link btn btn-block text-center" href="{{route('notification')}}">
                          <i class="mdi mdi-arrow-down-circle mr-1"></i> View More..
                      </a>
                  </div>
              </div>
            </div>
            @endisset
  
  
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::user()->image)
                    <img class="rounded-circle header-profile-user" src="/{{Auth::user()->image}}" alt="profile" style="object-fit: contain">
                    @else
                    <img class="rounded-circle header-profile-user" src="/logo2.jpeg" alt="profile" style="object-fit: contain">
                    @endif
                    <span class="d-none d-sm-inline-block ml-1">{{Auth::user()->name}}</</span>
                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="{{route('profile')}}"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>
                    @isset(auth()->user()->role->permission['permission']['setting']['index'])
                    <a class="dropdown-item" href="{{route('setting.index')}}"><i class="mdi mdi-cogs font-size-16 align-middle mr-1"></i> Settings</a>
                    @endisset
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
  
        </div>
    </div>
  </header>
  