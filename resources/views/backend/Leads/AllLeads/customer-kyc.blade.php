@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Customer KYC Form</p>
@endsection
@section('footer_js')
    <script type="text/javascript">
        $(document).ready(function () {
        });

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
                    console.log(response);
                    $('#plotno').val(response.CompulsoryExcess);
                },
                error: function (e) {
                    console.log('something went wrong');
                }
            });
        });
    </script>
    @if (customerKyc($customer->id))
        <script>
            $('form *').prop('disabled', true);
            $('form :button').css('display', 'none');
        </script>
    @endif
@endsection
<style>
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
    .custom-file {
        height: auto !important;
    }
</style>
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Pleasee Fill Up The Kyc Form</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')
            @if (customerKyc($customer->id) && customerKyc($customer->id)->is_verified == 1)
                <span class="badge badge-pill badge-success p-2">Verified</span>
            @else
                <span class="badge badge-pill badge-danger p-2">Not Verified</span>
            @endif
            <div class="tab-content">
                <p class="text-center font-weight-bold">Your KYC No. : {{customerKyc($customer->id)->KYCNO ?? ''}}</p>
                <p class="text-right font-weight-bold"><a href="https://www.ashesh.com.np/nepali-unicode.php" target="_blank">Unicode</a></p>
                <form class="calc-from" id="calculationForm" action="{{route('user.kyc.entry')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="sr-only" for="CATEGORYID">Category</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Category</div>
                                </div>
                                <select class="form-control" id="categoryListId" name="CATEGORYID" required>
                                    <option selected disabled>Select the Category</option>
                                    @foreach($kycCategories as $cat)
                                        <option
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['CATEGORYID'] == $cat->ID ?'selected' :'' }}
                                            value="{{$cat->ID}}">{{$cat->GROUPNAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="inlineFormInputGroupUsername2">Insured Type</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Insured Type</div>
                                </div>
                                <select class="form-control" id="INSUREDTYPEID" name="INSUREDTYPE" required>
                                    <option selected disabled>Select the Insured Type</option>
                                    @foreach($insuredTypes as $insType)
                                        <option
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['INSUREDTYPE'] == $insType->INSUREDTYPEID ?'selected' :'' }}
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
                                <select class="form-control" id="kycclassificationID" name="kycclassification" required>
                                    <option selected disabled>Select Kyc Classification</option>
                                    @foreach($kycClassifications as $kycCls)
                                        <option
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['kycclassification'] == $kycCls->ID ?'selected' :'' }}
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
                                <select class="form-control" id="KYCRiskCategory" name="KYCRiskCategory" required>
                                    <option selected disabled>Select Risk Category</option>
                                    @foreach($riskCategories as $rskcat)
                                        <option
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['KYCRiskCategory'] == $rskcat->ID ?'selected' :'' }}
                                            value="{{$rskcat->ID}}">{{$rskcat->DESCRIPTION}}</option>
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
                                <input type="text" class="form-control" id="TITLE" placeholder="Enter Name in Full Name"
                                       name="INSUREDNAME_ENG"
                                       value="{{ customerKyc($customer->id)['INSUREDNAME_ENG']??'' }}">
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
                                       value="{{ customerKyc($customer->id)['INSUREDNAME_NEP']??'' }}">
                            </div>
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
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['ZONEID'] == $province->PROVINCECODE ?'selected' :'' }}
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
                                <select class="form-control" id="MNUId" name="MUNICIPALITYCODE" required>
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
                                <input type="text" class="form-control" id="ADDRESS" placeholder="Please enter address."
                                       name="ADDRESS"
                                       value="{{customerKyc($customer->id)['ADDRESS']??'' }}">
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
                                       value="{{customerKyc($customer->id)['ADDRESSNEPALI']??'' }}">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="wardno">Ward No.</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Ward No.</div>
                                </div>
                                <input type="number" class="form-control" id="WARDNO" min="1"
                                       placeholder="Please enter Ward no." name="WARDNO"
                                       value="{{ customerKyc($customer->id)['WARDNO']??'' }}" required">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="sr-only" for="houseno">House No.</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">House No.</div>
                                </div>
                                <input type="number" class="form-control" id="houseno" min="1"
                                       placeholder="Please enter house No." name="HOUSENO"
                                       value="{{ customerKyc($customer->id)['HOUSENO']??'' }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="sr-only" for="plotno">Plot No.</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Plot No.</div>
                                </div>
                                <input type="number" class="form-control" id="plotno" min="1"
                                       placeholder="Please enter plot no."
                                       value="{{ customerKyc($customer->id)['PLOTNO']??'' }}" name="PLOTNO">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="address">Temp. Address </label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Temp. Address</div>
                                </div>
                                <input type="text" class="form-control" placeholder="Please enter temporary address."
                                       value="{{ customerKyc($customer->id)['TEMPORARYADDRESS']??'' }}"
                                       name="TEMPORARYADDRESS">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="inlineFormInputName2">Temp. Address (Nepali)</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Temp. Address (Nepali)</div>
                                </div>
                                <input type="text" class="form-control"
                                       placeholder="Please enter temporary address in nepali."
                                       value="{{ customerKyc($customer->id)['NTEMPORARYADDRESS']??'' }}"
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
                                       value="{{ customerKyc($customer->id)['HOMETELNO']??'' }}">
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
                                       value="{{ customerKyc($customer->id)['MOBILENO']??'' }}">
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
                                       value="{{ customerKyc($customer->id)['EMAIL']??'' }}" name="EMAIL">
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
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['OCCUPATION'] == $occ->BUSSOCCPCODE ?'selected' :'' }}
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
                                <select class="form-control" id="INCOMESOURCE" name="INCOMESOURCE" required>
                                    <option selected disabled>Select Income Source</option>
                                    @foreach($kycincomesources as $incSrc)
                                        <option
                                            {{ customerKyc($customer->id) && customerKyc($customer->id)['INCOMESOURCE'] == $incSrc->ID ?'selected' :'' }}
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
                                <input type="number" class="form-control" id="panno" min="1"
                                       placeholder="Please enter Pan Number."
                                       value="{{ customerKyc($customer->id)['PANNO']??'' }}" name="PANNO">
                            </div>
                        </div>
                        <div class="form-group col-md-6"></div>

                        <div class="form-group col-md-12">
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
                                        {{ customerKyc($customer->id) && customerKyc($customer->id)['GENDER'] == 1 ?'selected' :'' }} value="1">
                                        Male
                                    </option>
                                    <option
                                        {{ customerKyc($customer->id) && customerKyc($customer->id)['GENDER'] == 0 ?'selected' :'' }} value="0">
                                        Female
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
                                <select class="form-control" id="MARITALSTATUS" name="MARITALSTATUS" required>
                                    <option selected disabled>Select Marital Status</option>
                                    <option
                                        {{ customerKyc($customer->id) && customerKyc($customer->id)['MARITALSTATUS'] == 0 ?'selected' :'' }} value="0">
                                        Unmarried
                                    </option>
                                    <option
                                        {{ customerKyc($customer->id) && customerKyc($customer->id)['MARITALSTATUS'] == 1 ?'selected' :'' }} value="1">
                                        Married
                                    </option>
                                    <option
                                        {{ customerKyc($customer->id) && customerKyc($customer->id)['MARITALSTATUS'] == 2 ?'selected' :'' }} value="2">
                                        Divorced
                                    </option>
                                    <option
                                        {{ customerKyc($customer->id) && customerKyc($customer->id)['MARITALSTATUS'] == 3 ?'selected' :'' }} value="3">
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
                                <input class="form-control" name="DATEOFBIRTH" data-date-format="yyyy-mm-dd"
                                       data-provide="datepicker"
                                       value="{{ customerKyc($customer->id)['DATEOFBIRTH']??'' }}">
                                <span style="margin-left: -20px; z-index:999;" class="fa fa-calendar mt-2"></span>
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
                                       value="{{ customerKyc($customer->id)['CITIZENSHIPNO']??'' }}"
                                       name="CITIZENSHIPNO">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="sr-only" for="issdis">Issued District</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Issued District</div>
                                </div>
                                <select class="form-control" id="ISSUE_DISTRICT_ID_LIST" name="ISSUE_DISTRICT_ID"
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
                                <input class="form-control datepicker" data-date-format="yyyy-mm-dd" name="ISSUEDATE"
                                       data-provide="datepicker"
                                       value="{{ customerKyc($customer->id)['ISSUEDATE']??'' }}">
                                <span style="margin-left: -20px; z-index:999;" class="fa fa-calendar mt-2"></span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="fathername">Father Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend date">
                                    <div class="input-group-text">Father Name</div>
                                </div>
                                <input type="text" class="form-control" id="FATHERNAME"
                                       placeholder="Please enter fathers name."
                                       value="{{ customerKyc($customer->id)['FATHERNAME']??'' }}" name="FATHERNAME">
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
                                       value="{{ customerKyc($customer->id)['MOTHERNAME']??'' }}" name="MOTHERNAME">
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
                                       value="{{ customerKyc($customer->id)['GRANDFATHERNAME']??'' }}"
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
                                       value="{{ customerKyc($customer->id)['GRANDMOTHERNAME']??'' }}"
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
                                       value="{{ customerKyc($customer->id)['HUSBANDNAME']??'' }}" name="HUSBANDNAME">
                                <input type="hidden" class="form-control" name="NFATHERNAME" value="usersfather">
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
                                       value="{{ customerKyc($customer->id)['WIFENAME']??'' }}" name="WIFENAME">
                            </div>
                        </div>

                        <div class="form-group col-md-12 border-attachment">
                            <span class="make-border-text">Attachments</span>
                            <div class="row">
                                <div class="form-group col-md-6 images-part">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="photos"
                                               id="photos">
                                        <label class="custom-file-label" for="photos">Browse Photo</label>
                                        <span class="custom-file-image" for="images_view"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 images-part">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="citfrnt"
                                               id="citfront">
                                        <label class="custom-file-label" for="citfrnt">Browse Citizenship
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
                        <input type="hidden" name="BRANCHCODE" value="26">
                        <input type="hidden" name="KYCNO">
                        <input type="hidden" name="ACCOUNTNAMECODE">
                        <input type="hidden" name="AREAID" value="0">
                        <input type="hidden" name="TOLEID" value="0">
                        <input type="hidden" name="customer_id" value="{{$customer ? $customer->id : '0'}}">
                        <div class="form-group col-md-12">

                            <button type="submit" class="btn btn-primary mb-2 submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box-body -->

    </div>
@stop
