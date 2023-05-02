@extends('layouts.backend.containerlist')

@section('footer_js')
    {{-- <script>
        $(function () {
          $('#example1').DataTable()
          $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
          })
        })
      </script> --}}

    <script>
        $(document).ready(function () {
            $('.search-select').select2();
        });

        function findProduct() {

            var data = $('option:selected', '#company').attr('data-products');

            data = JSON.parse(data);
            var html = '';
            html += '<option selected disabled>Select the Product</>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id + '" data-terms="' + JSON.stringify(data[i].terms) + '">' + data[i].name + '</option>'
            }

            $('#products').html(html);
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.search-select2').select2();
        });

        function findTerms() {

            var data = $('option:selected', '#products').attr('data-terms');

            data = JSON.parse(data);
            var html = '';
            html += '<option selected disabled>Select the term</>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i] + '">' + data[i] + '</option>'
            }

            $('#terms').html(html);
        }
    </script>
@endsection
@section('title')
    <p class="h4 align-center mb-0">Dhan Bristi Money Back Calculation</p>
@endsection

@section('dynamicdata')

    <div class="box">

        <div class="box-body">
            @include('layouts.backend.alert')

            <form class="form-inline" action="{{ route('admin.dhanBristi.store') }}" method="post">
                @csrf

                <div class="form-group mx-sm-3">
                    <label class="">Company Name</label>
                    <select
                        class="form-control form-control-inline input-medium search-select"
                        onchange="findProduct()"
                        id="company"
                        name="company_id"
                        required
                    >
                        <option selected disabled>Select the Company</option>
                        @foreach ($companies as $com)

                            <option data-products="{{$com->products}}" value="{{ $com->id }}">
                                {{ $com->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mx-sm-3">
                    <label class="">Products</label>
                    <select
                        class="form-control form-control-inline input-medium search-select2"
                        id="products"
                        onchange="findTerms()"
                        name="product_id"
                        required
                    >
                        <option selected disabled>Select the Product</option>
                    </select>
                </div>

                <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Age</div>
                    </div>
                    <input type="text" class="form-control" id="age" placeholder="age in year" name="age" value="">
                </div>

                {{--            <label class="sr-only" for="inlineFormInputName2">Term</label>--}}
                {{--            <div class="input-group mb-2 mr-sm-2">--}}
                {{--                <div class="input-group-prepend">--}}
                {{--                    <div class="input-group-text">Term</div>--}}
                {{--                </div>--}}
                {{--                <input type="text" class="form-control" id="term" placeholder="terms in year" name="term" value="">--}}
                {{--            </div>--}}

                <div class="form-group mx-sm-3">
                    <label class="">Term</label>
                    <select
                        class="form-control form-control-inline input-medium search-select"
                        id="terms"
                        name="term"
                        required
                    >
                        <option selected disabled>Select the Term</option>
                    </select>
                </div>


                <label class="sr-only" for="inlineFormInputName2">Sum Assured</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Sum</div>
                    </div>
                    <input type="number" class="form-control" id="inlineFormInputGroupUsername2"
                           placeholder="Sum assure" name="sum_assured" value="">
                </div>

                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Charge</div>
                    </div>
                    <select class="form-control form-control-inline input-medium" name="loading_charge_id">
                        <option value="yearly">Yearly</option>
                        <option value="half_yearly">Half Yearly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </form>


            <div class="dataTables_wrapper dt-bootstrap4">
            <!-- <div class="box-header">
        <h3 class="box-title">ROLES</h3>
        <ul class="header-dropdown m-r--5 pull-right">
          <li class="dropdown" style="list-style : none;">
               <a href="{{ route('admin.privilege.role.create') }}"><button type="button" class="btn btn-primary waves-effect">ADD NEW <b>+</b></button></a>
            </li>
        </ul>
      </div>

    </.box-header -->
                <div class="box-body">

                    @include('layouts.backend.alert')


                    <div class="mx-auto text-center">

                        <label class=" mb-2">Selected Company: {{ $company ? $company->name : 'N/A' }}</label>
                        <br>
                        <label class=" mb-2">Selected Product: {{ $product ? $product->name : 'N/A' }}</label>

                    </div>
                    @if($tableRate)
                        <table id="tablebody" class="table table-bordered table-hover role-table">
                            <thead>
                            <tr class="gradeX">
                                <th>Age</th>
                                <td class="index">
                                    {{ $age }}
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
                            <th>Rate</th>
                            <td class="name">
                                {{ $tableRate }}
                            </td>
                            </tr>
                            <tr>
                                <th>New Rate</th>
                                <td class="name">
                                    {{$newRate}}
                                </td>
                            </tr>
                            <tr>
                                <th>Premium Amount (before ADB and Term Rider)</th>
                                <td class="name">
                                    {{ $premiumAmount}}
                                </td>
                            </tr>
                            <tr>
                                <th>ADB Rate</th>
                                <td class="name">
                                    {{ $aDB }}
                                </td>
                            </tr>
                            <tr>
                                <th>ABD (Accidental Benefits)</th>
                                <td class="name">
                                    {{ $accBenefit }}
                                </td>
                            </tr>
                            <tr>
                                <th>Term Rider Table Rate</th>
                                <td class="name">
                                    {{ $termRiderTR}}
                                </td>
                            </tr>
                            <tr>
                                <th>Term Rider Amount</th>
                                <td class="name">
                                    {{ $trAmount }}
                                </td>
                            </tr>
                            <tr>
                                <th>Total Premium after ADB and Term rider</th>
                                <td class="name">
                                    {{ $totalPremium }}
                                </td>
                            </tr>
                            <tr class="gradeX text-center">
                                <th colspan="2">
                                    <h6>Bonus Calculation</h6>
                                    @if($bonus->rate == 'N/A')
                                        <span class="invalid-feedback d-block">Bonus rate not available. Please insert bonus rate.</span>
                                    @endif
                                </th>
                            </tr>
                            <tr class="gradeX">
                                <th>Bonus Rate</th>
                                <td class="name">
                                    {{ $bonus->rate }}
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Bonus Per Year</th>
                                <td class="name">
                                    {{ $bonus->yearly }}
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Bonus at the end of the year</th>
                                <td class="name">
                                    {{ $bonus->endOfPeriod }}
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Total payment at the end of Insured Period</th>
                                <td class="name">
                                    {{ $bonus->total }}
                                </td>
                            </tr>
                            <tr class="gradeX text-center">
                                <th colspan="2">
                                    <h6>Payment Money back Schedule </h6>
                                    @if(count($paybackSchedule) < 1)
                                        <span class="invalid-feedback d-block">Payback Schedule not available. Please insert appropriate payback schedule data.</span>
                                    @endif
                                </th>
                            </tr>
                            </thead>

                        </table>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Payback Years</th>
                                <th scope="col">Payback Rate (in %)</th>
                                <th scope="col">Payback Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($paybackSchedule as $payback)
                                <tr>
                                    <td>{{ $payback->payback_year }}</td>
                                    <td>{{ (int)$payback->rate }} %</td>
                                    <td>{{ $payback->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h4 class="text-center mt-5"><strong>No Data Found</strong></h4>
                    @endif
                </div>
                <!-- /.box-body -->

                <!-- /.box -->

            </div>
        </div>
    </div>


@endsection
