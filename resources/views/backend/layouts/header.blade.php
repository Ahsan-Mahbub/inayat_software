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
          <div class="dropdown d-inline-block">
              <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  @if(Auth::user()->image)
                  <img class="rounded-circle header-profile-user" src="/{{Auth::user()->image}}" alt="profile">
                  @else
                  <img class="rounded-circle header-profile-user" src="/logo2.jpeg" alt="profile">
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
