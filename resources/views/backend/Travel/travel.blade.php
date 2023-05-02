@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Travel Medical Insurance Calculator</p>
@endsection
@section('footer_js')
    <script type="text/javascript">
        $('#coverType').on('change', function () {
            var PACKAGE = $("#coverType option:selected").text();

            $.ajax({
                type: "POST",
                url: "{{ route('travel.calculator.medical.insurance.plans') }}",
                data: {
                    PACKAGE: PACKAGE,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.tmiPlans) {
                        $('#planArea').empty().append('<option>Please Select</option>');
                        $('#PackageType').empty().append('<option>Please Select</option>');
                        for (var i = 0; i < response.tmiPlans.data.length; i++) {
                            $('#planArea').append($('<option>', {
                                text: response.tmiPlans.data[i].PlanType
                            }));
                        }
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });
        });
        $('#planArea').on('change', function () {
            var COVERTYPE = $("#coverType option:selected").text();
            var PLAN = $("#planArea option:selected").text();

            $.ajax({
                type: "POST",
                url: "{{ route('travel.calculator.medical.insurance.package') }}",
                data: {
                    COVERTYPE: COVERTYPE,
                    PLAN: PLAN,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.tmiPackages) {
                        $('#PackageType').empty().append('<option>Please Select</option>');
                        for (var i = 0; i < response.tmiPackages.data.length; i++) {
                            $('#PackageType').append($('<option>', {
                                text: response.tmiPackages.data[i].package
                            }));
                        }
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });
        });
        $('.calc-premium').on('input', function () {
            console.log('premium clac applied');
            var COVERTYPE = $("#coverType option:selected").text();
            var PLAN = $("#planArea option:selected").text();
            var PACKAGE = $("#PackageType option:selected").text();
            var Age = $('#AGE').val();
            var Day = $('#Day').val();
            var ISANNUALTRIP = $('#ISANNUALTRIP').is(':checked') == true ? 1 : 0;


            $.ajax({
                type: "POST",
                url: "{{ route('travel.calculator.medical.insurance.premium') }}",
                data: {
                    COVERTYPE: COVERTYPE,
                    PLAN: PLAN,
                    PACKAGE: PACKAGE,
                    Age: Age,
                    Day: Day,
                    ISANNUALTRIP: ISANNUALTRIP
                },
                dataType: 'json',
                success: function (response) {
                    var result = response.tmiPackages;
                    if (result) {
                        $('#PREMIUM').val(result.PremDetails.premiuminUSD)
                        // console.log(response.tmiPackages);
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });
        });
        $(document).ready(function () {
            $('.dob-datepicker').nepaliDatePicker({
                ndpYear: true,
                ndpMonth: true,
                ndpEnglishInput: 'english-date',
                onChange: function (e) {
                    // console.log(e);
                    var EngDate = NepaliFunctions.BS2AD(e.object);
                    var age = calculate_age(new Date(EngDate.year, EngDate.month, EngDate.day));
                    $('#AGE').val(age);
                }
            });
            $('.fromdate-datepicker').nepaliDatePicker({
                ndpYear: true,
                ndpMonth: true,
                ndpEnglishInput: 'from-date',
                onChange: function () {
                    // alert('hello');
                    countDays();
                }
            });
            $('.todate-datepicker').nepaliDatePicker({
                ndpYear: true,
                ndpMonth: true,
                ndpEnglishInput: 'to-date',
                onChange: function () {
                    // alert('hello');
                    countDays();
                }
            });
            $(".dob-datepicker").on("input", function (e) {
                var nepDate = $(this).val();
                var Dt = NepaliFunctions.ConvertToDateObject(nepDate, "YYYY-MM-DD");
                var EngDate = NepaliFunctions.BS2AD(Dt);
                $('#english-date').val(NepaliFunctions.ConvertDateFormat(EngDate));
                // console.log(EngDate);
                var age = calculate_age(new Date(EngDate.year, EngDate.month, EngDate.day));
                $('#AGE').val(age);
            });
            $(".fromdate-datepicker").on("input", function (e) {
                var nepDate = $(this).val();
                var Dt = NepaliFunctions.ConvertToDateObject(nepDate, "YYYY-MM-DD");
                var EngDate = NepaliFunctions.BS2AD(Dt);
                $('#from-date').val(NepaliFunctions.ConvertDateFormat(EngDate));
            });
            $(".todate-datepicker").on("input", function (e) {
                var nepDate = $(this).val();
                var Dt = NepaliFunctions.ConvertToDateObject(nepDate, "YYYY-MM-DD");
                var EngDate = NepaliFunctions.BS2AD(Dt);
                $('#to-date').val(NepaliFunctions.ConvertDateFormat(EngDate));
            });

            function calculate_age(dob) {
                var diff_ms = Date.now() - dob.getTime();
                var age_dt = new Date(diff_ms);
                return Math.abs(age_dt.getUTCFullYear() - 1970);
            }

            function countDays() {
                var dateFrom = NepaliFunctions.ConvertToDateObject($('#from-date').val(), "YYYY-MM-DD");
                var dateTo = NepaliFunctions.ConvertToDateObject($('#to-date').val(), "YYYY-MM-DD");
                if (dateFrom && dateTo){
                    var diffDate = NepaliFunctions.AdDatesDiff(dateFrom, dateTo);
                }
                $('#Day').val(diffDate);
                // console.log(dateFrom);
                // console.log(dateTo);
                // console.log(diffDate);
            };
        });
    </script>
@endsection
<style>
    .calculation-nav li, .calculation-nav li a {
        padding: 20px 10px;
    }

    .calculation-nav li .active {
        color: #444;
        background: #f7f7f7;
    }

    .calc-from {
        padding: 50px 20px;
    }

    .input-group-prepend {
        width: 20%;
    }

    .input-group-text {
        width: 100%;
    }

    .check-title {
        width: 50%;
    }

    .radio-box {
        width: 15%;
    }
</style>
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        {{--        <div class="box-header">--}}
        {{--            <h3 class="box-title">TMI (Travel Medical Insurance) Calculation </h3>--}}
        {{--        </div>--}}
        <div class="box-body">
            @include('layouts.backend.alert')
            <ul class="nav nav-tabs calculation-nav">
                <li><a class="active" data-toggle="tab" href="#firstParty">Travel Medical Insurance</a></li>
                {{--                <li><a data-toggle="tab" href="#thirdParty">Third Party</a></li>--}}
            </ul>
            <div class="tab-content">
                <div id="firstParty" class="tab-pane fade in active show">
                    <form class="calc-from" id="calculationForm"
                          action="{{route('nonLife.calculator.bike.first.party.calculate')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_Id" value="{{Auth::user()->id}}">
                        <input type="hidden" id="CLASSCODE" name="CLASSID" value="{{Request::get('classId')}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Cover Type</div>
                                    </div>
                                    <select class="form-control" id="coverType" name="COVERTYPE" required>
                                        <option selected disabled>Please Select</option>
                                        @if(isset($coverTypes->data))
                                            @foreach ($coverTypes->data as $cat)
                                                <option value="{{ $cat->ID }}">{{ $cat->EDESC }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Plan And Area</div>
                                    </div>
                                    <select class="form-control" id="planArea" name="PLANAREA" required>
                                        <option selected disabled>Please Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Package Type</div>
                                    </div>
                                    <select class="form-control" id="PackageType" name="PACKAGETYPE" required>
                                        <option selected disabled>Please Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Annual Multi Trip !</div>
                                    <div class="input-group-text radio-box">
                                        <input class="form-check calc-premium" style="height: 15px; width: 15px"
                                               aria-label="Checkbox If Its Annual Multi Trip"
                                               type="checkbox" value="1" id="ISANNUALTRIP" name="ISANNUALTRIP">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend date">
                                        <div class="input-group-text">Date Of Birth</div>
                                    </div>
                                    <input type="text" class="form-control dob-datepicker" name="NEPALIDATEOFBIRTH"
                                           placeholder="Select Nepali Date" required>
                                    <input class="form-control" type="text" id="english-date" name="REGISTRATIONDATE"
                                           placeholder="Shows English Date" readonly/>
                                    <input class="form-control calc-premium" type="text" name="Age" id="AGE"
                                           placeholder="Age" readonly/>
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Passport No.</div>
                                    </div>
                                    <input type="text" class="form-control" id="PASSPORTNO"
                                           placeholder="Please enter passport number"
                                           name="PASSPORTNO" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Place Of Visit</div>
                                    </div>
                                    <input type="text" class="form-control" id="PLACEOFVISIT"
                                           placeholder="Please enter place of visit"
                                           name="PLACEOFVISIT" required>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Occupation</div>
                                    </div>
                                    <input type="text" class="form-control" id="OCCUPATION"
                                           placeholder="Please enter Occupation"
                                           name="OCCUPATION" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Contact Number</div>
                                    </div>
                                    <input type="text" class="form-control" id="contactNO"
                                           placeholder="Contact number"
                                           name="CONTACTNUMBER">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend date">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control fromdate-datepicker daysCount"
                                           name="NEPALIFROM"
                                           placeholder="Select Nepali Date" required>
                                    <input class="form-control" type="text" id="from-date" name="FROM"
                                           placeholder="Shows English Date" readonly/>
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend date">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control todate-datepicker daysCount" name="NEPALITO"
                                           placeholder="Select Nepali Date" required>
                                    <input class="form-control" type="text" id="to-date" name="TO"
                                           placeholder="Shows English Date" readonly/>
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">No Of Days</div>
                                    </div>
                                    <input type="number" class="form-control calc-premium" id="Day"
                                           placeholder="Number of stay days"
                                           name="Day" value="0" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Premium</div>
                                    </div>
                                    <select class="form-control" id="premium" name="PREMIUM" required>
                                        <option>USD</option>
                                        {{--                                        <option>NPR</option>--}}
                                    </select>
                                    <input type="text" class="form-control" id="PREMIUM"
                                           placeholder="Premium"
                                           name="PREMIUM" readonly>
                                    <input type="text" class="form-control" id="RATE"
                                           placeholder="Rate"
                                           name="RATE">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rs</div>
                                    </div>
                                    <input type="text" class="form-control" id="RSNPR"
                                           placeholder="Rs In NPR"
                                           name="RSNPR">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Covid Load Charge</div>
                                    </div>
                                    <input type="number" class="form-control" id="COVIDLOADCHARGE"
                                           placeholder="Covid Load Charge %"
                                           name="COVIDLOADCHARGE">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Relation</div>
                                    </div>
                                    <input type="text" class="form-control" id="RELATION"
                                           placeholder="Your Relation" name="RELATION">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Is Dependent !</div>
                                    <div class="input-group-text radio-box">
                                        <input class="form-check" style="height: 15px; width: 15px"
                                               aria-label="Checkbox for dependent"
                                               type="checkbox" value="" id="IDDEPENDENT" name="IDDEPENDENT">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Remarks</div>
                                    </div>
                                    <textarea name="comment" class="form-control" id="comment" rows="5"
                                              placeholder="Your Comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-6 d-none">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Has Agent !</div>
                                    <div class="input-group-text radio-box">
                                        @if(Auth::user()->role_id == 5)
                                            <input type="hidden" value="1" id="HASAGENT" name="HASAGENT">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary mb-2 submit">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
                {{--                <div id="thirdParty" class="tab-pane fade">--}}
                {{--                </div>--}}
            </div>
        </div>
        <!-- /.box-body -->

    </div>
@stop
