@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Life Calculator</p>
@endsection

@php
    $oldCompany = old('company');
    $oldProduct = old('product');
    $oldTerm = old('term');
    $oldAge = old('age');
@endphp

@section('footer_js')
    <script>

        $(document).ready(function () {
            $('.search-select').select2();

            let oldCompany = parseInt({{$oldCompany}})

            if (oldCompany) {
                findProducts()
            }
        });

        let oldTerm = parseInt({{ $oldTerm }})
        let oldAge = parseInt({{ $oldAge }})
        let oldProduct = parseInt({{ $oldProduct }})

        function findProducts() {
            let data = $('option:selected', '#companies').attr('data-products');
            data = JSON.parse(data);

            let html = '';
            html += '<option selected disabled>Select a Product</>';
            for (let i = 0; i < data.length; i++) {

                if (oldProduct == data[i].id) {
                    html += '<option ' +
                        'value="' + data[i].id +
                        '" data-category="' + data[i].category +
                        '" data-terms="' + JSON.stringify(data[i].terms) +
                        '" data-ages="' + JSON.stringify(data[i].ages) +
                        '" selected' +
                        '>'
                        + data[i].name + '</option>'
                } else {
                    html += '<option ' +
                        'value="' + data[i].id +
                        '" data-category="' + data[i].category +
                        '" data-terms="' + JSON.stringify(data[i].terms) +
                        '" data-ages="' + JSON.stringify(data[i].ages) +
                        '" data-proposer-ages="' + JSON.stringify(data[i].proposer_ages) +
                        '"' +
                        '>'
                        + data[i].name + '</option>'
                }
            }
            $('#products').html(html);
            if (oldProduct) {
                findTermsAndAges()
            }
        }

        function showInput(input) {
            $(`#${input}_container`).removeClass('d-none');
            $(`#${input}`).removeAttr('disabled');
        }

        function hideInput(input) {
            $(`#${input}_container`).addClass('d-none');
            $(`#${input}`).attr('disabled', 'disabled');
        }

        function findTermsAndAges() {
            let plan = $('option:selected', '#products').attr('data-category');

            $('#product-category').text('Product Category: ' + plan.replaceAll('-', ' '));

            switch (plan) {
                case 'couple':
                    showInput('husband_age')
                    showInput('wife_age')
                    hideInput('child_ages')
                    hideInput('proposer_age')
                    hideInput('ages')

                    break;
                case 'children':
                    hideInput('husband_age')
                    hideInput('wife_age')
                    showInput('child_ages')
                    showInput('proposer_age')
                    hideInput('ages')

                    break;
                case 'education':
                    hideInput('husband_age')
                    hideInput('wife_age')
                    showInput('child_ages')
                    showInput('proposer_age')
                    hideInput('ages')

                    break;
                default:
                    hideInput('husband_age')
                    hideInput('wife_age')
                    hideInput('child_ages')
                    hideInput('proposer_age')
                    showInput('ages')

                    break;
            }

            let data = $('option:selected', '#products').attr('data-terms');
            data = JSON.parse(data);

            data = data.sort(function (a, b) {
                return a - b;
            });

            let html = '';
            html += '<option selected disabled>Select a term</>';
            for (let i = 0; i < data.length; i++) {
                if (oldTerm == data[i]) {
                    html += '<option value="' + data[i] + '" selected>' + data[i] + '</option>'
                } else {
                    html += '<option value="' + data[i] + '">' + data[i] + '</option>'
                }
            }
            $('#terms').html(html);

            if (plan !== 'couple') {
                let ageData = $('option:selected', '#products').attr('data-ages');
                ageData = JSON.parse(ageData);

                ageData = ageData.sort(function (a, b) {
                    return a - b;
                });

                let html2 = '';
                html2 += '<option selected disabled>Select an age</>';
                for (let i = 0; i < ageData.length; i++) {
                    if (oldAge == ageData[i]) {
                        html2 += '<option value="' + ageData[i] + '" selected>' + ageData[i] + '</option>'
                    } else {
                        html2 += '<option value="' + ageData[i] + '">' + ageData[i] + '</option>'
                    }
                }
                if (plan === 'children' || plan === 'education') {
                    $('#child_ages').html(html2);
                } else {
                    $('#ages').html(html2);
                }
            }
            if (plan === 'children' || plan === 'education') {
                let ageData = $('option:selected', '#products').attr('data-proposer-ages');
                ageData = JSON.parse(ageData);

                console.log(ageData)

                ageData = ageData.sort(function (a, b) {
                    return a - b;
                });

                let html2 = '';
                html2 += '<option selected disabled>Select proposers age</>';
                for (let i = 0; i < ageData.length; i++) {
                    if (oldAge == ageData[i]) {
                        html2 += '<option value="' + ageData[i] + '" selected>' + ageData[i] + '</option>'
                    } else {
                        html2 += '<option value="' + ageData[i] + '">' + ageData[i] + '</option>'
                    }
                }

                $('#proposer_age').html(html2);
            }


            let productId = $('#products').find(":selected").val();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.get.feature.list') }}",
                dataType: 'json',
                data: {
                    'id': productId,
                },
                success: function (response) {
                    if (response.data.length > 0) {
                        let html = '';
                        for (let j = 0; j < response.data.length; j++) {

                            if (response.data[j].is_compulsory == 1) {
                                html += ' <div class="form-check">' +
                                    '<input type="hidden" name="features[]" class="form-check-input" value="' + response.data[j].code + '">' +
                                    '<input type="checkbox" name="features[]" class="form-check-input" value="' + response.data[j].code + '" checked disabled>' +
                                    '<label class="form-check-label text-capitalize">' + response.data[j].name + '</label>' +
                                    '</div>'
                            } else {
                                html += ' <div class="form-check">' +
                                    '<input type="checkbox" name="features[]" class="form-check-input" value="' + response.data[j].code + '">' +
                                    '<label class="form-check-label text-capitalize">' + response.data[j].name + '</label>' +
                                    '</div>'
                            }


                        }
                        $('#featuresTab').html(html);
                        $('#featureRow').removeClass('d-none')

                    } else {
                        $('#featureRow').addClass('d-none')
                    }
                },
                error: function (error) {
                    $('#featureRow').addClass('d-none')
                }
            });

        }

        // validate data
        $('.validate-check').change(function (e) {
            validateData(false)
        })

        $('#submit-btn').click(function (e) {
            validateData(true)
        })

        function validateData(shouldSubmit) {
            const form = $('#life-calculator-form');
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/admin/life/validate",
                data: form.serialize(),
                success: function (response) {
                    resetErrors();
                    if (shouldSubmit) {
                        form.submit();
                    }
                },
                error: function (error) {
                    resetErrors();
                    const type = error.responseJSON.type;
                    const message = error.responseJSON.message;

                    switch (type) {
                        case 'company':
                            $('#companyError').text(message);
                            break;
                        case 'product':
                            $('#productError').text(message);
                            break;
                        case 'age':
                            $('#ageError').text(message);
                            break;
                        case 'husband_age':
                            $('#husbandAgeError').text(message);
                            break;
                        case 'wife_age':
                            $('#wifeAgeError').text(message);
                            break;
                        case 'couple_age':
                            $('#coupleAgeError').text(message);
                            break;
                        case 'child_age':
                            $('#childAgeError').text(message);
                            break;
                        case 'term':
                            $('#termError').text(message);
                            break;
                        case 'sum_assured':
                            $('#sumAssuredError').text(message);
                            break;
                        case 'table_rate':
                            $('#tableRateError').text(message);
                            break;
                        case 'mop':
                            $('#mopError').text(message);
                            break;
                        case 'maturity_age':
                            $('#maturityAgeError').text(message);
                            break;
                    }
                },
            })
        }

        function resetErrors() {
            $('#companyError').text('');
            $('#productError').text('');
            $('#ageError').text('');
            $('#husbandAgeError').text('');
            $('#wifeAgeError').text('');
            $('#coupleAgeError').text('');
            $('#childAgeError').text('');
            $('#termError').text('');
            $('#sumAssuredError').text('');
            $('#maturityAgeError').text('');
            $('#tableRateError').text('');
            $('#mopError').text('');
        }
        // end of validate data

    </script>
@endsection

@section('header_css')
    <style>
        .select2-selection {
            display: block;
            width: 100%;
            height: calc(1.6em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            height: auto !important;
        }
    </style>
@endsection

@section('dynamicdata')
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Life Calculation</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')

            <form method="POST" action="{{ route('calculator.life.calculate') }}" id="life-calculator-form">
                @csrf
                <div class="form-row">

                    @if(session('errorMessage'))
                        <div class="form-group col-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('errorMessage') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                @endif

                <!-- Companies -->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Company</span>
                            </div>
                            <select class="form-control search-select  validate-check" id="companies" name="company"
                                    onchange="findProducts()">
                                <option selected disabled>Select a company</option>
                                @foreach($companies as $comp)
                                    <option value="{{ $comp->id }}" data-products="{{ $comp->products }}"
                                            @if(old('company')==$comp->id) selected @endif
                                    >
                                        {{ $comp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback d-block" id="companyError"></div>
                    </div>

                    <!-- Products-->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Products</span>
                            </div>
                            <select class="form-control search-select  validate-check" id="products" name="product"
                                    onchange="findTermsAndAges()">
                                <option selected disabled>Select a product</option>
                            </select>
                        </div>
                        <small class="form-text text-muted text-capitalize" id="product-category"></small>
                        <div class="invalid-feedback d-block" id="productError"></div>
                    </div>

                    <!-- Terms -->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Term</span>
                            </div>
                            <select name="term" id="terms"
                                    class="form-control validate-check search-select {{ session()->has('termError') ? 'is-invalid' : '' }}">
                                <option selected disabled value="">Select a term</option>
                            </select>
                        </div>
                        <div class="invalid-feedback d-block" id="termError"></div>
                    </div>

                    <!-- Ages -->
                    <div class="form-group col-12 col-md-6" id="ages_container">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Age</span>
                            </div>
                            <select
                                name="age"
                                id="ages"
                                class="form-control validate-check search-select {{ session()->has('ageError') ? 'is-invalid' : '' }}"
                            >
                                <option selected disabled value="">Select an age</option>
                            </select>
                        </div>
                        <div class="invalid-feedback d-block" id="ageError"></div>
                    </div>

                    <!-- Husband Age -->
                    <div class="form-group col-12 col-md-6 d-none " id="husband_age_container">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Husband Age</span>
                            </div>
                            <input type="text" class="form-control validate-check" id="husband_age" name="husband_age"
                                   placeholder="Enter Husband Age (in year)"
                                   {{ old('husband_age') }} disabled="disabled">
                        </div>
                        <div class="invalid-feedback d-block" id="coupleAgeError"></div>
                        <div class="invalid-feedback d-block" id="husbandAgeError"></div>
                    </div>

                    <!-- Wife Age -->
                    <div class="form-group col-12 col-md-6 d-none " id="wife_age_container">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Wife Age</span>
                            </div>
                            <input type="text" class="form-control validate-check" id="wife_age" name="wife_age"
                                   placeholder="Enter Wife Age (in year)" {{ old('wife_age') }} disabled="disabled">
                        </div>
                        <div class="invalid-feedback d-block" id="wifeAgeError"></div>
                    </div>

                    <!-- Child's Age -->
                    <div class="form-group col-12 col-md-6 d-none" id="child_ages_container">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Child Age</span>
                            </div>
                            <select
                                name="child_age"
                                id="child_ages"
                                class="form-control validate-check search-select {{ session()->has('ageError') ? 'is-invalid' : '' }}"
                                disabled="disabled"
                            >
                                <option selected disabled value="">Select an age</option>
                            </select>
                        </div>
                        <div class="invalid-feedback d-block" id="childAgeError"></div>
                    </div>

                    <!-- Proposer Age -->
                    <div class="form-group col-12 col-md-6 d-none" id="proposer_age_container">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Proposer's Age</span>
                            </div>
                            <select
                                name="proposer_age"
                                id="proposer_age"
                                class="form-control validate-check search-select"
                                disabled="disabled"
                            >
                                <option selected disabled value="">Select Proposer's Age</option>
                            </select>
                        </div>
                    </div>

                    <div class="invalid-feedback d-block mb-3 mx-2 mt-n2" id="maturityAgeError"></div>

                    <div class="invalid-feedback d-block mb-3 mx-2 mt-n2" id="tableRateError"></div>

                    <!-- Sum Assured -->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Sum Assured</span>
                            </div>
                            <input type="number" class="form-control validate-check" id="sum_assured" name="sum_assured"
                                   placeholder="Enter Sum Assured" value="{{ old('sum_assured') }}">
                        </div>
                        <div class="invalid-feedback d-block" id="sumAssuredError"></div>
                    </div>

                    <!-- MOP Charges -->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Mode of Payment</span>
                            </div>
                            <select name="loading_charge" id="loading_charge"
                                    class="form-control search-select validate-check">
                                <option selected disabled>Select a MoP</option>
                                <option value="yearly" @if(old('loading_charge')=='yearly' ) selected @endif>
                                    Yearly
                                </option>
                                <option value="half_yearly" @if(old('loading_charge')=='half_yearly' ) selected @endif>
                                    Half Yearly
                                </option>
                                <option value="quarterly" @if(old('loading_charge')=='quarterly' ) selected @endif>
                                    Quarterly
                                </option>
                                <option value="monthly" @if(old('loading_charge')=='monthly' ) selected @endif>
                                    Monthly
                                </option>
                            </select>
                        </div>
                        <div class="invalid-feedback d-block" id="mopError"></div>
                    </div>
                </div>

                <!-- Features -->
                <div class="form-group col-12 col-md-6 d-none" id="featureRow">
                    <label>Features</label>
                    <div id="featuresTab">

                    </div>
                </div>

                <button type="button" class="btn btn-primary" id="submit-btn">Calculate</button>
            </form>
        </div>
    </div>
@endsection
