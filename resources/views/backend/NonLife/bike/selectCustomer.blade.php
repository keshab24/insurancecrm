@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Non Life Motor Calculation Select Customer</p>
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

    .next-prepend {
        width: 30%;
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

    /*Customer Modal CSS*/

    .calculation-nav li,
    .calculation-nav li a {
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
        width: 30%;
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

    #ndp-nepali-box {
        top: 100px !important;
        right: 55px !important;
        left: auto !important;
    }

    .custom-file {
        height: auto !important;
    }

    @media only screen and (max-width: 1025px) {
        .select-cust-modal {
            max-width: 95% !important;
        }

    }
</style>
@section('footer_js')
    <script src="{{asset('js/sweetalert2@11.js')}}"></script>
    <script>

        $(document).ready(function () {
            $('.search-select').select2();
            getDetails();
        });

        function getDetails() {
            var details = $('.search-select').find(':selected').data('details');
            // console.log(details);
            if (details) {
                $('#printCustomerDetails').empty().append('<ul id="custmrList"><li>Customer Name: ' + details.INSUREDNAME_ENG + '</li><li>Address: ' + details.ADDRESS + '</li><li>Citizenship No.: ' + details.CITIZENSHIPNO + '</li><li>Date Of Birth: ' + details.DATEOFBIRTH + '</li><li>Email: ' + details.EMAIL + '</li><li>Fathers Name: ' + details.FATHERNAME + '</li><li>Grandfather Name: ' + details.GRANDFATHERNAME + '</li><li>Grandmother Name: ' + details.GRANDMOTHERNAME + '</li><li>Mobile Number: ' + details.MOBILENO + '</li><li>Mothers Name: ' + details.MOTHERNAME + '</li><li>Temporary Address: ' + details.TEMPORARYADDRESS + '</li></ul>');
            }
        };

        $('#provinceId').on('change', function () {
            var provinceID = $(this).val();
            // console.log(provinceID);
            $.ajax({
                type: "POST",
                url: "{{ route('province.district') }}",
                data: {
                    provinceID: provinceID
                },
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    $('#districtId').empty().append($('<option>', {
                        text: "Select District",
                        disabled: "disabled",
                        selected: ''
                    }));
                    for (var i = 0; i < response.length; i++) {
                        $('#districtId').append($('<option>', {
                            value: response[i].ID,
                            text: response[i].EDESCRIPTION
                        }));
                    }

                    $('#ISSUE_DISTRICT_ID_LIST').empty().append($('<option>', {
                        text: "Select Issued District",
                        disabled: "disabled",
                        selected: ''
                    }));
                    for (var i = 0; i < response.length; i++) {
                        $('#ISSUE_DISTRICT_ID_LIST').append($('<option>', {
                            value: response[i].ID,
                            text: response[i].EDESCRIPTION
                        }));
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });

        });
        $('#districtId').on('change', function () {
            var DistrictID = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('district.mnuvdc') }}",
                data: {
                    DistrictID: DistrictID
                },
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    $('#MNUId').empty().append($('<option>', {
                        text: "Select Municipality ",
                        disabled: '',
                        selected: ''
                    }));
                    for (var i = 0; i < response.mnu.length; i++) {
                        $('#MNUId').append($('<option>', {
                            value: response.mnu[i].MNUCODE,
                            text: response.mnu[i].MNU
                        }));
                    }

                    $('#VDCId').empty().append($('<option>', {
                        text: "Select VDC ",
                        disabled: '',
                        selected: ''
                    }));
                    for (var j = 0; j < response.vdc.length; j++) {
                        $('#VDCId').append($('<option>', {
                            value: response.vdc[j].VDCCODE,
                            text: response.vdc[j].VDC
                        }));
                    }
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });

        });

        $('#AddKycCustomer').on('click', function (e) {
            e.preventDefault();
            $("#AddKycCustomer").prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "{{ route('user.kyc.entry') }}",
                data: $("#calculationForm").serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#preloader').show();
                },
                success: function (response) {
                    $('#preloader').hide();
                    $('#calculationForm')[0].reset();
                    $("#AddKycCustomer").prop('disabled', false);
                    // console.log(response.message);
                    if (response.data) {
                        $("#makeModalClose").trigger("click");
                        $('#CustomerList').append($('<option>', {
                            value: response.data.customer_id,
                            text: response.data.INSUREDNAME_ENG + ' : ' + response.data.MOBILENO,
                            selected: true,
                        }));
                        $('#printCustomerDetails').empty().append('<ul id="custmrList"><li>Customer Name: ' + response.data.INSUREDNAME_ENG + '</li><li>Address: ' + response.data.ADDRESS + '</li><li>Citizenship No.: ' + response.data.CITIZENSHIPNO + '</li><li>Date Of Birth: ' + response.data.DATEOFBIRTH + '</li><li>Email: ' + response.data.EMAIL + '</li><li>Fathers Name: ' + response.data.FATHERNAME + '</li><li>Grandfather Name: ' + response.data.GRANDFATHERNAME + '</li><li>Grandmother Name: ' + response.data.GRANDMOTHERNAME + '</li><li>Mobile Number: ' + response.data.MOBILENO + '</li><li>Mothers Name: ' + response.data.MOTHERNAME + '</li><li>Temporary Address: ' + response.data.TEMPORARYADDRESS + '</li></ul>');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Congratulations!',
                            html: response.message ?? "Customer Added Successfully",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                        // swal("Congratulations!", response.message ?? "Customer Added Successfully", "success");
                    }
                    // console.log(response);
                },
                error: function (response) {
                    $('#preloader').hide();
                    $("#AddKycCustomer").prop('disabled', false);
                    var err = '';
                    if (response.responseJSON && response.responseJSON.errors) {
                        var msg = response.responseJSON;
                        for (let value of Object.values(msg.errors)) {
                            err += '-' + value + '<br>';
                        }
                    } else {
                        var msg = response.responseJSON;
                        for (let value of Object.values(msg.message)) {
                            err += '-' + value + '<br>';
                        }
                    }
                    // console.log(err);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: typeof msg != 'object' && msg !== null ? msg.message : 'Error',
                        html: err ?? 'Something went wrong',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                    });
                }
            });
        });
        window.onload = function () {
            $('.nepali-datepicker').nepaliDatePicker({
                container: '#dateDisplay',
                ndpYear: true,
                ndpMonth: true,
                ndpEnglishInput: 'english-date'
            });
            $('.issued-datepicker').nepaliDatePicker({
                container: '#issuedDateDisplay',
                ndpYear: true,
                ndpMonth: true,
                ndpEnglishInput: 'issued-date'
            });
        };
        $(".nepali-datepicker").on("input", function (e) {
            var nepDate = $(this).val();
            var Dt = NepaliFunctions.ConvertToDateObject(nepDate, "YYYY-MM-DD");
            var EngDate = NepaliFunctions.BS2AD(Dt);
            $('#english-date').val(NepaliFunctions.ConvertDateFormat(EngDate));
            // console.log(EngDate);
        });
        $(".issued-datepicker").on("input", function (e) {
            var nepDate = $(this).val();
            var Dt = NepaliFunctions.ConvertToDateObject(nepDate, "YYYY-MM-DD");
            var EngDate = NepaliFunctions.BS2AD(Dt);
            $('#issued-date').val(NepaliFunctions.ConvertDateFormat(EngDate));
            // console.log(EngDate);
        });
    </script>
@endsection
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="result-show container">
            <h3>Select Customer - {{Session::get('calculationFor') ? Session::get('calculationFor') : 'motor'}}
                Premium</h3>
            <br>
            @include('layouts.backend.alert')
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-5">
                    <div style="text-align:center;border: 1px solid #000000;padding: 20px 0">
                        <h3 class="text-bold">Select Customer</span></h3>
                        <hr>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#AddCustomer">
                            Add New Customer
                        </button>
                        <p class="mt-2">OR</p>
                        <hr>

                        @if(isset($makePolicy))
                            <form action="{{route('nonLife.calculator.bike.first.party.payment')}}"
                                  id="selectCustomerForm" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="" for="userSelect">Select <a href="{{route('admin.leads.customers')}}"
                                                                               target="_blank" data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title="Customer List">Customer</a></label>
                                    <div class="col-sm-12 mx-auto">
                                        <select class="form-control search-select" onchange="getDetails()"
                                                name="customer_id" id="CustomerList"
                                                required>
                                            <option hidden="" disabled="disabled" selected="selected" value="">Click
                                                Here To Select
                                                Customer
                                            </option>
                                            @foreach($customers as $user)
                                                <option data-details="{{json_encode($user)}}"
                                                        value="{{$user->customer_id}}" @if(isset($formData['customer_id'])){{($formData['customer_id'] == $user->customer_id) ? "selected" : ''}}@endif >{{$user->INSUREDNAME_ENG .' : '.$user->MOBILENO}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary selectCstmer" type="submit">Proceed To Payment</button>
                            </form>
                        @endif
                    </div>
                    <a href="{{route('nonLife.calculator.bike',['classId'=>21])}}"
                       class="mt-2 btn btn-primary fa fa-arrow-left"> Back</a>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-5">
                    <div style="text-align:left;border: 1px solid #000000;padding: 20px 5px;margin-bottom:10px">
                        <h3 class="text-bold">Selected Customer Details</span></h3>
                        <hr>
                        <div id="printCustomerDetails"><p>N/A</p></div>
                    </div>
                    <div style="text-align:left;border: 1px solid #000000;padding: 20px 5px">
                        <h3 class="text-bold">Policy Details</span></h3>
                        <hr>
                        <a class="btn btn-primary btn-sm"
                           {{--target="_blank"--}} href="{{route('nonLife.calculator.motor.make.debit.note',['motorId'=> Session::get('motorCalcId') ?? ''])}}">Download
                            Debit Note</a>
                        <hr>
                        <ul>
                            @foreach($formData as $key => $dt)
                                @if($dt)
                                    <li>{{$key." : ".$dt}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="AddCustomer" tabindex="-1" role="dialog" aria-labelledby="AddCustomerLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-xl select-cust-modal" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddCustomerLabel">Add New Customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="calc-from" id="calculationForm" action="{{route('user.kyc.entry')}}"
                                      method="POST">
                                    @csrf
                                    <input type="hidden" name="is_ajax" value="1">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="CATEGORYID">Category</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Category</div>
                                                </div>
                                                <select class="form-control" id="categoryListId" name="CATEGORYID"
                                                        required>
                                                    <option selected disabled>Select the Category</option>
                                                    @foreach($kycCategories as $cat)
                                                        <option
                                                            value="{{$cat->ID}}">{{$cat->GROUPNAME ?? $cat->GroupName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="inlineFormInputGroupUsername2">Insured
                                                Type</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Insured Type</div>
                                                </div>
                                                <select class="form-control" id="INSUREDTYPEID" name="INSUREDTYPE"
                                                        required>
                                                    <option selected disabled>Select the Insured Type</option>
                                                    @foreach($insuredTypes as $insType)
                                                        <option
                                                            value="{{$insType->INSUREDTYPEID}}">{{$insType->INSUREDTYPE}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="inlineFormInputName2">KYC Calssification</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">KYC Calssification</div>
                                                </div>
                                                <select class="form-control" id="kycclassificationID"
                                                        name="kycclassification" required>
                                                    <option selected disabled>Select Kyc Classification</option>
                                                    @foreach($kycClassifications as $kycCls)
                                                        <option
                                                            value="{{$kycCls->ID}}">{{$kycCls->CLASSIFICATIONNAME}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="riskcat">KYC Risk Category</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">KYC Risk Category</div>
                                                </div>
                                                <select class="form-control" id="KYCRiskCategory" name="KYCRiskCategory"
                                                        required>
                                                    <option selected disabled>Select Risk Category</option>
                                                    @foreach($riskCategories as $rskcat)
                                                        <option
                                                            value="{{$rskcat->ID}}">{{$rskcat->DESCRIPTION ?? $rskcat->Description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="CC">Full Name </label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Full Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="TITLE"
                                                       placeholder="Enter Name in Full Name"
                                                       name="INSUREDNAME_ENG"
                                                       value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="CC">Full Name (Nepali)</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Full Name (Nepali)</div>
                                                </div>
                                                <input type="text" class="form-control" id="INSUREDNAME_NEP"
                                                       placeholder="Enter Name in Nepali"
                                                       name="INSUREDNAME_NEP"
                                                       value="" required>
                                            </div>
                                            <small class="form-text text-muted"><a
                                                    href="https://www.ashesh.com.np/nepali-unicode.php" target="_blank">Unicode</a></small>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="sr-only" for="Province">Province</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Province</div>
                                                </div>
                                                <select class="form-control" id="provinceId" name="ZONEID" required>
                                                    <option selected disabled>Select Province</option>
                                                    @foreach($provinces as $province)
                                                        <option
                                                            value="{{$province->PROVINCECODE}}">{{$province->EPROVINCE}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="sr-only" for="Province">District</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">District</div>
                                                </div>
                                                <select class="form-control" id="districtId" name="DISTRICTID" required>
                                                    <option selected disabled>Select District</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="sr-only" for="mnu">MNU</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">MNU</div>
                                                </div>
                                                <select class="form-control" id="MNUId" name="MUNICIPALITYCODE"
                                                        required>
                                                    <option selected disabled>Select MNU</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="sr-only" for="vdc">VDC</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">VDC</div>
                                                </div>
                                                <select class="form-control" id="VDCId" name="VDCCODE" required>
                                                    <option selected disabled>Select VDC</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="address">Address</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Address</div>
                                                </div>
                                                <input type="text" class="form-control" id="ADDRESS"
                                                       placeholder="Please enter address."
                                                       name="ADDRESS"
                                                       value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="inlineFormInputName2">Address (Nepali)</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Address (Nepali)</div>
                                                </div>
                                                <input type="text" class="form-control" id="ADDRESSNEPALI"
                                                       placeholder="Please enter address in nepali."
                                                       name="ADDRESSNEPALI"
                                                       value="">
                                            </div>
                                            <small class="form-text text-muted"><a
                                                    href="https://www.ashesh.com.np/nepali-unicode.php" target="_blank">Unicode</a></small>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="wardno">Ward No.</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Ward No.</div>
                                                </div>
                                                <input type="number" class="form-control" id="WARDNO"
                                                       placeholder="Please enter Ward no." name="WARDNO" min="0"
                                                       value="" required">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="sr-only" for="houseno">House No.</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">House No.</div>
                                                </div>
                                                <input type="number" class="form-control" id="houseno"
                                                       placeholder="Please enter house No." name="HOUSENO" min="0"
                                                       value="">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="sr-only" for="plotno">Plot No.</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Plot No.</div>
                                                </div>
                                                <input type="number" class="form-control" id="plotno"
                                                       placeholder="Please enter plot no." min="0"
                                                       value="" name="PLOTNO">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="address">Temp. Address </label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Temp. Address</div>
                                                </div>
                                                <input type="text" class="form-control"
                                                       placeholder="Please enter temporary address."
                                                       value=""
                                                       name="TEMPORARYADDRESS">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="inlineFormInputName2">Temp. Address
                                                (Nepali)</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Temp. Address (Nepali)</div>
                                                </div>
                                                <input type="text" class="form-control"
                                                       placeholder="Please enter temporary address in nepali."
                                                       value=""
                                                       name="NTEMPORARYADDRESS">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="HomeTelNo">Home Tel. No.</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Home Tel. No.</div>
                                                </div>
                                                <input type="tel" class="form-control" id="telno"
                                                       placeholder="Please enter Telephone Number." name="HOMETELNO"
                                                       value="">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="mbno">Mobile No.</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Mobile No.</div>
                                                </div>
                                                <input type="tel" class="form-control" id="mbno"
                                                       placeholder="Please enter Mobile Number." name="MOBILENO"
                                                       value="">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="plotno">Email Address</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Email Address</div>
                                                </div>
                                                <input type="text" class="form-control" id="email"
                                                       placeholder="Please enter email address."
                                                       value="" name="EMAIL">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="occupation">Occupation</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Occupation</div>
                                                </div>
                                                <select class="form-control" id="occupation" name="OCCUPATION" required>
                                                    <option selected disabled>Select Occupation</option>

                                                    @foreach($kycOccupations as $occ)
                                                        <option
                                                            value="{{$occ->BUSSOCCPCODE}}">{{$occ->DESCRIPTION}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="INCOMESOURCE">Income Source</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Income Source</div>
                                                </div>
                                                <select class="form-control" id="INCOMESOURCE" name="INCOMESOURCE"
                                                        required>
                                                    <option selected disabled>Select Income Source</option>
                                                    @foreach($kycincomesources as $incSrc)
                                                        <option
                                                            value="{{$incSrc->ID}}">{{$incSrc->EDESC}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="incomesrc">Pan Number</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Pan Number</div>
                                                </div>
                                                <input type="number" class="form-control" id="panno"
                                                       placeholder="Please enter Pan Number." min="0"
                                                       value="" name="PANNO">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12" id="issuedDateDisplay"></div>

                                        <div class="form-group col-md-12" id="dateDisplay">
                                            <p class="font-weight-bold">In case of insured type : individual</p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="sr-only" for="gender">Gender</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Gender</div>
                                                </div>
                                                <select class="form-control" id="gender" name="GENDER" required>
                                                    <option selected disabled>Select Gender</option>
                                                    <option
                                                        value="Male">
                                                        Male
                                                    </option>
                                                    <option
                                                        value="Female">
                                                        Female
                                                    </option>
                                                    <option
                                                        value="Others">
                                                        Others
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="sr-only" for="MARITALSTATUS">Marital Status</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Marital Status</div>
                                                </div>
                                                <select class="form-control" id="MARITALSTATUS" name="MARITALSTATUS"
                                                        required>
                                                    <option selected disabled>Select Marital Status</option>
                                                    <option
                                                        value="0">
                                                        Unmarried
                                                    </option>
                                                    <option
                                                        value="1">
                                                        Married
                                                    </option>
                                                    <option
                                                        value="2">
                                                        Divorced
                                                    </option>
                                                    <option value="4">
                                                        Widow
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="sr-only" for="gender">Date Of Birth</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Date Of Birth</div>
                                                </div>
                                                <input type="text" class="form-control nepali-datepicker"
                                                       name="NEPALIDATEOFBIRTH" placeholder="Select Nepali Date">
                                                <span style="margin-left: -25px;padding: 5px;z-index:999;"
                                                      class="fa fa-calendar mt-2"></span>
                                                <input class="form-control" type="text" id="english-date"
                                                       name="DATEOFBIRTH" placeholder="Shows English Date" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="sr-only" for="CITIZENSHIPNO">Citizenship no.</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Citizenship no.</div>
                                                </div>
                                                <input type="text" class="form-control" id="ctznno"
                                                       placeholder="Please enter citizenship no."
                                                       value=""
                                                       name="CITIZENSHIPNO">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="sr-only" for="issdis">Issued District</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Issued District</div>
                                                </div>
                                                <select class="form-control" id="ISSUE_DISTRICT_ID_LIST"
                                                        name="ISSUE_DISTRICT_ID"
                                                        required>
                                                    <option selected disabled>Select Issued District</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="sr-only" for="issdate">Issued Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Issued Date</div>
                                                </div>
                                                <input type="text" class="form-control issued-datepicker"
                                                       name="NEPALIISSUEDATE" placeholder="Select Nepali Date">
                                                <span style="margin-left: -25px;padding: 5px;z-index:999;"
                                                      class="fa fa-calendar mt-2"></span>
                                                <input class="form-control" type="text" id="issued-date"
                                                       name="ISSUEDATE" placeholder="Shows English Date" readonly/>
                                                {{-- <input class="form-control datepicker" data-date-format="yyyy-mm-dd"
                                                         name="ISSUEDATE"
                                                         data-provide="datepicker"
                                                         value="">
                                                <span style="margin-left: -20px; z-index:999;"
                                                      class="fa fa-calendar mt-2"></span> --}}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="fathername">Father Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Father Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="FATHERNAME"
                                                       placeholder="Please enter fathers name."
                                                       value="" name="FATHERNAME">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="mothername">Mother Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Mother Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="MOTHERNAME"
                                                       placeholder="Please enter mothers name."
                                                       value="" name="MOTHERNAME">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="grandfather">Grand Father Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Grand Father Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="GRANDFATHERNAME"
                                                       placeholder="Please enter Grand fathers name."
                                                       value=""
                                                       name="GRANDFATHERNAME">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="grandmother">Grand Mother Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Grand Mother Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="GRANDMOTHERNAME"
                                                       placeholder="Please enter Grand mothers name."
                                                       value=""
                                                       name="GRANDMOTHERNAME">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="husband">Husband Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Husband Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="HUSBANDNAME"
                                                       placeholder="Please enter your husband name."
                                                       value="" name="HUSBANDNAME">
                                                <input type="hidden" class="form-control" name="NFATHERNAME"
                                                       value="usersfather">
                                                <input type="hidden" class="form-control" name="NGRANDFATHERNAME"
                                                       value="usergrandfather">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="sr-only" for="wife">Wife Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend date">
                                                    <div class="input-group-text">Wife Name</div>
                                                </div>
                                                <input type="text" class="form-control" id="WIFENAME"
                                                       placeholder="Please enter your wife name."
                                                       value="" name="WIFENAME">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 border-attachment">
                                            <span class="make-border-text">Attachments</span>
                                            <div class="row">
                                                <div class="form-group col-md-6 images-part">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="photos"
                                                               id="photos">
                                                        <label class="custom-file-label" for="photos">Browse
                                                            Photo</label>
                                                        <span class="custom-file-image" for="images_view"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 images-part">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="citfrnt"
                                                               id="citfront">
                                                        <label class="custom-file-label" for="citfrnt">Browse
                                                            Citizenship
                                                            (Front)</label>
                                                        <span class="custom-file-image" for="images_view"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 images-part">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="citback"
                                                               id="citback">
                                                        <label class="custom-file-label" for="ctbck">Browse Citizenship
                                                            (back)</label>
                                                        <span class="custom-file-image" for="images_view"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 images-part">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="cpmreg"
                                                               id="cpmreg">
                                                        <label class="custom-file-label" for="cpmreg">Browse Company
                                                            Registration & PAN
                                                            Certificate</label>
                                                        <span class="custom-file-image" for="images_view"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="BRANCHCODE" value="01">
                                        <input type="hidden" name="BRANCHID" value="1">
                                        <input type="hidden" name="KYCNO">
                                        <input type="hidden" name="ACCOUNTNAMECODE">
                                        <input type="hidden" name="AREAID" value="0">
                                        <input type="hidden" name="TOLEID" value="0">
                                        <input type="hidden" name="customer_id" value="">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="makeModalClose" class="btn btn-secondary"
                                        data-dismiss="modal">Close
                                </button>
                                <button type="button" id="AddKycCustomer" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>

        <!-- /.col (right) -->
    </div>
    <!-- /.row -->
@stop
