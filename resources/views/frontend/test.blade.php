@extends('frontend.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css"
          href="{{asset('frontend/css/slick-theme.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/slick.css')}}"/>


    <style>
        .slick-slide {
            margin: 10px
        }

        .media iframe,
        .media-content {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            border: 0;
            border-radius: inherit;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50% 50%;
            background-color: rgba(120, 120, 120, .1);
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center
        }

        .media-content:before {
            content: '';
            position: absolute;
            height: 10%;
            width: 90%;
            left: 5%;
            bottom: 0;
            background: inherit;
            background-position-y: 100%;
            filter: blur(10px)
        }

        .circle .media-content:before {
            width: 40%;
            left: 30%
        }

        .profile-image {
            width: 100%;
            height: 200px;
            border-top-left-radius: 11px !important;
            border-top-right-radius: 11px
        }

        .card-title {
            font-size: 19px;
            font-weight: 500;
        }

        .card-text {
            color: #000000 !important;
        }

        .card-body {
            padding: 10px;
        }

        h3.mrg-bot-20.team {
            color: white;
            font-size: 40px;
        }
    </style>
@endsection

@section('content')

    <section class="newsletter theme-bg" style="background-image:url(assets/img/bg-new.png)">
        <div class="container">
            <h3 class="mrg-bot-20 team">Our Team</h3>
            <div class="items">
                <div class="card">
                    <div class="media media-2x1 gd-primary">
                        <img class="profile-image"
                             src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1568709978/BBBootstrap/2.jpg">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Delbert Simonas</h5>
                        <p class="card-text">"Online reviews can make or break a customer's decision to make a purchase.
                            Read about these customer review on site"</p>
                    </div>
                </div>
                <div class="card">
                    <div class="media media-2x1 gd-primary">
                        <img class="profile-image"
                             src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1561869127/BBBootstrap/img-3.jpg">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tikoh Amin</h5>
                        <p class="card-text">"When you think of Apple you automatically think expensive if your anything
                            like me. When purchasing this laptop I was skeptical."</p>
                    </div>
                </div>
                <div class="card">
                    <div class="media media-2x1 gd-primary">
                        <img class="profile-image"
                             src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1561869127/BBBootstrap/img-2.jpg">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Malachi Lensing</h5>
                        <p class="card-text">"I’ve wanted a MacBook for a while now because of the build quality and the
                            simplicity of the OS. I spend an average 6 hours a day."</p>
                    </div>
                </div>
                <div class="card">
                    <div class="media media-2x1 gd-primary">
                        <img class="profile-image"
                             src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1561869126/BBBootstrap/img-1.jpg">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Christian Isla</h5>
                        <p class="card-text">"This MacBook has excellent processing speed. The screen is crystal clear
                            and I
                            really enjoy the touchbar. I set it up"</p>
                    </div>
                </div>
                <div class="card">
                    <div class="media media-2x1 gd-primary">
                        <img class="profile-image"
                             src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1563294707/Profile/img-1.jpg">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Lori Charles</h5>
                        <p class="card-text">"For the last 10 years, I have owned an old Gateway laptop. Although it was
                            amazing and lasted me, it was time for an upgrade."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script type="text/javascript" src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script type="text/javascript">
        $('.carousel').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: 'unslick'
                }
            ]
        });

        $(document).ready(function () {

            $('.items').slick({
                slidesToShow: 2,
                slidesToScroll: 1,
                mobileFirst: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: 'unslick'
                    }
                ]
        });
        });
    </script>
@endsection
