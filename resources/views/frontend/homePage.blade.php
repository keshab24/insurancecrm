@extends('frontend.layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/slick-theme.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/slick.css')}}"/>
@endsection
@section('content')
<!-- /Main Carousel section -->
<section class="slider-section">
    <div class="container">
        <div class="row color-top">
            <div class="col-sm-6 top-left-text">
                <h1 class="title">{{__("Nepal's first Digital Insurance Platform.")}}</h1>
                <div class="select-insurance-type">
                    <form method="post" action="#">
                        <select class="insurance-lists">
                            <option value="" selected>Select a insurance type</option>
                            <option value="">High Return Plan</option>
                            <option value="">Endownment Plan</option>
                            <option value="">Money Back Plan</option>

                        </select>
                        <button type="submit" class="insurance-type-submit">Compare&nbsp;&nbsp;<i class="fa fa-calculator"></i></button>
                    </form>
                </div>
                <div class="customer-rating">
                   @if($averageStars)
                   <p class="text-bold">{{__("Customers Review")}}</p>
                   <span class="star-rating">
                    {!! str_repeat('<span><i class="fa fa-star"></i></span>', $averageStars) !!}
                    {!! str_repeat('<span><i class="fa fa-star-o"></i></span>', 5 - $averageStars) !!}
                </span>
                <p style="margin-top: 10px"><b>{{number_format($averageStars,1)}}</b> from <span
                    style="color: #3D538C">{{$totalUsers *100}} Customer</span></p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 top-right-plans">
                   <!--  <div class="row">
                        <div class="col-sm-6 plan-category">
                            <div class="row plan-img-side">
                                <div class="col-sm-1 col-xs-offset-0"></div>
                                <div class="col-sm-12 col-xs-8">
                                    <h2>{{__("High return Plan")}}</h2>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="plan-list-right">
                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Investment Plan')}}
                                        </li>

                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Money Back Plan')}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <img class="plan-img" src="{{asset('frontend/img/home/high-return-plan.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 plan-category">
                            <div class="row plan-img-side">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-12 col-xs-8">
                                    <h2>{{__('Savings Plan')}}</h2>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="plan-list-right">
                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Pension Plan')}}
                                        </li>

                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Child Plan')}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <img class="plan-img" src="{{asset('frontend/img/home/saving-money.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 plan-category">
                            <div class="row plan-img-side">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-12 col-xs-8">
                                    <h2>{{__('Term Insurance Plan')}}</h2>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="plan-list-right">
                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Whole-life Plan')}}
                                        </li>

                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Term Life Plan')}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <img class="plan-img" src="{{asset('frontend/img/home/term-plan.png')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 plan-category">
                            <div class="row plan-img-side">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-12 col-xs-8">
                                    <h2>{{__('General Insurance Plans')}}</h2>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="plan-list-right">
                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('2 & 4 wheeler Plan')}}
                                        </li>

                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Health Plan')}}
                                        </li>

                                        <li class="list-items"><img src="{{asset('frontend/img/list-img.png')}}"> &nbsp;
                                            {{__('Travel Plan')}}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <img class="plan-img" src="{{asset('frontend/img/home/life-insurance.png')}}">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="right-banner-img">
                        <img src="{{asset('frontend/img/banner-img-1.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /calculation compare section -->
    <!-- insurance policy list slider section -->
    <section class="insurance_policy_wrapper">
        <div class="container-fluid">
            <div class="list-of-insurance-policy">
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Endownment Plan</p>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Money Back Plan</p>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Whole-Life Plan</p>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Couple Plan</p>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Single Premium Plan</p>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Child Plan</p>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-content">
                        <img src="{{asset('frontend/img/icon/endownment.png')}}">
                        <p>Term Life</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of insurance policy list slider -->
    <!---  why different section -->
    <section class="why-different">
        <div class="why-diff-title">
            <h2 class="text-capitalize text-center">Why EBeema?</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-xs-12 why-different-div">
                    @if($whyDifferentContent)
                    <div class="why-diff-left  text-left">
                        <div class="diff-top">
                            <h2>{!!  $whyDifferentContent->why_diff_title !!}</h2>
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </div>
                        {!! $whyDifferentContent->why_diff_content !!}
                    </div>
                    @endif
                </div>
                <div class="col-sm-7 col-xs-12 why-different-items">
                    <div class="row">
                        @foreach($whyDifferent as $whyD)
                        <div class="col-sm-6 why-diff-right">
                            <img src="{{$whyD->image}}" title="{{$whyD->title}}">
                            <h2>{{$whyD->title}}</h2>
                            <p>{{$whyD->description }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--end of why different -->
    <section class="how-it-works">
        <div class="container-fluid">
           <div class="how-works-title">
            <h2 class="text-capitalize text-center">how Ebeema works</h2>
        </div>
        <div class="row working-bar">
            <!-- <div class="how-works"></div> -->
            <div class="col-sm-2 col-xs-12 resp-width-wrk">
                <!-- <span class="head-number">1</span><br><br> -->
                <img src="{{asset('frontend/img/home/web1.png')}}">
                <p class="how-first-prag">{{__('Visit Ebeema.com')}}</p>
                <p>{{__('Visit our website ebeema.com')}}</p>
            </div>
            <div class="col-sm-2 col-xs-12 resp-width-wrk">
                <!-- <span class="head-number">2</span><br><br> -->
                <img src="{{asset('frontend/img/home/web2.png')}}">
                <p class="how-first-prag">{{__('Compare Prices')}}</p>
                <p>{{__("Compare the prices and returns of different insurance plans.")}}</p>
            </div>
            <div class="col-sm-2 col-xs-12 resp-width-wrk">
             <!--  <span class="head-number">3</span><br><br> -->
             <img src="{{asset('frontend/img/home/web3.png')}}">
             <p class="how-first-prag">{{__('Buy online')}}</p>
             <p>{{__('Buy online and get a call from our support team.')}}</p>
         </div>
         <div class="col-sm-2 col-xs-12 resp-width-wrk">
             <!--  <span class="head-number">4</span><br><br> -->
             <img src="{{asset('frontend/img/home/web4.png')}}">
             <p class="how-first-prag">{{__('Insure your self')}}</p>
             <p>{{__('Live life knowing your loved ones are secure.')}}</p>
         </div>
         <div class="col-sm-2 col-xs-12 resp-width-wrk">
             <!--  <span class="head-number">5</span><br><br> -->
             <img src="{{asset('frontend/img/home/web5.png')}}">
             <p class="how-first-prag">{{__('Get updated')}}</p>
             <p>{{__('Closely monitor your insurance policy and be updated.')}}</p>
         </div>
     </div>
 </div>
</section>

<!-- end of insurance policy list slider section  -->
<!-- Why Us section -->
<section class="why-us d-none">
    <div class="container">
        <div class="row p-5">
            <div class="col-sm-6 why-us-left-banner">
                @if($whyUsContent)
                <h2 class="">{{$whyUsContent->why_us_title}} </h2>
                <br>
                {!! $whyUsContent->why_us_content !!}

                <a href="/about" class="btn btn-primary text-uppercase">Learn more</a>
                @endif
            </div>
            <div class="col-sm-6 why-us-right-banner">
                <div class="row whyItems">
                    @if($whyUs)
                    @foreach($whyUs as $key => $why)
                    <div class="card">
                        <div class="col-sm-6 card-body why-us-card-body @if($loop->even) make-space @endif">
                            <div class="text-center why-box-right">
                                <img src="{{$why->image}}" title="{{$why->title}}">
                                <h3 class="text-uppercase">{{$why->title}}</h3>
                                <p>{{ $why->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="how-much">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 how-much-left">
                <img src="{{asset('frontend/img/home/how-much.png')}}">
                <img class="responsive-only" src="{{asset('frontend/img/home/how-much-half.png')}}">
            </div>
            <div class="col-sm-7 how-much-right">
                <div class="background-dull">
                    <h2>{{__('How much Life insurance Do I Need?')}}</h2>
                    <p>{{__("The uncertainty of tomorrow has always been difficult for us to imagine in the past and is going to continue to be difficult for us in the future.")}}</p>
                    <p>{{__("We cannot stop it but we can prepare try and be safe for our ourselves and our family. This is the main goal of insurance, Let Ebeema help you get the best insurance for you.")}}</p>
                    <a href="#" class="btn btn-primary btn-sm">{{__('Get Quote')}}</a>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section class="testimonials-section">
    <div class="training-title container text-center">
        <h2 class="">{{__('What our customer says')}}</h2>
        <span class="slider-arrows">
            <button class="fa fa-angle-left slider-btn" id="slick-previous"></button>
            <button class="fa fa-angle-right slider-btn" id="slick-next"></button></span>
        </div>
        <div class="items container-fluid">
            @foreach($testimonials as $testimonial)
            <div class="card testimonials-card">
                <div class="card-body testimonials-card-body">
                    <div class="img-box"><img
                        src="{{$testimonial->image}}"
                        title="{{$testimonial->name}}"></div>
                        <div class="user-content">
                            {{text_limit($testimonial->comment,180)}}
                        </div>
                        <div class="mx-auto text-center">

                            <div class="star-rating">
                                <ul class="list-inline">
                                    @for($i = 1; $i <= $testimonial->rating; $i++)
                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                                <div class="client-details text-capitalize">
                                    <h5 class="client-name">{{$testimonial->name}}</h5> <span
                                    class="client-company-name">{{$testimonial->designation}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            <section class="calculate-now">
                <div class="container">
                   <!--  <div class="row calculate-bar">
                        <div class="col-sm-6">
                            <h4 class="text-first">{{__("I'm Ready !")}}</h4>
                            <h4 class="text-second">{{__("Calculate Insurance Now")}}</h4>
                        </div>
                        <div class="col-sm-6">
                            <a href="/calculator" class="calc-right-button">{{__("Calculate Now")}}</a>
                        </div>
                    </div> -->
                    <div class="insurance-now-wrapper">
                        <div class="insurance-now-title">
                            <h2>What are you waiting for ?</h2>
                            <p>Let's get started</p>
                            <p><a href="#">Insurance Now</a></p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- latest section -->
            <section class="latest-section">
                <div class="container">
                    <div class="latest-title">
                        <h2>Latest</h2>
                    </div>
                    <div class="latest-wrapper">
                        <div class="latest-item">
                            <div class="latest-content">
                                <div class="latest-img">
                                    <img src="{{asset('frontend/img/latest/latest-1.png')}}">
                                </div>
                                <div class="latest-shortdesc">
                                    <div class="latest-time-cat">
                                        <p class="latest-cat"><strong>Fruit</strong><span>5 mins read</span></p>

                                        <p class='desc'>Simple Juice Recipes to boost your immune system </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="latest-item">
                            <div class="latest-content">
                                <div class="latest-img">
                                    <img src="{{asset('frontend/img/latest/latest-1.png')}}">
                                </div>
                                <div class="latest-shortdesc">
                                    <div class="latest-time-cat">
                                        <p class="latest-cat"><strong>Fruit</strong><span>5 mins read</span></p>

                                        <p class='desc'>Simple Juice Recipes to boost your immune system </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="latest-item">
                            <div class="latest-content">
                                <div class="latest-img">
                                    <img src="{{asset('frontend/img/latest/latest-1.png')}}">
                                </div>
                                <div class="latest-shortdesc">
                                    <div class="latest-time-cat">
                                        <p class="latest-cat"><strong>Fruit</strong><span>5 mins read</span></p>

                                        <p class='desc'>Simple Juice Recipes to boost your immune system </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="latest-view-all">
                        <a href="#">View all</a>
                    </div>
                </div>
            </section>
            <!-- end of latest section -->
            <section class="associations">
                <div class="association-title">
                    <h2 class="text-capitalize text-center">{{__("Our Association")}}</h2>
                </div>
                <div class="container">
                    @if(count($associations->where('association_type',1)))
                    <h2 class="association-cat">{{__('Life Insurance')}}</h2>
                    <div class="row">
                        @foreach($associations->where('association_type',1) as $association)
                        <div class="col-sm-3 col-xs-6">
                            <img class="association-img" src="{{$association->image}}"
                            title="{{$association->name ? $association->name : 'Our Association'}}">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if(count($associations->where('association_type',2)))
                    <br>
                    <h2 class="association-cat">{{__('Non Life Insurance')}}</h2>
                    <div class="row">
                        @foreach($associations->where('association_type',2) as $association)
                        <div class="col-sm-3 col-xs-6">
                            <img class="association-img" src="{{$association->image}}"
                            title="{{$association->name ? $association->name : 'Our Association'}}">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>

            <section class="compare-now">
                <div class="container">
                    <div class="row comp-color">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4 compare-left-img">
                            <img src="{{asset('/uploads/compare.png')}}">
                        </div>
                        <!-- <div class="col-sm-1"></div> -->
                        <div class="col-sm-7 compare-right text-center">
                            <h3>You’ve made it to the end!</h3>
                            <p>We try to make your life as easy as cheese.<br>
                            Try comparing Insurance and get insured that fits your needs. </p>
                            <a class="fa fa-calculator compare-btn"> Compare Now</a>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </section>
            @endsection
            @section('script')
            <script type="text/javascript" src="{{asset('frontend/js/slick.min.js')}}"></script>
            <script>
                $(document).ready(function () {

                    $('.items').slick({
                        dots: false,
                        nextArrow: document.getElementById('slick-next'),
                        prevArrow: document.getElementById('slick-previous'),
                        infinite: true,
                        speed: 800,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 800,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                dots: true,
                                arrows: true
                            }
                        }

                        ]
                    });

                    $('.whyItems').slick({
                        dots: true,
                        infinite: true,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        responsive: [
                        {
                            breakpoint: 2600,
                            settings: 'unslick'
                        },
                        {
                            breakpoint: 800,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 450,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }

                        ]
                    });
                });
            </script>
            @endsection
