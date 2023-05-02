@extends('frontend.layouts.app')

@section('content')



<!-- /About Us section-->

<section class="about-us">
    <!-- Breadcrumb and Tilte section -->
    <!-- <div class="col-sm-12 mb-12 about-us-title container">
        <div class="bg-image"></div>

        <div class="bg-text">
            <h1>About Us</h1>
        </div>
    </div> -->
    <!-- Section Ends -->

    <!-- Hero area conistings of Title Paragraph and right side Image -->
    <div class="container aboutUs">
        <div class="row aboutUs--hero">
            @if($aboutUsContent)
            <div class="col-sm-6 aboutUs--herotitle pr-2">
                <h1 class="mb-4">{{$aboutUsContent->about_us_title}}</h1>
                {!! $aboutUsContent->about_us_content !!}
            </div>
            <div class="col-sm-6 aboutUs--hero__img justify-content-center">
                <img class="float-right-img" src="{{asset('frontend/img/aboutUs-heroimage.png')}}">
            </div>
            @endif
        </div>
    </div>
    <!-- Hero area ends -->

    <!-- Features of Ebeema with three different features -->
    <div class="container aboutUs--feature">
        <div class="row">
            @if($aboutUs)
            @foreach($aboutUs as $key => $why)
            <div class="card col-sm-4">
                <div class="row  feature--cards">
                    <div class="col-sm-2">
                        <img src="{{$why->image}}" alt="">
                    </div>

                    <div class="col-sm-10 feature--cards__text">
                        <h1> {{$why->title}}</h1>
                        <p>{{$why->description}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <!-- Features of Ebeema ends -->



    <div class="container core--value--wrapper">
        <div class="row">
            <img src="{{ asset('backend/img/welcome-bg.png') }}" alt="">
            <div class="col-sm-5 core--wrapper">
                <h3>Our Core Values</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Urna pharetra amet, feugiat ut cras. Purus,
                    pulvinar amet, eget auctor cras augue. Diam at vivamus eget vel, sollicitudin. Tempor neque
                    penatibus vel elementum tristique tellus etiam.</p>
                <a href=""><img src="{{ asset('frontend/img/about/CTA-arrow.png') }}" alt=""></a>
            </div>

            <div class="col-sm-7 values--wrapper" style="color: 1px soid red;">
                <div class="row">
                    <div class="col values-wrapper__content">
                        <p>01</p>
                        <div class="core--values">
                            <h6>Holistic Solutions</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Odio urna, pretium pulvinar
                                aenean imperdiet mauris urna</p>
                        </div>
                    </div>
                    <div class="col values-wrapper__content">
                        <p>02</p>
                        <div class="core--values">
                            <h6>Holistic Solutions</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Odio urna, pretium pulvinar
                                aenean imperdiet mauris urna</p>
                        </div>
                    </div>
                    <div class="col values-wrapper__content">
                        <p>03</p>
                        <div class="core--values">
                            <h6>Holistic Solutions</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Odio urna, pretium pulvinar
                                aenean imperdiet mauris urna</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="core-values">
        <div class="items container">
            <div class="card">
                <div class="card-core">
                    <div class="about-core">
                        @if($valuesContent)
                        <h1>{{ $valuesContent->values_title }}</h1>
                        <p>{!! $valuesContent->values_content !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="core-logic">
        <div class="items container">
            <div class="card">
                <div class="card-aboutwe">
                    @if($aboutUs)
                    @foreach($values as $key => $why)
                    <div class="core">
                        <span class="core-number">{{str_pad($loop->iteration, 2, "0", STR_PAD_LEFT)}}</span><br><br>
                        <h1>{{$why->title}}</h1>
                        <p>{{$why->description}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div> -->













    <!-- <div class="core-values">
        <div class="items container">
            <div class="card">
                <div class="card-core">
                    <div class="about-core">
                        @if($valuesContent)
                        <h1>{{ $valuesContent->values_title }}</h1>
                        <p>{!! $valuesContent->values_content !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="core-logic">
        <div class="items container">
            <div class="card">
                <div class="card-aboutwe">
                    @if($aboutUs)
                    @foreach($values as $key => $why)
                    <div class="core">
                        <span class="core-number">{{str_pad($loop->iteration, 2, "0", STR_PAD_LEFT)}}</span><br><br>
                        <h1>{{$why->title}}</h1>
                        <p>{{$why->description}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div> -->






    <div class="container-fluid cta-wrapper aboutUs--cta ">
        <div class="container">
            <div class="row aboutUs--row">
                <div class="col-sm-7">
                    <h2>I want to <span style="color: 47D48E;"><strong><em>talk</em></strong></span> to an Expert.</h2>
                    <p>Our export will call you back <span style="color: 47D48E;"><strong><em>Right
                                    Away</em></strong></span></p>
                    <div class="cta--btn">
                        <a href="#" class="button-icon">
                            <span class="button-icon-text">Talk Now
                                <img src="{{ asset('frontend/img/about/cta-arrow.png') }}" alt="">
                            </span>
                        </a>
                        <!-- <a href="/">Talk Now <span class="cta--btn--icon"><img src="{{ asset('frontend/img/about/cta-arrow.png') }}" alt=""></span></a> -->
                    </div>
                </div>
                <div class="col-sm-5 .aboutUs--cta--btn">
                    <img src="{{ asset('frontend/img/about/CTA-img.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid aboutUs--team--wrapper">
        <div class="container aboutUs--team--container py-5">
            <h3 class="text-center">Our Expert Team</h3>
            <div class="row">
                @foreach($teams as $team)
                <div class="col-sm-4 ">
                    <div class="row team--member--detail">
                        <img src="{{ asset('frontend/img/about/team1.png') }}" alt="">
                        <div class="col-sm text-center team--connect">
                            <h4>{{$team->name}}</h4>
                            <p>{{ $team->designation }}</p>
                            <ul class="list-group">
                                <li>
                                    <a href="{{ $team->linkedin }}"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="{!!  $team->fb !!}"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="{{$team->twitter}}"><i class="fa fa-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection











<!-- Core Values of ebeema Title and Values in bulletin -->
<!-- <div class="core-values">
        <div class="items container">
            <div class="card">
                <div class="card-core">
                    <div class="about-core">
                        @if($valuesContent)
                        <h1>{{ $valuesContent->values_title }}</h1>
                        <p>{!! $valuesContent->values_content !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<!-- Core Values ends -->

<!-- <div class="core-logic">
        <div class="items container">
            <div class="card">
                <div class="card-aboutwe">
                    @if($aboutUs)
                    @foreach($values as $key => $why)
                    <div class="core">
                        <span class="core-number">{{str_pad($loop->iteration, 2, "0", STR_PAD_LEFT)}}</span><br><br>
                        <h1>{{$why->title}}</h1>
                        <p>{{$why->description}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div> -->


<!-- <div class="items container-fluid">
        <div class="card card-talk-expert">
            <div class="card-bodyexpers">
                <div class="about-frae">
                    <h1>I Want to talk to an
                        Expert.</h1>
                    <p>Our expert will call you back Right Away</p>
                    <button>
                        <h1>Talk Now</h1>
                        <img class="talkimg" src="{{asset('frontend/img/about/frame.png')}}" alt="">
                    </button>
                    <img src="{{asset('frontend/img/about/photo-man.png')}}" class="aboutman" alt="">
                </div>
            </div>
        </div>
    </div> -->

<!-- <div class="items container-fluid">
        <div class="card ourteam">
            <h2 class="our-team">Our Expert Teams</h2>
            <div class="card-body card-team">

                <img src="{{asset('frontend/img/about/team1.png')}}" class="teamimg" alt="">

                <div class="card-body card-des">
                    <h4>Rajesh Shrestha</h4>
                    <p>CEO</p>

                    <img src="{{asset('frontend/img/about/linkden.png')}}" class="iconimg" alt="">
                    <img src="{{asset('frontend/img/about/fbk.png')}}" class="iconimg" alt="">
                    <img src="{{asset('frontend/img/about/twitter.png')}}" class="iconimg" alt="">
                </div>


                <img src="{{asset('frontend/img/about/team1.png')}}" class="teamimg" alt="">

                <div class="card-body card-des">
                    <h4>Rajesh Shrestha</h4>
                    <p>CEO</p>

                    <img src="{{asset('frontend/img/about/linkden.png')}}" class="iconimg" alt="">
                    <img src="{{asset('frontend/img/about/fbk.png')}}" class="iconimg" alt="">
                    <img src="{{asset('frontend/img/about/twitter.png')}}" class="iconimg" alt="">
                </div>

                <img src="{{asset('frontend/img/about/team1.png')}}" class="teamimg" alt="">

                <div class="card-body card-des">
                    <h4>Rajesh Shrestha</h4>
                    <p>CEO</p>

                    <img src="{{asset('frontend/img/about/linkden.png')}}" class="iconimg" alt="">
                    <img src="{{asset('frontend/img/about/fbk.png')}}" class="iconimg" alt="">
                    <img src="{{asset('frontend/img/about/twitter.png')}}" class="iconimg" alt="">
                </div>
            </div>
        </div>
    </div> -->
