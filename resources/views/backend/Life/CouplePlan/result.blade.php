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
            {{-- form --}}
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
                            <select class="form-control search-select" id="products" name="product"
                                    onchange="findTerms()">
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
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>

                    <!-- Benefits-->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Select Benefits</span>
                            </div>
                            <div class="form-control">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="benefit[]"
                                           value="husband_adb">
                                    <label class="form-check-label">Husband's ADB</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="benefit[]" value="wife_adb">
                                    <label class="form-check-label">Wife's ADB</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Calculate</button>

            </form>

        </div>
        {{-- Form End  --}}
        {{-- Result start   --}}
        <div class="box-body">
            <div class="mx-auto text-center">
                <label class="mb-2"> Selected Company: {{ $company ? $company['name']:'N/A' }}</label>
                <br>
                <label class="mb-2"> Selected Product: {{ $product ? $product['name']:'N/A' }}</label>
            </div>
            @if($table_rate)
                <table id="tablebody" class="table table-bordered table-hover role-table">
                    <thead>
                    <tr class="gradeX">
                        <th>Husband Age</th>
                        <td class="index">
                            {{ $husband_age }}
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Wife Age</th>
                        <td class="index">
                            {{ $wife_age }}
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Average Age</th>
                        <td class="index">
                            {{ $average_age }}
                        </td>
                    </tr>
                    <tr>
                        <th>Term</th>
                        <td class="name">
                            {{ $term }}
                        </td>
                    </tr>
                    <tr>
                        <th>Sum Assured</th>
                        <td class="name">
                            {{ $sum_assured }}
                        </td>
                    </tr>
                    <tr>
                        <th>Rate</th>
                        <td class="name">
                            {{ $table_rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>Discount on SA</th>
                        <td class="name">
                            {{ $discount_on_sa }}
                        </td>
                    </tr>
                    <tr>
                        <th>New Rate</th>
                        <td class="name">
                            {{ $new_rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>Actual Premium Before Discount</th>
                        <td class="name">
                            {{ $premium_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>Discount/Loading Charge on MOP</th>
                        <td class="name">
                            {{ $mop_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>Actual Premium Amount After MOP</th>
                        <td class="name">
                            {{ $actual_premium }}
                        </td>
                    </tr>
                    <tr>
                        <th>ADB for Husband</th>
                        <td class="name">
                            {{ $husband_adb==0 ? '-':$husband_adb }}
                        </td>
                    </tr>
                    <tr>
                        <th>ADB for Wife</th>
                        <td class="name">
                            {{ $wife_adb==0 ? '-':$wife_adb }}
                        </td>
                    </tr>
                    <tr>
                        <th>Total ADB</th>
                        <td class="name">
                            {{ $total_adb==0 ? '-':$total_adb }}
                        </td>
                    </tr>
                    <tr>
                        <th>ADB Amount</th>
                        <td class="name">
                            {{ $adb_amount==0 ? '-':$adb_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>Premium After Adding Benefits</th>
                        <td class="name">
                            {{ $total_premium_amount }}
                        </td>
                    </tr>
                    @if($half_yearly_premium_amount != 0)
                        <tr>
                            <th>For Half Yearly</th>
                            <td class="name">
                                {{ $half_yearly_premium_amount }}
                            </td>
                        </tr>
                    @endif
                    <tr class="gradeX text-center">
                        <th colspan="2">
                            <h6>Bonus Calculation</h6>
                            @if($bonus->rate == 'N/A')
                                <span class="invalid-feedback d-block">
                            Bonus rate not available. Please insert bonus rate.
                        </span>
                            @endif
                        </th>
                    </tr>
                    <tr class="gradeX">
                        <th>Bonus Rate</th>
                        <td class="name">
                            {{  $bonus->rate }}
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Bonus Per Year</th>
                        <td class="name">
                            {{ $bonus->yearly }}
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Bonus at the end of the Insured Period</th>
                        <td class="name">
                            {{ $bonus->endOfPeriod }}
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Total Premium at the end of Insured Period</th>
                        <td class="name">
                            {{ $bonus->total }}
                        </td>
                    </tr>
                    </thead>
                </table>
            @else
                <h4 class="text-center mt-5"><strong>No Data Found</strong></h4>
            @endif
        </div>
        {{-- Result end --}}

    </div>

@endsection
