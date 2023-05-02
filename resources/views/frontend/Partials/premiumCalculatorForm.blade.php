<form action="{{ route('home.compare') }}" class="form-inline" enctype="multipart/form-data"
    method="POST">
    @csrf
    
    <div class="form-row">
        {{--<div class="d-inline form-group col-md-12 calculate-input">

            <label for="category" class="font-weight-bold">Category <i class="fa fa-info-circle" data-toggle="tooltip"
                    data-placement="top" title="Choose a Category"></i></label>
            <select name="category" id="category"
                class="form-control radio-select-box sidecalc-btn ftCalculate" required>
                <option selected disabled>Select a category</option>
                @if(isset($categories))
                @foreach($categories as $category)
                    <option value="{{ $category }}" @if(old('category')==$category) selected @endif>{{ $category }}</option>
                @endforeach
                @endif
            </select>



        </div>--}}
       
        <div class="d-inline form-group col-md-12 calculate-input Calculator-category">
          
            <label for="ageinyears">Category <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                    title="Select your category."></i></label>
                   
            <div class="responsive-hide">
                <div class="btn-group btn-group-toggle " data-toggle="buttons">
                    @if(isset($categories))
                    @foreach($categories as $category)
                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="category" class="sum-cal ftCalculate" id="cat" autocomplete="off" value="{{$category}}"> {{$category}}
                    </label>
                    
                    @endforeach
                    @endif
              
                </div>
               
            </div>
        </div>
         



        <div class="d-inline form-group col-md-12 calculate-input">
            <label for="ageinyears">Age in Years <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                    title="Put your age in years."></i></label>
           
                {{-- <select class="form-control radio-select-box search-select sidecalc-btn" name="birthday_day" id="day"
                    autocomplete="off" required>
                    <option value='' disabled selected>Select Day</option>
                    @for($i = 1; $i <= 31; $i++)
                        <option value={{ $i }}>{{ $i }}</option>
                    @endfor
                </select>
                <select class="form-control search-select radio-select-box sidecalc-btn" name="birthday_month" id="month"
                    autocomplete="off" required>
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
                </select> --}}
                <input class="form-control radio-select-box sidecalc-btn" type="number" name="age" id="year"
                    min="0" max="100" value="" placeholder="Age" required />   
        </div>

        <div class="d-none form-group col-md-12 calculate-input proposer">
            <label for="ageinyears">Proposer date of birth <i class="fa fa-info-circle" data-toggle="tooltip"
                    data-placement="top" title="Put your Prosper date in years."></i></label>
            <div class="calendardate side-calc">
                <select class="form-control radio-select-box sidecalc-btn" name="birth_date" autocomplete="off"
                    >

                    <option value=''>Select Day</option>
                    @for($i = 1; $i <= 31; $i++)
                        <option value={{ $i }}>{{ $i }}</option>
                    @endfor
                </select>
                <select class="form-control radio-select-box sidecalc-btn" name="birth_month" autocomplete="off"
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
                <input class="form-control radio-select-box sidecalc-btn" type="number" name="birth_year" min="1900"
                    max="9999" value="2021" placeholder="YYY"  />


                <span id="agehtml" class="form-control radio-select-box sidecalc-btn text-black age-title">Age</span>

            </div>
        </div>
        <div class="d-inline form-group col-md-12 calculate-input">
            <label for="ageinyears">Choose your Term <i class="fa fa-info-circle" data-toggle="tooltip"
                    data-placement="top" title="Select your Term in years."></i></label>

                {{--    <select id="term" name="term" class="form-control radio-select-box sidecalc-btn" required>
                        <option selected disabled>Select a term</option>
                        @foreach($terms as $term)
                            <option value="{{ $term }}">{{ $term }}</option>
                        @endforeach
                    </select>--}}
           <div class="responsive-hide">
                <div class="btn-group btn-group-toggle " data-toggle="buttons">
                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="5"> 5
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="10"> 10
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="15"> 15
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="20"> 20
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="25"> 25
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="30"> 30
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn term-chk">
                        <input type="radio" class="sum-cal" name="term" autocomplete="off" value="35"> 35
                    </label>
                </div>
                <select class="form-control radio-select-box sidecalc-btn sum-cal-sel" id="termVal" name="term1" autocomplete="off">
                    <option value='0'>More</option>
                    <option value='40'>40</option>
                    <option value='45'>45</option>
                    <option value='50'>50</option>
                    <option value='55'>55</option>
                    <option value='60'>60</option>
                    <option value='65'>65</option>
                </select>
            </div>
            <div class="responsive-show">
                <select class="form-control radio-select-box sidecalc-btn responsive-full-width-box sum-cal-sel" id="termVal1" name="term"
                    autocomplete="off">
                    <option value='' disabled selected>Choose your term e.g. 5yr</option>
                    <option value='5'>5 yrs</option>
                    <option value='10'>10 yrs</option>
                    <option value='15'>15 yrs</option>
                    <option value='20'>20 yrs</option>
                    <option value='25'>25 yrs</option>
                    <option value='30'>30 yrs</option>
                    <option value='35'>35 yrs</option>
                    <option value='45'>45 yrs</option>
                    <option value='50'>50 yrs</option>
                    <option value='55'>55 yrs</option>
                    <option value='60'>60 yrs</option>
                    <option value='65'>65 yrs</option>
                </select>
            </div>
        </div>
{{--
        <div class="d-inline form-group col-md-12 calculate-input">

            <label for="category" class="font-weight-bold">Mode of Payment <i class="fa fa-info-circle" data-toggle="tooltip"
                data-placement="top" title="Put mop mode."></i></label>
                <select id="mop" name="mop" class="custom-select  form-control radio-select-box sidecalc-btn"  autocomplete="off" required>
                
            <option selected disabled>Select a mop</option>
            @if(isset($mops))
            @foreach($mops as $mop)
                            <option value="{{ $mop }}" class="text-capitalize">
                                {{ str_replace('_', ' ', $mop) }}
                            </option>
                        @endforeach
                        @endif
        </select>

            </div>--}}
            <div class="d-inline form-group col-md-12 calculate-input">
          
                <label for="ageinyears">Mode Of Payment <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                        title="Select mop."></i></label>
                       
                <div class="responsive-hide">
                    <div class="btn-group btn-group-toggle " data-toggle="buttons">
                        @if(isset($mops))
                       @foreach($mops as $mop)
                        <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk text-capitalize">
                            <input type="radio" name="mop" class="sum-cal text-capitalize" id="invest" autocomplete="off" value="{{ $mop }}"> {{ str_replace('_', ' ', $mop) }}
                        </label>
                        
                        @endforeach
                        @endif
                  
                    </div>
                   
                </div>
            </div>


        <div class="d-inline form-group col-md-12 calculate-input">
            <label for="ageinyears">Invest Per Year <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                    title="Select your investment."></i></label>
            <div class="responsive-hide">
                <div class="btn-group btn-group-toggle " data-toggle="buttons">
                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="10000"> 10,000
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="15000"> 15,000
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="25000"> 25,000
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="35000"> 35,000
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="50000"> 50,000
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="100000"> 1,00,000
                    </label>

                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk">
                        <input type="radio" name="invest" class="sum-cal" id="invest" autocomplete="off" value="150000"> 1,50,000
                    </label>
                </div>
                <select class="form-control radio-select-box sidecalc-btn sum-cal-sel" id="investVal" name="invest" autocomplete="off">
                    <option value='0'>More</option>
                    <option value='200000'>2,00,000</option>
                    <option value='500000'>5,00,000</option>
                    <option value='1000000'>10,00,000</option>
                    <option value='1500000'>15,00,000</option>
                    <option value='2000000'>20,00,000</option>
                    <option value='2500000'>25,00,000</option>
                    <option value='3000000'>30,00,000</option>
                    <option value='5000000'>50,00,000</option>
                    <option value='10000000'>1 cr</option>
                </select>
            </div>
            <div class="responsive-show">
                <select class="form-control radio-select-box sidecalc-btn responsive-full-width-box sum-cal-sel" id="invest" name="invest"
                    autocomplete="off">
                    <option value='' disabled selected>Choose your term amount</option>
                    <option value='10000'>10 thousand</option>
                    <option value='15000'>15 thousand</option>
                    <option value='25000'>25 thousand</option>
                    <option value='35000'>35 thousand</option>
                    <option value='50000'>50 thousand</option>
                    <option
                        style="width: 100%; color: #E0E0E0; height: 0px !important; padding:0px !important; margin:0px !important;"
                        disabled>----------------------------------------------------------------
                    </option>
                    <option value='100000'>1 Lakh</option>
                    <option value='1500000'>1.5 Lakh</option>
                    <option value='200000'>2 Lakh</option>
                    <option value='500000'>5 Lakh</option>
                    <option value='1000000'>10 Lakh</option>
                    <option value='1500000'>15 Lakh</option>
                    <option value='2000000'>20 Lakh</option>
                    <option value='2500000'>25 Lakh</option>
                    <option value='3000000'>30 Lakh</option>
                    <option style="border-color: red #32a1ce !important;" value='5000000'>50 Lakh
                    </option>
                    <option
                        style="width: 100%; color: #E0E0E0; height: 0px !important; padding:0px !important; margin:0px !important;"
                        disabled>----------------------------------------------------------------
                    </option>
                    <option value='10000000'>1 cr</option>
                </select>
            </div>
        </div>
        
        </div>
       <div class="d-inline form-group col-md-12 calculate-input">
            <label for="ageinyears">Sum Assured <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                    title="Put your sum assured amount."></i></label>

                    <input class="form-control radio-select-box sidecalc-btn sum-assured-val" type="number" name="sum_assured" 
                  id="sum_assured"   value="" placeholder="Sum assured"/>
         {{--   <div class="sum-assured">
                <fieldset class="range__field">
                    <input type="button" class="subBtn" value="-" onClick="subtract_one()">
                    <input class="range" type="range" name="sum_assured" min="0" max="10000000" step="1000"
                        value="5000000" id="sumAssuredRange" data-toggle="tooltip" data-placement="top"
                        title="Rs. 50,00,000">
                    <input type="button" class="addBtn" value="+" onClick="add_one()">
                    <svg class="sum-slider" role="presentation" width="100%" height="30"
                        xmlns="http://www.w3.org/2000/svg">
                        @for($i = 0; $i <= 100; $i++)
                            @if($i % 10)
                                <rect class="range__tick" x="{{ $i }}%" y="3" width="1.5" height="20"></rect>
                            @else
                                <rect class="range__tick show-itm" x="{{ $i }}%" y="3" width="1.5" height="30"></rect>
                            @endif
                        @endfor
                    </svg>
                    <svg class="sum-slider" role="presentation" width="100%" height="14"
                        xmlns="http://www.w3.org/2000/svg">
                        @for($i = 0; $i <= 100; $i++)
                            @if($i % 10 == 0 && $i != 100)
                                <text class="range__point" x="{{ $i }}%" y="20" text-anchor="start">{{ $i }}
                                    {{ $i == 0 ? '' : 'L' }}
                                </text>
                            @endif
                            @if($i == 100)
                                <text class="range__point" x="{{ $i }}%" y="20" text-anchor="start">1 Cr
                                </text>
                            @endif
                        @endfor
                    </svg>
                </fieldset>
            </div>--}}
        </div>


     {{--   <div class="d-inline form-group col-md-12 calculate-input d-none" id="featureRow">
          
            <label for="ageinyears">Features <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                    title="Select mop."></i></label>
                   
            <div class="responsive-hide">
                <div class="btn-group btn-group-toggle " data-toggle="buttons">
                    
                    <label class="btn btn-secondary radio-select-box sidecalc-btn inv-chk text-capitalize">
                   </label>
                 
                   <div id="featuresTab">

                   </div>
                </div>
               
            </div>
        </div>--}}

        

         <!-- Features -->
         <div class="form-group col-12 col-md-6 d-none" id="featureRow">
            <label>Features</label>
            <div id="featuresTab">

            </div>
        </div>


        <div class="form-group submit-btn col-md-12 calculate-input">
            <button type="submit" class="btn btn-primary">Continue</button>
        </div>
    </div>
</form>
