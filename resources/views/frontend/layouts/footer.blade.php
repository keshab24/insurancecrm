<section class="footer">
    <img class="top-img" src="{{ asset('frontend/img/footer2.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 footer-logo-part">
                <img class="base-img" src="{{ asset('frontend/img/logo.png') }}" title="Ebeema">
                <p class="base-logo-text">{{__("A team of determined, passionate, and crazy entrepreneurs, developers, and financial engineers set out on one common mission - To make financial and insurance services accessible, simple, and seamless.")}}</p>
            </div>
            <div class="col-sm-4 footer-titile footer-second-item">
                <p>{{__('Contact Info')}}</p>
                <ul class="footer-lists">
                    <li class="fa fa-map-marker"> {{__("Kamaladi Marg, Kamaladi Kathmandu")}}</li>
                    <br>
                    <li class="fa fa-phone"><a href="tel:+9771234567890"> {{__("+977-9801234567890")}}</a></li>
                    <br>
                    <li class="fa fa-envelope"><a href="hi@ebeema.com"> hi@ebeema.com</a></li>
                    <br>
                    <li class="fa fa-clock-o">{{__(" Mon-Fri 10:00 AM - 5:00 PM")}}</li>
                </ul>
            </div>
            <div class="col-sm-4 footer-titile footer-second-item">
                <p>{{__("Explore")}}</p>
                <ul class="footer-lists">
                    <li class="fa fa-angle-double-right"><a href="{{ route('frontend.about') }}"> {{__("About")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Product")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="{{route('home.calculator')}}"> {{__("Calculator")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="{{ route('contact') }}"> {{__("Contact")}}</a></li>
                </ul>
            </div>
        </div>
        <hr class="footer-line">
        <div class="row">
            <div class="col-sm-3 col-xs-6 footer-titile">
                <p>{{__("High return Plan")}}</p>
                <ul class="footer-lists plans-list">
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Investment Plan")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Money Back Plan")}}</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-6 footer-titile">
                <p>{{__('Savings Plan')}}</p>
                <ul class="footer-lists plans-list">
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Pension Plan")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Child Plan")}}</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-6 footer-titile">
                <p>{{__('Life Insurance Plan')}}</p>
                <ul class="footer-lists plans-list">
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Whole-life Plan")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Term Life Plan")}}</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-6 footer-titile">
                <p>{{__("Non-Life Insurance Plan")}}</p>
                <ul class="footer-lists plans-list">
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("2 Wheelers")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("4 Wheelers Plan")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Health Plan")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Travel Plan")}}</a></li>
                    <br>
                    <li class="fa fa-angle-double-right"><a href="#"> {{__("Home Plan")}}</a></li>
                </ul>
            </div>
        </div>
        <hr class="footer-line">
        <div class="row copyright-text">
            <div class="col-sm-3 mobile-display">
                @foreach ($links as $link)
                <a class="footer-media-icon" href="{{ $link->link }}" target="_blank">
                    <i class="{{ $link->icon }}" aria-hidden="true"></i>
                </a>
                @endforeach

                {{-- <a class="footer-media-icon" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a class="footer-media-icon" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a class="footer-media-icon" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> --}}
            </div>
            <div class="col-sm-3 footer-item">
                <p>{{__("Copyright")}} &copy;
                    <script>
                        document.write(new Date().getFullYear());

                    </script>
                    , {{__('All Rights Reserved')}}
                </p>
            </div>
            <div class="col-sm-4 footer-item">
                <a href="#">{{__("Terms & Conditions")}} </a> | <a href="#"> {{__("Privacy Policy")}}</a>
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3 mobile-none">
                @foreach ($links as $link)
                <a class="footer-media-icon" href="{{ $link->link }}" target="_blank">
                    <i class="{{ $link->icon }}" aria-hidden="true"></i>
                </a>
                @endforeach
                {{-- <a class="footer-media-icon" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                <a class="footer-media-icon" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a class="footer-media-icon" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a class="footer-media-icon" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> --}}
            </div>
        </div>
    </div>
</section>
