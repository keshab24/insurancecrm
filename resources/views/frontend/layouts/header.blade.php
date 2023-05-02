<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <!-- Top Bar -->
    <div class="top-media-bar" id="topMedia">
        <div class="container-fluid">
            <ul class="media-icons list-inline">

                @foreach ($links as $link)
                    <li class="list-inline-item social-top-icn">
                        <a class="top-media-icon" href="{{ $link->link }}" target="_blank">
                            <span class="{{ $link->icon }}"></span>
                        </a>
                    </li>
                @endforeach

                {{-- <li class="list-inline-item"><a class="top-media-icon" href="#"><span class="fa fa-twitter"></span></a>
                </li>
                <li class="list-inline-item"><a class="top-media-icon" href="#"><span class="fa fa-youtube"></span></a>
                </li>
                <li class="list-inline-item"><a class="top-media-icon" href="#"><span class="fa fa-linkedin"></span></a>
                </li> --}}
           
                <li class="list-item-right"><a class="" href="tel:+9771234567890">{{__('+977 9802322097')}}</a><span
                        class="make-bdr"></span></li>
                @if(!Auth::user())
                <li class="list-item-right"><a class="" href="/register">{{__('Register')}}</a><span class="make-bdr"></span>
                </li>
                @endif
                <li class="list-item-right"><a class="" href="#">{{__('FAQ')}}</a><span class="make-bdr"></span></li>
                <li class="list-item-right"><a class="" href="#">{{__("Support")}}</a></li>
                
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed mainMenu" data-toggle="collapse"
                    data-target="#navbarMenu" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" title="Ebeema"><img class="header-logo"
                                                                 src="{{asset('frontend/img/logo.png')}}" width="150"
                                                                 height="60"></a>
        </div>
        <div id="navbarMenu" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-menus">
                <li class="dropdown mob-mnu">
                    <a href="#" class="dropdown-toggle fa fa-heart-o menu-icn" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{__('High return Plan')}} <span class="fa fa-chevron-down main-menu-chevron"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Investment Plan')}}</a></li>
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Money Back Plan')}}</a></li>
                        {{--                        <li role="separator" class="divider"></li>--}}
                        {{--                        <li class="dropdown-header">Nav header</li>--}}
                        {{--                        <li><a href="#">Separated link</a></li>--}}
                    </ul>
                </li>
                <li class="dropdown mob-mnu">
                    <a href="#" class="dropdown-toggle fa fa-heart-o menu-icn" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{__('Savings Plan')}} <span class="fa fa-chevron-down main-menu-chevron"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Pension Plan')}}</a></li>
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Child Plan')}}</a></li>
                    </ul>
                </li>
                <li class="dropdown mob-mnu">
                    <a href="#" class="dropdown-toggle fa fa-heart-o menu-icn" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{__('Term Insurance Plan')}} <span class="fa fa-chevron-down main-menu-chevron"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Whole-life Plan')}}</a></li>
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Term Life Plan')}}</a></li>
                    </ul>
                </li>
                <li class="dropdown mob-mnu">
                    <a href="#" class="dropdown-toggle fa fa-heart-o menu-icn" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"> {{__('General Insurance Plans')}} <span class="fa fa-chevron-down main-menu-chevron"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('2 & 4 wheeler Plan')}}</a></li>
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Health Plan')}}</a></li>
                        <li><a class="fa fa-heart-o menu-icn-sub" href="#">{{__('Travel Plan')}}</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-menus">
                @if(Auth::user())
                    <li class=""><a class="fa fa-heart-o menu-icn" href="/admin"> Dashboard</a></li>
                    <li><a class="menu-icn" href=" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" title="Log out"><span class="fa fa-sign-out logout-btn"></span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </li>
                @else
                    <li class=""><a class="fa fa-heart-o menu-icn" href="/admin"> Login</a></li>
                    <li class=""><a class="header-login-btn no-display-top" href="/register">Register<br><span class="text-small">(as a Agent)</span></a></li>
                @endif
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
