@extends('frontend.layouts.app')

@section('css')
<style>
    .sideselect-btn {
        width: 100%;
        margin-bottom: 20px;
    }

    .sideselect-btn {
        text-align: left;
        margin-right: 0px;
        padding: 5px 10px;
    }

    .sideselect-btn .active {
        background: #FAFAFA;
        border-radius: 4px;
    }

    .sideselect-btn.active .selected-cmp {
        display: block;
        float: right;
        padding-top: 4px;
    }
</style>
@endsection




@section('content')

<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-9 col-md-7 col-lg-12 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">


                <div class="row">
                    <div class="col-md-12 col-12 mx-0">
                        <form id="msform">
                          @csrf
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Confirm</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
                              <li id="invoice"><strong>Invoice</strong></li>

                                <li id="personal"><strong>Personal</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul> <!-- fieldsets -->
                            <fieldset>

                                <div class="form-card container">
                                    <h2 class="fs-title"><input type="hidden" name="product" placeholder="prod" value="{{$product->id}}" />Selected Product: {{$product->name}}({{$product->company->name}})</h2>
                                   <label for="name">Name:</label>
                                     <input type="text" name="name" placeholder="Name" />

                                    <div class="dob row">
                                        <label for="age">Date Of Birth(actual) <i class="fa fa-info-circle" data-toggle="tooltip"
                                                data-placement="top" title="Put your actual date of birth."></i></label>
                                        <div class="calendardate side-calc" style="display:flex;">
                                            <select class=" radio-select-box sidecalc-btn" name="birth_date" autocomplete="off"
                                                >

                                                <option value=''>Select Day</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value={{ $i }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <select class="radio-select-box sidecalc-btn" name="birth_month" autocomplete="off"
                                                >
                                                <option value='' disabled selected>Select Month</option>
                                                <option value='01'>January</option>
                                                <option value='02'>February</option>
                                                <option value='03'>March</option>
                                                <option value='04'>April</option>
                                                <option value='05'>May</option>
                                                <option value='06'>June</option>
                                                <option value='07'>July</option>
                                                <option value='08'>August</option>
                                                <option value='09'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>

                                            <input class="radio-select-box inpu" type="number" name="birth_year" min="1900"
                                                max="9999" value="2021" placeholder="YYY" style="margin-bottom:5px;" />

                                        </div>
                                    </div>
                                    <input type="hidden" name="age" placeholder="Confirm age" value={{$age}} />
                                      <label for="name">Term:</label>
                                       <input type="number" name="term" value={{$term}} disabled/>
                                       <input type="hidden" name="term" value={{$term}} />
                                       <label for="name">Sum Assured:</label>
                                     <input type="number" name="sum" placeholder="Sum Assured" value={{$sum}} disabled/>
                                     <input type="hidden" name="sum_assured" placeholder="Sum Assured" value={{$sum}} />
                                     <input type="hidden" name="mop" value="{{$mop}}" />
                                     <label for="name">Mode of Payment:</label>
                                     <select id="mop" name="mop" class="custom-select radio-select-box sidecalc-btn"  autocomplete="off" required disabled>

                                        <option selected disabled>Select a mop</option>
                                        @if(isset($mopc))
                                        @foreach($mopc as $mop1)

                                                        <option value="{{ $mop1 }}" @if($mop1 == $mop) selected @endif  class="text-capitalize">
                                                            {{ str_replace('_', ' ', $mop1) }}
                                                        </option>
                                                    @endforeach
                                                    @endif
                                    </select>
                                    <label for="benefits">Benefits:</label>
                                    <div class=" btn-group btn-group-toggle " data-toggle="buttons">
                                        @if(isset($profeatures))
                                        @foreach(json_decode($profeatures[0]) as $feature)

                                        <label class="btn btn-secondary radio-select-box sidecalc-btn active focus">
                                            <h6 class="sum-cal"> {{$feature}}</h6>
                                            <input type="hidden" name="feature" value="{{$feature}}">
                                        </label>

                                       @endforeach
                                       @endif
                                    </div>

                                </div>

                             <input type="button" name="next" class="next action-button confirm" value="Next Step" />
                            </fieldset>

                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Choose a Payment method</h2>
                                    <div class="radio-group">
                                        <div class='radio' data-value="credit"><img src="{{asset('images/utilitypay.png')}}" width="100px"></div>
                                        <div class='radio' data-value="paypal"><img src="{{asset('images/mob.png')}}" width="100px"></div>
                                        <div class='radio' data-value="credit"><img src="{{asset('images/utilitypay.png')}}" width="100px"></div>
                                        <br>
                                    </div> <label class="pay">Card Holder Name*</label> <input type="text" name="holdername" placeholder="" />
                                    <div class="row">
                                        <div class="col-9"> <label class="pay">Card Number*</label> <input type="text" name="cardno" placeholder="" /> </div>
                                        <div class="col-3"> <label class="pay">CVC*</label> <input type="password" name="cvcpwd" placeholder="***" /> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"> <label class="pay">Expiry Date*</label> </div>
                                        <div class="col-9"> <select class="list-dt" id="month" name="expmonth">
                                                <option selected>Month</option>
                                                <option>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                                <option>April</option>
                                                <option>May</option>
                                                <option>June</option>
                                                <option>July</option>
                                                <option>August</option>
                                                <option>September</option>
                                                <option>October</option>
                                                <option>November</option>
                                                <option>December</option>
                                            </select> <select class="list-dt" id="year" name="expyear">
                                                <option selected>Year</option>
                                            </select> </div>
                                    </div>
                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="make_payment" class="next action-button" value="Confirm" />
                            </fieldset>

                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Invoice</h2>

<table class="table">
    <thead>
        <tbody>
            <th colspan="2"><h3 class="font-weight-bold">Policy Timeline</h3>

            <th colspan="2"><h3 class="font-weight-bold">Pay For {{$term}} years</h3></th>
            <th colspan="2"><h3 class="font-weight-bold">Sum Assured: {{convertCurrency($sum)}}</h3></th>
        </tbody>
    </thead>
</table>
<table class="table table-bordered">
    <thead>
        <tr>
        <th><h3 class="font-weight-bold">Term</h3>
            <th ><h3 class="font-weight-bold">Premium</h3></th>
            @if($product->category == 'money-back')
            <th ><h3 class="font-weight-bold">Money Back</h3></th>
            @endif
            <th ><h3 class="font-weight-bold">Bonus</h3></th>
        </th>
    </tr>
    </thead>
        <tbody>
            @for($i = 1; $i <= $term; $i++)
            <tr>
                <td>{{$i}}</td>
                <td>{{$product->premiumAmount}}</td>
                <input type="hidden" name="premium" value="{{ $product->premiumAmount }}">
                @if($product->category == 'money-back')
                <td>-</td>
                @endif
                <td>{{$product->bonus}}</td>
                <input type="hidden" name="bonus" value="{{ floatval($product->bonus) ?? "0" }}">
                 </tr>
            @endfor
           <tr>
               <td rowspan="3">
                   Total {{$term}}
               </td>

           </tr>
        </tbody>
    </thead>
</table>



                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>

                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Personal Information</h2> <input type="text" name="fname" placeholder="First Name" /> <input type="text" name="lname" placeholder="Last Name" /> <input type="text" name="phone" placeholder="Contact No." /> <input type="text" name="phone_2" placeholder="Alternate Contact No." />
                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="submit" name="next" class="next action-button" value="Next Step" />
                            </fieldset>

                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Success !</h2> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-3"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5>You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){

    $('#msform').on('submit',function(e){
    e.preventDefault();
    $.ajax({
      url: "/plan/selected",
      type:"POST",
      data:$('#msform').serialize(),
      success:function(response){

        console.log(response);
      },
     });
    });







    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function(){

    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
    step: function(now) {
    // for making fielset appear animation
    opacity = 1 - now;

    current_fs.css({
    'display': 'none',
    'position': 'relative'
    });
    next_fs.css({'opacity': opacity});
    },
    duration: 600
    });
    });

    $(".previous").click(function(){

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
    step: function(now) {
    // for making fielset appear animation
    opacity = 1 - now;

    current_fs.css({
    'display': 'none',
    'position': 'relative'
    });
    previous_fs.css({'opacity': opacity});
    },
    duration: 600
    });
    });

    $('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
    });

    $(".submit").click(function(){
    return false;
    });

    });
    </script>
    @endsection
