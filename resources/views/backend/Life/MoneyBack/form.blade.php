@extends('layouts.backend.containerform')

@section('title')
<p class="h4 align-center mb-0">Money Back Calculator</p>
@endsection

@section('footer_js')
<script>
    $(document).ready(function () {
            $('.search-select').select2();
        });

        function findProducts() {
            let data = $('option:selected', '#companies').attr('data-products');
            data = JSON.parse(data);
            let html = '';
            html += '<option selected disabled>Select a Product</>';
            for (let i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id + '" data-terms="' + JSON.stringify(data[i].terms) + '" data-adb-types="' + data[i].adb_types + '">' + data[i].name + '</option>'
            }
            $('#products').html(html);

            let data2 = $('option:selected', '#companies').attr('data-benefits');
            data2 = JSON.parse(data2);
            let html2 = '';
            html2 += '';
            for (let i = 0; i < data2.length; i++) {
                html2 += '<div class="form-check">' +
                    ' <input type="checkbox" class="form-check-input" name="benefits[]" value="' + data2[i]  + '">' +
                    '<label class="form-check-label">' + data2[i] + '</label' +
                    '></div>'
            }
            $('#benefits').html(html2);
        }

        function findTerms() {
            let data = $('option:selected', '#products').attr('data-terms');
            data = JSON.parse(data);
            let html = '';
            html += '<option selected disabled>Select a term</>';
            for (let i = 0; i < data.length; i++) {
                html += '<option value="' + data[i] + '">' + data[i] + '</option>'
            }
            $('#terms').html(html);
        }

        function findAdbTypes() {
            if ($('#adb').find(":selected").text() == 'Yes') {
                let data = $('option:selected', '#products').attr('data-adb-types');

                data = data.split(',');
                let html = '';
                html += '<option selected disabled>Select an adb type</>';
                for (let i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i] + '">' + data[i] + '</option>'
                }

                $('#adb_types').html(html);
            }
        }
</script>
@endsection

@section('header_css')
<style>
    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        height: auto !important;
    }

    .select2-container {
        width: 75% !important;
    }
</style>
@endsection

@section('dynamicdata')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Money Back Calculation</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')

        <form method="POST" action="{{ route('calculator.moneyBack.calculate') }}">
            @csrf

            <div class="form-row">
                <!-- Companies -->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Company</span>
                        </div>
                        <select class="form-control search-select" id="companies" name="company"
                            onchange="findProducts()">
                            <option selected disabled>Select a company</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}" data-products="{{ $company->products }}"
                                data-benefits="{{ $company->benefits }}">
                                {{ $company->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Products-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Products</span>
                        </div>
                        <select class="form-control search-select" id="products" name="product" onchange="findTerms()">
                            <option selected disabled>Select a product</option>
                        </select>
                    </div>
                </div>

                <!-- Age-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Age</span>
                        </div>
                        <input type="text" class="form-control" id="age" name="age" placeholder="Enter Age (in year)">
                    </div>
                </div>

                <!-- Terms-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Terms</span>
                        </div>
                        <select class="form-control search-select" id="terms" name="term">
                            <option selected disabled>Select a term</option>
                        </select>
                    </div>
                </div>

                <!-- Adb-->
                {{--                <div class="form-group col-12 col-md-6">--}}
                {{--                    <div class="input-group">--}}
                {{--                        <div class="input-group-prepend">--}}
                {{--                            <span class="input-group-text">Adb</span>--}}
                {{--                        </div>--}}
                {{--                        <select class="form-control search-select" id="adb" name="adb" onchange="findAdbTypes()">--}}
                {{--                            <option selected disabled>Select an adb</option>--}}
                {{--                            <option value="yes">Yes</option>--}}
                {{--                            <option value="no">No</option>--}}
                {{--                        </select>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <!-- Adb Types-->
                {{--                <div class="form-group col-12 col-md-6">--}}
                {{--                    <div class="input-group">--}}
                {{--                        <div class="input-group-prepend">--}}
                {{--                            <span class="input-group-text">Adb Types</span>--}}
                {{--                        </div>--}}
                {{--                        <select class="form-control search-select" id="adb_types" name="adb_type">--}}
                {{--                            <option selected disabled>Select an adb type</option>--}}
                {{--                        </select>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <!-- Sum Assured-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Sum Assured</span>
                        </div>
                        <input type="text" class="form-control" id="sum_assured" name="sum_assured"
                            placeholder="Enter Sum Assured">
                    </div>
                </div>

                <!-- MoP Charge-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">MoP Charge</span>
                        </div>
                        <select class="form-control search-select" id="loading_charge" name="loading_charge">
                            <option selected disabled>Select a MoP Charge</option>
                            <option value="yearly">Yearly</option>
                            <option value="half_yearly">Half Yearly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                </div>

                <!-- Term Rider-->
                {{--                <div class="form-group col-12 col-md-6">--}}
                {{--                    <div class="input-group">--}}
                {{--                        <div class="input-group-prepend">--}}
                {{--                            <span class="input-group-text">Term Rider</span>--}}
                {{--                        </div>--}}
                {{--                        <select class="form-control search-select" id="term_rider" name="term_rider">--}}
                {{--                            <option selected disabled>Select a Term Rider</option>--}}
                {{--                            <option value="yes">Yes</option>--}}
                {{--                            <option value="no">No</option>--}}
                {{--                        </select>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{-- Benefits --}}
                {{-- <div class="form-group col-126">
                    <label>Select Benefits <small>( Select a company to see available benefits. )</small></label>
                    <div id="benefits">

                    </div>
                </div>
            </div> --}}

                <button type="submit" class="btn btn-primary">Calculate</button>

        </form>

    </div>
</div>

@endsection
