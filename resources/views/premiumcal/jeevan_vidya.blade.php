@extends('layouts.backend.containerform')

@section('footer_js')
<script>
    $(document).ready(function () {
        $('.search-select').select2();
        $("#age").prop('min', 0);
        $("#age").prop('max', 10);
        $("#term").prop('min', 6);
        $("#term").prop('max', 16);
        $("#sum_assured").prop('min', 10000);
    });

    function findProduct() {
        // console.log('im here');
        var data = $('option:selected', '#company').attr('data-products');
        
        data = JSON.parse(data);
        // console.log(data);
        var html = '';
        html += '<option selected disabled>Select the Product</>';
        for (var i = 0; i < data.length; i++) {
            //console.log(data[i]);
            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>'
        }
        // console.log(html);
        $('#products').html(html);

    }

</script>

@endsection
@section('title')
<p class="h4 align-center mb-0">Child Endowmemt Plan(Jeevan Vidya)</p>
@endsection

@section('dynamicdata')

<div class="box">

    <div class="box-body">
        @include('layouts.backend.alert')

        <form class="form" action="{{ route('premium.child.jeevan.vidya') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label class="">Company Name</label>
                    <select class="form-control form-control-inline input-medium search-select" onchange="findProduct()"
                        id="company" name="company_id" required>
                        <option selected disabled>Select the Company</option>
                        @foreach($companies as $company1)
                            <option data-products="{{ $company1->education_products() }}"
                                value="{{ $company1->id }}" @if ($company1->id == $company->id) selected
                                @endif>{{ $company1->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label class="">Products</label>
                        <select class="form-control form-control input-medium search-select" id="products"
                            name="product_id" required>
                            @foreach($company->education_products() as $prd)
                                <option @if($prd->id == $product->id) selected @endif
                                    value="{{ $prd->id }}">{{ $prd->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Proposer age</div>
                        </div>
                        <input type="number" class="form-control" id="propose_age" placeholder="age in year" name="proposer_age"
                            value="{{ $proposer_age }}">
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Child Age</div>
                        </div>
                        <input type="number" class="form-control" id="age" placeholder="age in year" name="age"
                            value="{{ $age }}">
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
                        <input type="number" class="form-control" id="sum_assured" placeholder="Sum assure"
                            name="sum_assured" value="{{ $sum_assured }}">
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

                <button type="submit" class="btn btn-primary mb-2 mr-sm-2 submit align-center">Calculate</button>
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

            @if($rate)
                <table id="tablebody" class="table table-bordered table-hover role-table">
                    <thead>
                        <tr class="gradeX">
                            <th>Proposer Age</th>
                            <td class="index">
                                {{ $proposer_age }}
                            </td>
                        </tr>
                        <tr class="gradeX">
                            <th>Child Age</th>
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
                            {{ $rate->rate }}
                        </td>
                        </tr>
                        <tr>
                            <th>Discount on Sa</th>
                            <td class="name">
                                {{ $discount }}



                            </td>
                        </tr>
                        <tr>
                            <th>New Rate</th>
                            <td class="name">
                                @if(isset($charge))
                                    {{ $rate->rate * $charge - $discount }}
                                @else
                                    {{ $rate->rate- $discount }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>loading charge on mop</th>
                            <td class="name">
                                {{ $rate->rate * $charge }}
                            </td>
                        </tr>
                        <tr class="gradeX">
                            <th>Premium Amount</th>
                            <td class="name">
                                @if(isset($charge))
                                    {{ ($rate->rate * $charge - $discount)/1000*$sum_assured }}
                                @else
                                    <b> {{ ($rate->rate-$discount)/1000*$sum_assured }} </b>
                                @endif
                            </td>
                        </tr>


                        <tr class="gradeX">
                            <th>Pwb rate</th>
                            <td class="name">
                                @if(isset($pwbrate))
                                    {{ $pwbrate }}
                                @else
                                    no rate
                                @endif

                            </td>
                        </tr>

                        <tr class="gradeX">
                            <th>Pwb Amount</th>
                            <td class="name">
                                @if(isset($charge))
                                    {{ ($pwbrate/100) * (($rate->rate * $charge - $discount)/1000*$sum_assured) }}
                                @else
                                    <b> {{ ($pwbrate/100) * (($rate->rate-$discount)/1000*$sum_assured) }}
                                    </b>
                                @endif

                            </td>
                        </tr>

                        <tr class="gradeX">
                            <th>Total Premium after adding PWB</th>
                            <td class="name">
                                @if(isset($charge))
                                    {{ ($pwbrate/100 * ($rate->rate * $charge - $discount)/1000*$sum_assured) + (($rate->rate * $charge - $discount)/1000*$sum_assured) }}
                                @else
                                    <b>
                                        {{ (($pwbrate/100) * (($rate->rate-$discount)/1000*$sum_assured) + ($rate->rate-$discount)/1000*$sum_assured) }}</b>
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
                                @if(isset($bonus))
                                    {{ $bonus }}
                                @else
                                    no bonus
                                @endif

                            </td>

                        </tr>
                        <tr class="gradeX">
                            <th>Bonus Per Year</th>
                            <td class="name">
                                @if(isset($bonus))
                                    {{ ($bonus) * $sum_assured }}
                                @else
                                    no bpy
                                @endif
                            </td>
                        </tr>
                        <tr class="gradeX">
                            <th>Bonus at the end of the year</th>
                            <td class="name">
                                @if(isset($bonus))
                                    {{ ($bonus) * $sum_assured *$term }}
                                @else
                                    no bonus
                                @endif
                            </td>
                        </tr>
                        <tr class="gradeX">
                            <th>Total payment at the end of Insured Period</th>
                            <td class="name">
                                @if(isset($bonus))
                                    {{ (($bonus) * $sum_assured *$term) + $sum_assured }}
                                @else
                                    bonus not set
                                @endif
                            </td>
                        </tr>
                    </thead>

                </table>
            @else
                No rate
            @endif

        </div>
        <!-- /.box-body -->

        <!-- /.box -->

    </div>
</div>
</div>


@endsection
