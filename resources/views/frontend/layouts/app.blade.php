<!DOCTYPE html>
<html>

<head>
    <title>Ebeema-Awaring n ensuring since 2015</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Raleway">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('frontend/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/bower_components/select2/dist/css/select2.min.css') }}">


    <!-- /custom style -->
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">

    <!-- /custom google font style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @yield('css')
</head>

<body>
<div id="preloader">
    <div id="loader"></div>
</div>

@include('frontend.layouts.header')

@yield('content')

@include('frontend.layouts.footer')

@include('frontend.layouts.floatingButtons')

<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-angle-up" aria-hidden="true"></i></button>

{{--@include('frontend.Partials.languageModal')--}}

<!-- Scripts -->
<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('backend/bower_components/select2/dist/js/select2.full.min.js') }}"></script>


{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}
@if(!(session()->get('locale')))
    <script>
        $(window).on('load', function () {
            $('#languageModal').modal('show');
        });
    </script>
@endif

<script>
    $(document).ready(function () {
        setTimeout(removeLoader, 1000); //wait for page load PLUS one seconds.
    });

    function removeLoader() {
        $("#preloader").fadeOut(500, function () {
            // fadeOut complete. Remove the loading div
            // $("#preloader").remove(); //makes page more lightweight
        });
    }

    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 50px from the top of the document, show the button
    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            mybutton.style.display = "block";
            topMedia.style.display = "none";
        } else {
            mybutton.style.display = "none";
            topMedia.style.display = "block";
        }
    }

    // When the user clicks on the button, smooth scroll to the top of the document
    function topFunction() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    // :: PreventDefault a Click
    $("a[href='#']").on('click', function ($) {
        $.preventDefault();
    });

    $('.mainMenu').click(function (event) {
        // console.log($("#navbarMenu").hasClass('in'));
        if ($("#navbarMenu").hasClass('in') == true) {
            event.stopPropagation();
            // console.log('yes');
            $(".navbar-collapse").collapse("hide");
        }
    });
    $(document).ready(function () {
        $("[data-toggle=tooltip").tooltip();

        $('#benefit').on('submit',function(e){
       e.preventDefault();

    let feature = $('#feature').val();




    $.ajax({
      url: "/benefit",
      type:"POST",
      data:{
        "_token": "{{ csrf_token() }}",
       feature:feature,


      },
      success:function(response){
        console.log(response);
      },
     });
    });



    });

    $(document).on('change', '#sumAssuredRange', function () {
        var val = this.value;
        val = parseInt(val).toLocaleString('en-IN');
        $('.tooltip-inner').text('Rs. ' + val);
        $('#sumAmt').text(val);
    });

    function add_one() {
        var val = $('#sumAssuredRange').val();
        if (val < 10000000) {
            val = parseInt(val) + 10000;
        }
        newVal = val.toLocaleString('en-IN');
        $('#sumAssuredRange').val(val);
        $(" #sumAssuredRange").attr('data-original-title', 'Rs. ' + newVal);
        $('#sumAmt').text(newVal);
    }

    function subtract_one() {
        var val = $('#sumAssuredRange').val();
        if (val > 0) {
            val = parseInt(val) - 10000;
        }
        newVal = val.toLocaleString('en-IN');
        $('#sumAssuredRange').val(val);
        $(" #sumAssuredRange").attr('data-original-title', 'Rs. ' + newVal);
        $('#sumAmt').text(newVal);
    }

    $('.sum-cal').on('change',function(e){
    let term = $("input[name='term']:checked").val();
    let invest = $("input[name='invest']:checked").val();
    if(term){
    $("#termVal option:selected").prop("selected", false);
    }
    if(invest){
    $("#investVal option:selected").prop("selected", false);
    }
   ClacSumAssured();
  });
  $('.sum-cal-sel').on('change',function(e){
    let term1 = $("#termVal option:selected").val();
    let invest1 = $("#investVal option:selected").val();
    if(term1 > 0){
      $("input[name='term']:checked").prop("checked", false);
      $('.term-chk').removeClass('active');
    }
    if(invest1 > 0){
      $("input[name='invest']:checked").prop("checked", false);
      $('.inv-chk').removeClass('active');
    }
   ClacSumAssured();
  });

  function ClacSumAssured(){
    let term = $("input[name='term']:checked").val();
    let invest = $("input[name='invest']:checked").val();
    let term1 = $("#termVal option:selected").val();
    let invest1 = $("#investVal option:selected").val();
    // console.log(term +'//'+ invest +'//'+ term1 +'//'+invest1);
    let calc = 0;
    if(term > 0 && invest > 0){
    calc = term * invest;
    }
    if(term1 > 0 && invest > 0){
    calc = term1* invest;
    }if(term > 0 && invest1 > 0){
      calc = term* invest1;
    }if(term1 > 0 && invest1 > 0){
      calc = term1 * invest1;
    }
    $(".sum-assured-val").val(calc);
  }
</script>
@yield('script')
</body>

</html>
