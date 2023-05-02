@extends('layouts.backend.containerform')

@section('title')
<p class="h4 align-center mb-0">Couple Plan Calculator</p>
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
        <h3 class="box-title">Couple Plan Calculation</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')

        <form method="POST" action="{{ route('calculator.couplePlan.calculate') }}">
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
                            <option value="{{ $company->id }}" data-products="{{ $company->products }}">
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

                <!-- Husband Age-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Husband's Age</span>
                        </div>
                        <input type="text" class="form-control" id="husband_age" name="husband_age"
                            placeholder="Enter Husband's Age (in year)">
                    </div>
                </div>

                <!-- Husband Age-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Wife's Age</span>
                        </div>
                        <input type="text" class="form-control" id="wife_age" name="wife_age"
                            placeholder="Enter Wife's Age (in year)">
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
                        </select>
                    </div>
                </div>

                {{-- Benefits --}}
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Select Benefits</span>
                        </div>
                        <div class="form-control">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="benefit[]" value="husband_adb">
                                <label class="form-check-label">Husband's ADB</label>
                            </div>
                        </div>
                        <div class="form-control">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-innput" name="benefit[]" value="wife_adb">
                                <label class="form-check-label">Wife's ADB</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Calculate</button>

        </form>

    </div>
</div>

@endsection
