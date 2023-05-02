@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Non Life Motor Calculation Result</p>
@endsection
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
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

    .next-prepend {
        width: 35%;
    }

    .input-group-text {
        width: 100%;
    }

    .border-attachment {
        border: 1px solid #ced4da;
        padding: 20px 0;
    }

    .make-border-text {
        position: relative;
        top: -32px;
        background: #ffff;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 200px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    .custom-file {
        height: auto !important;
    }
    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single{
        height: 100% !important;
    }
</style>
@section('footer_js')
    <script type="text/javascript">
        $('#MAKEVEHICLEID').on('change', function () {
            var mfComp = $("#MAKEVEHICLEID option:selected").val();
            $.ajax({
                type: "POST",
                url: "{{ route('nonLife.calculator.bike.first.party.manufacture.model') }}",
                data: {
                    mfComp: mfComp
                },
                dataType: 'json',
                success: function (response) {
                    var data = response.output;
                    console.log(data);
                    $('#MAKEMODELID').empty().append($('<option>', {
                        text: "Select Model",
                        disabled: "disabled",
                        selected: ''
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#MAKEMODELID').append($('<option>', {
                            value: data[i].ID,
                            text: data[i].ENGNAME
                        }));
                    }
                },
                error: function (e) {
                    console.log('something went wrong' + this.error);
                }
            });
        });
        $(".nepali-datepicker").on("input", function (e) {
            var nepDate = $(this).val();
            var Dt = NepaliFunctions.ConvertToDateObject(nepDate, "YYYY-MM-DD");
            var EngDate = NepaliFunctions.BS2AD(Dt);
            $('#english-date').val(NepaliFunctions.ConvertDateFormat(EngDate));
            // console.log(EngDate);
        });

    </script>
@endsection
@section('dynamicdata')

    <!-- iCheck -->
    @if(isset($output->data))
        <div class="box box-success">
            <h3>Calculated Result - {{Session::get('calculationFor') ? Session::get('calculationFor') : 'motor'}}
                calculation</h3>

            <div class="result-show container-fluid table-wrapper-scroll-y my-custom-scrollbar" id="calculationResult">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Particulars</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody class="scroll-view">
                    @foreach($output->data as $dta)
                        {{--                    @if ($loop->first || $loop->last)--}}
                        <tr>
                            <td>{{$dta->ROWNUMBER}}</td>
                            <td>{{$dta->RskDescription}}</td>
                            <td>{{$dta->Rate}}</td>
                            <td>RS. {{$dta->Amount}}</td>
                        </tr>
                        {{--                    @endif--}}
                    @endforeach
                    </tbody>
                </table>
                {{--    <h4 class="text-center mt-5"><strong>No Data Found</strong></h4>--}}
            </div>
            <hr>
            {{--    {{dd($PremDetails)}}--}}
            <form class="calc-from" id="calculationForm" action="{{route('nonLife.calculator.bike.customer.select')}}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="BRANCHID" value="1">
                <input type="hidden" name="CLASSID" value="{{$requested_data[0]['CLASSID']}}">
                <input type="hidden" name="DEPTID" value="2">
                <input type="hidden" name="HAS_TRAILOR" value="0">
                <input type="hidden" name="BASICPREMIUM_A" value="{{ $PremDetails->BASICPREMIUM ?? '0.00' }}">
                <input type="hidden" name="THIRDPARTYPREMIUM_B" value="{{ $PremDetails->THIRDPARTYPREMIUM ?? '0.00' }}">
                <input type="hidden" name="DRIVERPREMIUM_C" value="{{ $PremDetails->DRIVERPREMIUM ?? '0.00' }}">
                <input type="hidden" name="HELPERPREMIUM_D" value="{{ $PremDetails->HELPERPREMIUM ?? '0.00' }}">
                <input type="hidden" name="PASSENGERPREM_E" value="{{ $PremDetails->PASSENGERPREMIUM ?? '0.00' }}">
                <input type="hidden" name="RSDPREMIUM_F" value="{{ $PremDetails->POOLPREMIUM ?? '0.00' }}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="VEHICLENO">Net Premium</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend next-prepend">
                                <div class="input-group-text">Net Premium (Rs.)</div>
                            </div>
                            <input type="text" class="form-control"
                                   placeholder="Net Premium Amount"
                                   name="NETPREMIUM"
                                   value="{{ $PremDetails->NETPREMIUM ?? '0.00' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6 d-none">
                        <label class="sr-only" for="thirdprty">Third party Premium</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend next-prepend">
                                <div class="input-group-text">Third party Premium(Rs.)</div>
                            </div>
                            <input type="hidden" class="form-control"
                                   placeholder="Third party Premium"
                                   name="THIRDPARTYPREMIUM"
                                   value="{{ $PremDetails->THIRDPARTYPREMIUM ?? '0.00' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="stmp">Stamp</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend next-prepend">
                                <div class="input-group-text">Stamp (Rs.)</div>
                            </div>
                            <input type="text" class="form-control"
                                   placeholder="Stamp"
                                   name="stamp"
                                   value="{{ $_GET['stamp']?? $stamp }}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6 d-none">
                        <label class="sr-only" for="OTHERPREMIUM">Other Premium</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend next-prepend">
                                <div class="input-group-text">Other Premium (Rs.)</div>
                            </div>
                            <input type="hidden" class="form-control" id="OTHERPREMIUM"
                                   placeholder="Other Premium"
                                   name="OTHERPREMIUM"
                                   value="{{ $PremDetails->OTHERPREMIUM ?? '0.00' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="tvp">Total Vatable Premium</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend next-prepend">
                                <div class="input-group-text">Total Vatable Premium (Rs.)</div>
                            </div>
                            <input type="text" class="form-control" id="tvp"
                                   placeholder="Total Vatable Premium"
                                   name="TOTALVATABLEPREMIUM"
                                   value="@php($totalVatable = $PremDetails->NETPREMIUM + $stamp){{ $totalVatable ?? '0.00' }}"
                                   readonly>
                        </div>
                    </div>
                    @php($vaTtotal = $totalVatable * 0.13)
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="inlineFormInputName2">VAT (%)</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">VAT (%)</div>
                            </div>
                            <input type="number" class="form-control" id="VAT"
                                   placeholder="VAT"
                                   name="VAT" value="{{ $_GET['VAT']??'13' }}" readonly>
                            <span class="p-2">Rs.</span><input type="text" class="form-control" id="VATAMT"
                                                               name="VATAMT"
                                                               value="{{ round($vaTtotal,2) ?? '0.00' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="anp">Total Net Premium</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend next-prepend">
                                <div class="input-group-text">Total Net Premium (Rs.)</div>
                            </div>
                            <input type="text" class="form-control" id="anp"
                                   placeholder="Actual Net Premium"
                                   name="TOTALNETPREMIUM"
                                   value="@php($totalNet = $totalVatable + round($vaTtotal,2)){{ $totalNet ?? '0.00' }}"
                                   readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="VEHICLENO">Vehicle No.</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Vehicle No.</div>
                            </div>
                            <input type="text" class="form-control text-uppercase" id="VEHICLENO"
                                   placeholder="Please enter Vehicle Number"
                                   name="VEHICLENO" required
                                   value="{{ $_GET['VEHICLENO']??'' }}">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="ENGINENO">Engine No.</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Engine No.</div>
                            </div>
                            <input type="text" class="form-control text-uppercase" id="ENGINENO"
                                   placeholder="Please enter Engine Number"
                                   name="ENGINENO" required
                                   value="{{ $_GET['ENGINENO']??'' }}">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="CHASISNO">Chasis No.</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Chasis No.</div>
                            </div>
                            <input type="text" class="form-control text-uppercase" id="CHASISNO"
                                   placeholder="Please enter Chasis Number"
                                   name="CHASISNO" required
                                   value="{{ $_GET['CHASISNO']??'' }}">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="MAKEVEHICLEID">Manufacturer Company</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Manufacturer Company</div>
                            </div>
                            <select class="form-control form-control-inline input-medium search-selection" id="MAKEVEHICLEID"
                                    name="MAKEVEHICLEID" required>
                                <option selected disabled>Select the Manufacturer</option>
                                @foreach($manufacturers->data as $manu)
                                    <option value="{{$manu->ID}}">{{$manu->ENGNAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="MAKEMODELID">Model</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Model</div>
                            </div>
                            <select class="form-control form-control-inline input-medium search-selection" id="MAKEMODELID"
                                    name="MAKEMODELID" required>
                                <option selected disabled>Select the Model</option>
                                @foreach($makeModels->data as $mod)
                                    <option value="{{$mod->ID}}">{{$mod->ENGNAME}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="MODEL" id="modelName">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="VEHICLENAMEID">formation</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">formation</div>
                            </div>
                            <select class="form-control form-control-inline input-medium search-selection" id="VEHICLENAMEID"
                                    name="VEHICLENAMEID" required>
                                <option selected disabled>Select the formation</option>
                                @foreach($vehicleNames->data as $vcl)
                                    <option value="{{$vcl->ID}}">{{$vcl->ENGNAME}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="occupation">Occupation</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Occupation</div>
                            </div>
                            <select class="form-control form-control-inline input-medium search-selection" id="BUSSOCCPCODE"
                                    name="BUSSOCCPCODE" required>
                                <option selected disabled>Select the Occupation</option>
                                @foreach($occupationLists->data as $occ)
                                    <option value="{{$occ->BUSSOCCPCODE}}">{{$occ->DESCRIPTION}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="MODEUSE">Mode Of Use</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Mode Of Use</div>
                            </div>
                            <input type="text" class="form-control" id="MODEUSE"
                                   placeholder="Please enter Mode Of Use"
                                   name="MODEUSE" required
                                   value="{{ $_GET['MODEUSE']??'' }}">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="RegistrationDate">Registration Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend date">
                                <div class="input-group-text">Registration Date</div>
                            </div>
                            <input type="text" class="form-control nepali-datepicker" name="NEPALIREGISTRATIONDATE" placeholder="Select Nepali Date" required>
                            <input class="form-control" type="text" id="english-date"  name="REGISTRATIONDATE" placeholder="Shows English Date" readonly/>
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="bluebook_images" id="bluebook_image"
                                   required>
                            <label class="custom-file-label" for="bluebook_images">Browse Blue Book Image</label>
                            <span class="custom-file-image" for="images_view"></span>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="bike_images" id="bike_image" required>
                            <label class="custom-file-label" for="bike_images">Browse Motor Image</label>
                            <span class="custom-file-image" for="images_view"></span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Proceed To Customers</button>
                    </div>
                </div>
            </form>
            <!-- /.box -->
        </div>
    @else
        <div class="text-center">
            <h3>Calculated Result - Error in calculation</h3>
            <br>
            <br>
            <a href="{{route('nonLife.calculator.bike',['classId'=>21])}}" class="btn btn-primary fa fa-arrow-left"> Go
                Back</a>
        </div>
    @endif
    <!-- /.col (right) -->
    <!-- /.row -->
@stop
