
<header class="fixed ">
    <div class="main-header">
        <!-- Header Left Navbar Start-->
        <a class="logo" href="/dashboard">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">
        <img src="{{ asset('uploads/logo_mini.png') }}" alt="E-beema_logo">
      </span>
            <!-- logo for regular state and mobile devices -->
            <!-- <span class="logo-lg">Ebeema&nbsp;CMS</span> -->
            <img src="{{ asset('uploads/ebeema_logo.png') }}" alt="E-beema_logo">
        </a>
        <!-- Header Left Navbar Start-->

        <!-- Header Right Navbar Start-->
        <div class="navbar  navbar-static-top d-flex-row justify-content-between" role="navigation">
            <!-- Left Information bar -->
            <div class="d-flex  c-title">
                <a href="#" id="sidebar-collapse" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>
                <div class="c-page-tile">
                    @yield('title')
                </div>
            </div>

            <!-- Right Action bar
             -->
            <div class="d-flex  c-header-actions">
                <div class="navbar-right d-flex flex-row mr-5">
                    @if(control('create-company'))
                        <div class="dropdown header-action mx-2">
                            <a href="#" data-toggle="dropdown" id="addDropDown" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <img src="{{ asset('uploads/add-20.svg') }}" alt="Menu-collapse">
                                {{-- <span class="hidden-xs">{{ isset(auth()->user()->designation) }}</span> --}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right c-popover-body "
                                 aria-labelledby="addDropDown">
                                <a class="dropdown-item c-dropdown" href="{{route('companies.create')}}">Add Company</a>
                                <a class="dropdown-item c-dropdown" href="{{route('admin.leads.index')}}">Add Leads</a>
                                <a class="dropdown-item c-dropdown" href="{{ route('admin.leads.customers') }}">Add Customer</a>
                            </div>
                        </div>
                    @endif

                    @if(control('premium-calculation'))
                        <div class="header-action mx-2">
                            <a href="{{route('premium.create')}}"><img src="{{ asset('uploads/calculator-20.svg') }}"
                                                                       alt="Menu-collapse"></a>
                        </div>
                    @endif
                    <div class="header-action mx-2">
                        <a href="#"><img src="{{ asset('uploads/Icon-bell.svg') }}" alt="Menu-collapse"></a>
                    </div>
                    <div class="dropdown header-action mx-2">
                        <a href="#" data-toggle="dropdown" id="langDropDown" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="{{ asset('uploads/language.svg') }}" width="20" title="Language Select"
                                 alt="Menu-collapse"></a>
                        <div class="dropdown-menu dropdown-menu-right c-popover-body " aria-labelledby="langDropDown">
                            <a class="dropdown-item c-dropdown" href="{{route('setLanguage',['lang'=>'en'])}}">
                                English @if(session()->get('locale') == 'en')<i class="fa fa-check ml-2"
                                                                                aria-hidden="true"></i> @endif</a>
                            <a class="dropdown-item c-dropdown" href="{{route('setLanguage',['lang'=>'np'])}}">
                                नेपाली @if(session()->get('locale') == 'np')<i class="fa fa-check ml-2"
                                                                               aria-hidden="true"></i> @endif</a>
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="profileDropdown"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{ asset('uploads/avatar.png') }}" class="user-image" alt="User Image">
                        {{-- <span class="hidden-xs">{{ isset(auth()->user()->designation) }}</span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right c-popover-body" aria-labelledby="profileDropdown">
                        <a class="dropdown-item c-dropdown text-capitalize" href="{{route('user.profile.edit')}}">{{Auth::User()->username ?? 'User'}} <i class="ml-3 fa fa-user-circle"></i></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item c-dropdown" href="{{route('user.profile.edit')}}">Edit Profile</a>
                        <a class="dropdown-item c-dropdown" href="{{ route('user.kyc.entry') }}">My KYC</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item c-dropdown" href=" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Log Out  <span class="ml-3 fa fa-sign-out logout-btn"></span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

</header>
