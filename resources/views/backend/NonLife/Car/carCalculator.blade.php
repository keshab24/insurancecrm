@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Non Life Calculator</p>
@endsection
@section('footer_js')


    <script type="text/javascript">

        $('#contactForm').on('submit', function (event) {
            event.preventDefault();

            let age = $('#age').val();
            let term = $('#term').val();
            let sum_assured = $('#sum_assured').val();
            // let subject = $('#subject').val();
            //let message = $('#message').val();


            $.ajax({
                url: "/dhanBristi",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    age: age,
                    term: term,
                    sum_assured: sum_assured,
                    //  subject:subject,
                    //message:message,
                },
                success: function (response) {
                    swal('success', response.message, 'success');
                    $('#tablebody').find('.index').text(
                        response.age);

                },
            });
        });
        $('.excessCalculate').on('change', function () {
            var TYPECOVER = $("#TYPECOVERVal").val();
            var CATEGORYID = $("#categoryListId").val();
            var YEARMANUFACTURE = $("#manufYear").val();

            $.ajax({
                type: "POST",
                url: "{{ route('nonLife.calculator.bike.first.party.compulsary.excess') }}",
                data: {
                    TYPECOVER: TYPECOVER,
                    CATEGORYID: CATEGORYID,
                    YEARMANUFACTURE: YEARMANUFACTURE
                },
                dataType: 'json',
                success: function (response) {
                    // console.log(response.CompulsoryExcess);
                    if (response.CompulsoryExcess != 0) {
                        $('.cmp-excess-amt').val(response.CompulsoryExcess);
                    } else {
                        $('.cmp-excess-amt').val('N/A');
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });
        });
        $('.excess-damage').on('change', function () {
            var TYPECOVER = $("#TYPECOVERVal").val();
            var CATEGORYID = $("#categoryListId").val();
            var CLASSCODE = $("#CLASSCODE").val();
            var VEHICLETYPE = 0;

            $.ajax({
                type: "POST",
                url: "{{ route('nonLife.calculator.motor.excess.damage') }}",
                data: {
                    TYPECOVER: TYPECOVER,
                    CATEGORYID: CATEGORYID,
                    CLASSCODE: CLASSCODE,
                    VEHICLETYPE: VEHICLETYPE
                },
                dataType: 'json',
                success: function (response) {
                    if (response.excessdamages) {
                        $('#ExcessOwnDamage').empty();
                        for (var i = 0; i < response.excessdamages.length; i++) {
                            $('#ExcessOwnDamage').append($('<option>', {
                                value: response.excessdamages[i].TARIFF,
                                text: response.excessdamages[i].TARIFF
                            }));
                        }
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });
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
    .check-title{
        width: 50%;
    }
    .radio-box{
        width: 15%;
    }
</style>
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Car Calculation</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')
            <ul class="nav nav-tabs calculation-nav">
                <li><a class="active" data-toggle="tab" href="#firstParty">Comprehensive</a></li>
                <li><a data-toggle="tab" href="#thirdParty">Third Party</a></li>
            </ul>

            <div class="tab-content">
                <div id="firstParty" class="tab-pane fade in active show">
                    <form class="calc-from" id="calculationForm"
                          action="{{route('nonLife.calculator.bike.first.party.calculate')}}" method="POST">
                        @csrf
                        <input type="hidden" id="CLASSCODE" name="CLASSID" value="{{Request::get('classId')}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="sr-only" for="CATEGORYID">Category</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Category</div>
                                    </div>
                                    <select class="form-control excessCalculate excess-damage"
                                            id="categoryListId"
                                            name="CATEGORYID"
                                            required>
                                        <option selected disabled>Select the Category</option>
                                        @foreach ($categories->data as $cat)
                                            <option value="{{ $cat->CATEGORYID }}">
                                                {{ $cat->CATEGORYNAME }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12 d-none">
                                <label class="sr-only" for="inlineFormInputGroupUsername2">Type of cover</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Type of cover</div>
                                    </div>
                                    <select class="form-control excessCalculate"
                                            id="TYPECOVERVal"
                                            name="TYPECOVER"
                                            required>
{{--                                        <option selected disabled>Select the type cover [Comprehensive (CM), Third Party (TP)]</option>--}}
                                        @if(isset($typeCovers->data))
                                            @foreach($typeCovers->data as $tc)
                                                <option
                                                    {{$tc->CODE == 'CM' ? 'selected' : ''}} value="{{$tc->CODE}}">{{$tc->CODE}}</option>
                                            @endforeach
                                        @else
                                            <option>CM</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">Year Manufacture</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Year Manufacture</div>
                                    </div>
                                    <select class="form-control excessCalculate excess-damage"
                                            id="manufYear"
                                            name="YEARMANUFACTURE"
                                            required>
                                        <option selected disabled>Select Manufactured Year</option>
                                        @foreach($makeYearLists->data as $year)
                                            <option value="{{$year->Manu_Year}}">{{$year->Manu_Year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="CC">Cubic Capacity (cc)</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Cubic Capacity (cc) / KW</div>
                                    </div>
                                    <input type="number" class="form-control" id="CCHP"
                                           placeholder="Car Cubic Capacity e.g. 1200"
                                           name="CCHP" required min="0"
                                           value="{{ $_GET['CCHP']??'' }}">
                                </div>
                            </div>

                            <div class="form-group col-md-12 d-none">
                                <label class="sr-only" for="inlineFormInputGroupUsername2">Goods Carrying
                                    cap/Tons/Hp</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Goods Carrying cap/Tons/Hp</div>
                                    </div>
                                    <input type="number" class="form-control" id="CARRYCAPACITY"
                                           placeholder="Please enter goods carrying"
                                           name="CARRYCAPACITY" min="0"
                                           value="{{ $_GET['CARRYCAPACITY']??'0' }}">
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="EXPUTILITIESAMT">Vehicle Cost</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Vehicle Cost</div>
                                    </div>
                                    <input type="number" class="form-control" id="EXPUTILITIESAMT"
                                           placeholder="Please enter Vehicle Cost"
                                           name="EXPUTILITIESAMT" required min="1"
                                           value="{{ $_GET['EXPUTILITIESAMT']??'' }}">
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">Voluntary  Excess</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Voluntary  Excess</div>
                                    </div>
                                    <select class="form-control form-control-inline input-medium" id="ExcessOwnDamage"
                                            name="EODAMT">
                                        @foreach($excessdamages->data as $damage)
                                            <option value="{{$damage->TARIFF}}">{{$damage->TARIFF}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="sr-only" for="ncdyr">NCD Year</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">NCD Year</div>
                                    </div>
                                    <select class="form-control form-control-inline input-medium" id="NCDYR"
                                            name="NCDYR">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12 d-none ncd-check-btn"></div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">P.A. to Driver</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">P.A. to Driver</div>
                                    </div>
                                    <input type="text" class="form-control" id="PADRIVER"
                                           placeholder="Please enter payble amount."
                                           name="PADRIVER" value="500000" readonly>
                                    <input type="hidden" name="Driver" value="1" readonly>
                                </div>
                            </div>

                            <div class="form-group col-md-12 d-none">
                                <label class="sr-only" for="inlineFormInputName2">P.A. to Employee</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">P.A. to Employee</div>
                                    </div>
                                    <input type="number" class="form-control" id="NOOFEMPLOYEE"
                                           placeholder="Please enter No. of Employees." min="0"
                                           name="NOOFEMPLOYEE" value="{{ $_GET['NOOFEMPLOYEE']??'1' }}">
                                    <input type="text" class="form-control" id="PACONDUCTOR"
                                           placeholder="Please enter payble amount."
                                           name="PACONDUCTOR" value="500000" readonly>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">No. of Passenger</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">No. of Passenger</div>
                                    </div>
                                    <input type="number" class="form-control" id="NOOFPASSENGER"
                                           placeholder="Please enter No. of Passengers." min="0"
                                           name="NOOFPASSENGER" value="{{ $_GET['NOOFPASSENGER']??'4' }}">
                                    <input type="text" class="form-control" id="PAPASSENGER"
                                           placeholder="Please enter payble amount."
                                           name="PAPASSENGER" value="500000" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">Compulsary Excess</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Compulsary Excess</div>
                                    </div>
                                    <input type="text" class="form-control cmp-excess-amt" id="compulsaryExcessAmount"
                                           placeholder="Compulsary excess amount."
                                           name="compulsaryexcessamount" value="N/A" readonly>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Include Towing Charge</div>
                                    <div class="input-group-text radio-box">
                                        <input class="form-check" style="height: 15px; width: 15px"
                                               aria-label="Checkbox for Towing Charge"
                                               type="checkbox" value="1" id="INCLUDE_TOWING" name="INCLUDE_TOWING">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Exclude Pool Premium</div>
                                    <div class="input-group-text radio-box">
                                        <input class="form-check" style="height: 15px; width: 15px"
                                               aria-label="Checkbox for Pool Premium"
                                               type="checkbox" value="" id="pool_premium" name="pool_premium">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 d-none">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Own Goods Carrying/Private Rent</div>
                                    <div class="input-group-text radio-box">
                                        <input class="form-check" style="height: 15px; width: 15px"
                                               aria-label="Checkbox for Own Goods"
                                               type="checkbox" value="1" id="PRIVATE_USE" name="PRIVATE_USE">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group-prepend check-title">
                                    <div class="input-group-text">Is government vehicle !</div>
                                    <div class="input-group-text radio-box">
                                        <input class="form-check" style="height: 15px; width: 15px"
                                               aria-label="Checkbox If it is government vehicle"
                                               type="checkbox" value="1" id="ISGOVERNMENT" name="ISGOVERNMENT">
                                    </div>
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
                <div id="thirdParty" class="tab-pane fade">
                    <form class="calc-from" id="calculationForm"
                          action="{{route('nonLife.calculator.bike.first.party.calculate')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_Id" value="{{Auth::user()->id}}">
                        <input type="hidden" id="CLASSCODE" name="CLASSID" value="{{Request::get('classId')}}">
                        <input type="hidden" id="EXPUTILITIESAMT" name="EXPUTILITIESAMT" value="0">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="sr-only" for="CATEGORYID">Category</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Category</div>
                                    </div>
                                    <select class="form-control excessCalculate"
                                            id="categoryListId"
                                            name="CATEGORYID"
                                            required>
                                        <option selected disabled>Select the Category</option>
                                        @foreach ($categories->data as $cat)
                                            <option value="{{ $cat->CATEGORYID }}">
                                                {{ $cat->CATEGORYNAME }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12 d-none">
                                <label class="sr-only" for="inlineFormInputGroupUsername2">Type of cover</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Type of cover</div>
                                    </div>
                                    <select class="form-control excessCalculate"
                                            id="TYPECOVERVal"
                                            name="TYPECOVER"
                                            required>
{{--                                        <option selected disabled>Select the type cover [Comprehensive (CM), Third Party (TP)]</option>--}}
                                        @foreach($typeCovers->data as $tc)
                                            <option {{$tc->CODE == "TP" ? 'selected' : ''}} value="{{$tc->CODE}}">{{$tc->CODE}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">Year Manufacture</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Year Manufacture</div>
                                    </div>
                                    <select class="form-control excessCalculate"
                                            id="manufYear"
                                            name="YEARMANUFACTURE"
                                            required>
                                        <option selected disabled>Select Manufactured Year</option>
                                        @foreach($makeYearLists->data as $year)
                                            <option value="{{$year->Manu_Year}}">{{$year->Manu_Year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="sr-only" for="CC">Cubic Capacity (cc)</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Cubic Capacity (cc) / KW</div>
                                    </div>
                                    <input type="number" class="form-control" id="CCHP"
                                           placeholder="Car Cubic Capacity e.g. 1200"
                                           name="CCHP" required min="0"
                                           value="{{ $_GET['CCHP']??'' }}">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">P.A. to Driver</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">P.A. to Driver</div>
                                    </div>
                                    <input type="text" class="form-control" id="PADRIVER"
                                           placeholder="Please enter payble amount."
                                           name="PADRIVER" value="500000" readonly>
                                    <input type="hidden" name="Driver" value="1" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="sr-only" for="inlineFormInputName2">No. of Passenger</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">No. of Passenger</div>
                                    </div>
                                    <input type="number" class="form-control" id="NOOFPASSENGER"
                                           placeholder="Please enter No. of Passengers." min="0"
                                           name="NOOFPASSENGER" value="{{ $_GET['NOOFPASSENGER']??'4' }}" readonly>
                                    <input type="text" class="form-control" id="PAPASSENGER"
                                           placeholder="Please enter payble amount."
                                           name="PAPASSENGER" value="500000" readonly>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2 submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>


    <!-- /.box -->
    </div>

    <!-- /.col (right) -->
    </div>
    <!-- /.row -->
@stop
