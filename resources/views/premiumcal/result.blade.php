@extends('layouts.backend.containerform')

{{-- @section('footer_js')
<script>
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
  </script>
@endsection--}}
@section('title')
<p class="h4 align-center mb-0">Premium Calculation</p>
@endsection
@section('footer_js')
<script>

    $(document).ready(function () {
        $('.search-select').select2();
        $("#age").prop('min',10);
          $("#age").prop('max',60);
          $("#term").prop('min',5);
          $("#term").prop('max',52);
          $("#sum_assured").prop('min',10000);
    });
  
    function findProduct() {
      // console.log('im here');
        var data = $('option:selected', '#company').attr('data-products');
        data = JSON.parse(data);
       // console.log(data);
        var html = '';
        html += '<option selected disabled>Select the Product</>';
        for (var i = 0; i < data.length; i++) {
          console.log(data[i]);
            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>'
        }
  // console.log(html);
        $('#products').html(html);
  
    }
  </script>
@endsection

@section('dynamicdata')

<div class="box">

<div class="box-body">
@include('layouts.backend.alert')

        <form class="form" action="{{ route('premium.store') }}" method="POST">
@csrf
<div class="form-row">
    <div class="form-group col-12 col-md-6">
        <label class="">Company Name</label>
        <select class="form-control form-control input-medium search-select" onchange="findProduct()" id="company"
            name="company_id" required>
            <option selected disabled>Select the Company</option>
            @foreach($companies as $company1)
                <option data-products="{{ $company1->rate_products() }}" value="{{ $company1->id }}" @if ($company->
                    id == $company1->id) selected @endif>{{ $company1->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-12 col-md-6">
        <div class="form-group">
            <label class="">Products</label>
            <select class="form-control form-control input-medium search-select" id="products" name="product_id"
                required>
                @foreach($company->rate_products() as $prd)
                    <option @if($prd->id == $product->id) selected @endif value="{{ $prd->id }}">{{ $prd->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group col-12 col-md-6">
        <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Age</div>
            </div>
            <input type="number" class="form-control" id="age" placeholder="age in year" name="age" value="{{ $age }}">
        </div>
    </div>
    <div class="form-group col-12 col-md-6">
        <label class="sr-only" for="inlineFormInputName2">Terms</label>
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Terms</div>
            </div>
            <input type="number" class="form-control" id="term" placeholder="terms in year" name="term"
                value="{{ $term }}">
        </div>
    </div>

    <div class="form-group col-12 col-md-6">
        <label class="sr-only" for="inlineFormInputName2">Sum Assured</label>
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Sum</div>
            </div>
            <input type="number" class="form-control" id="sum_assured" placeholder="Sum assure" name="sum_assured"
                value="{{ $sum_assured }}">
        </div>
    </div>

    <div class="form-group col-12 col-md-6">
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Loading Charge</div>
            </div>
            <select name="loading_charge" id="laoding" class="form-control">
                <option selected @if ($loading_charge=='yearly' ) selected @endif>yearly</option>
                <option @if ($loading_charge=='half_yearly' ) selected @endif>half_yearly</option>
                <option @if ($loading_charge=='quarterly' ) selected @endif>quarterly</option>
                <option @if ($loading_charge=='monthly' ) selected @endif>monthly</option>
            </select>
        </div>
    </div>

    <div class="form-group col-12">
        <div class="row">
            <div class="form-check">
                <input id="checkbox2" type="checkbox" name="adb"
                    {{ ($adbreq == 'yes' ? ' checked' : '') }}>
                <label for="checkbox2">Include Adb</label>
            </div>
            <div class="form-check" id="">
                <input id="checkbox3" type="checkbox" name="termrider"
                    {{ ($term_riderreq == 'yes' ? ' checked' : '') }}>
                <label for="checkbox3">Include Term Rider</label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-2 mr-sm-2 submit align-center">Calculate</button>
</div>
</form>
</div>
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

            <label class=" mb-2">Selected Company:
                {{ $company->name ? $company->name : 'N/A' }}</label>
            <br>
            <label class=" mb-2">Selected Product:
                {{ $product ? $product->name : 'N/A' }}</label>

        </div>
        @if($rate)
            <table id="tablebody" class="table table-bordered table-hover role-table">
                <thead>

                    <tr class="gradeX">
                        <th>Company</th>
                        <td class="index">
                            {!! $company->name !!}
                        </td>

                    </tr>
                    <tr class="gradeX">
                        <th>Product</th>
                        <td class="index">
                            {{ $product->name }}
                        </td>
                    </tr>

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
                        @if(isset($rate->rate))
                            {{ $rate->rate }}
                        @endif
                    </td>
                    </tr>
                    <tr>
                        <th>Mode of Payment</th>
                        <td class="name">
                            {{ $rate->rate * $charge }}
                        </td>
                    </tr>
                    <tr>
                        <th>Discount on Sa</th>
                        <td class="name">
                            @if(isset($discount->discount_value))
                                {{ $discount->discount_value }} @else
                                2
                            @endif


                        </td>
                    </tr>
                    <tr>
                        <th>New Rate</th>
                        <td class="name">
                            @if(isset($charge))
                                {{ $rate->rate * $charge - $discount->discount_value }}
                            @else
                                {{ $rate->rate-2 }}
                            @endif
                        </td>
                    </tr>

                    <tr class="gradeX">
                        <th>Premium Amount</th>
                        <td class="name">
                            @if(isset($charge))
                                {{ ($rate->rate * $charge - $discount->discount_value)/1000*$sum_assured }}
                            @elseif(isset($discount->discount_value))
                                {{ ($rate->rate - $discount->discount_value)/1000*$sum_assured }}
                            @else
                                <b> {{ ($rate->rate-2)/1000*$sum_assured }} </b>
                            @endif
                        </td>
                    </tr>
                    @if($adbreq == 'yes')
                        <tr class="gradeX">
                            <th>ADB (Accidental Benefits)</th>
                            <td class="name">
                                {{ $aDB }}
                            </td>
                        </tr>
                    @endif
                    @if($term_riderreq == 'yes')
                        <tr class="gradeX">
                            <th>Term rider rate</th>
                            <td class="name">
                                {{ $term_rider_rate }}
                            </td>
                        </tr>
                        <tr class="gradeX">
                            <th>Term rider</th>
                            <td class="name">
                                {{ $term_rider }}
                            </td>
                        </tr>
                    @endif
                    <tr class="gradeX">
                        @if($adbreq == 'yes' && $term_riderreq == 'yes')
                            
                            <th>Total Premium after ADB and Term rider</th>
                            
                                @elseif($adbreq == 'yes' && $term_riderreq == 'no')
                            <th>Total Premium after ADB</th>
                            
                                @elseif($adbreq == 'no' && $term_riderreq == 'yes')
                            <th>Total Premium after Term rider</th>
                        @else
                            <th>Total Premium </th>
                        @endif
                        <td class="name">
                            @if(isset($charge))
                                {{ $term_rider + $aDB + ($rate->rate * $charge - $discount->discount_value)/1000*$sum_assured }}
                            @elseif(isset($discount->discount_value))
                                {{ $term_rider +$aDB + ($rate->rate - $discount->discount_value)/1000*$sum_assured }}
                            @else
                                {{ $term_rider_rate +$aDB + ($rate->rate -2)/1000*$sum_assured }}
                            @endif
                        </td>
                    </tr>
                    <tr class="gradeX text-center">
                        <th colspan="2">
                            <h6>Bonus Calculation</h6>
                        </th>
                    </tr>
                    <tr class="gradeX">
                        <th>Bonus Rate</th>
                        <td class="name">
                            @if(isset($bonus->term_rate))
                                {{ $bonus->term_rate }}
                            @else
                                <b> 0.008 </b>
                            @endif
                        </td>

                    </tr>
                    <tr class="gradeX">
                        <th>Bonus Per Year</th>
                        <td class="name">
                            @if(isset($bonus->term_rate))
                                {{ ($bonus->term_rate) * $sum_assured }}
                            @else
                                <b> {{ 0.008 * $sum_assured }}</b>
                            @endif
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Bonus at the end of the year</th>
                        <td class="name">
                            @if(isset($bonus->term_rate))
                                {{ ($bonus->term_rate) * $sum_assured *10 }}
                            @else
                                <b> {{ 0.008 * $sum_assured * 10 }} </b>
                            @endif
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Total payment at the end of Insured Period</th>
                        <td class="name">
                            @if(isset($bonus->term_rate))
                                {{ (($bonus->term_rate) * $sum_assured *10) + $sum_assured }}
                            @else
                                <b> {{ (0.008 * $sum_assured * 10) + $sum_assured }}</b>
                            @endif
                        </td>
                    </tr>
                </thead>

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
