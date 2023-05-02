@extends('layouts.backend.containerform')

@section('footer_js')
<script>
    $(document).ready(function () {
        $('.search-select').select2();

        $("#age").prop('min', 0);
        $("#age").prop('max', 10);
        $("#term").prop('min', 15);
        $("#term").prop('max', 35);
        $("#sum_assured").prop('min', 50000);
        $("#sum_assured").prop('max', 5000000);

        var companyID = $('option:selected', '#company').val();
        if (companyID == 7) {
            $('#crcrate').removeClass('d-none');
        }
    });

    function findProduct() {
        // console.log('im here');
        var data = $('option:selected', '#company').attr('data-products');
        var companyID = $('option:selected', '#company').val();
        if (companyID == 7) {
            $('#crcrate').removeClass('d-none');
        } else {
            $('#crcrate').addClass('d-none');
        }

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
@section('title')
<p class="h4 align-center mb-0">Child Endowmemt Plan</p>
@endsection

@section('dynamicdata')

<div class="box">

    <div class="box-body">
        @include('layouts.backend.alert')

        <form class="form" action="{{ route('premium.child.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label class="">Company Name</label>
                    <select class="form-control form-control-inline input-medium search-select" onchange="findProduct()"
                        id="company" name="company_id" required>
                        <option selected disabled>Select the Company</option>
                        @foreach($companies as $company1)
                            <option data-products="{{ $company1->child_products() }}" value="{{ $company1->id }}"
                                @if ($company1->id == $company->id) selected @endif>{{ $company1->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label class="">Products</label>
                        <select class="form-control form-control input-medium search-select" id="products"
                            name="product_id" required>
                            @foreach($company->child_products() as $prd)
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
                        <input type="number" class="form-control" id="age" placeholder="age in year" name="proposer_age"
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
                {{--
                  <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">PWB</span>
                        </div>

                        <select class="form-control" id="pwb" name="pwb" >
                            <option selected disabled>Do you want to take Pwb?</option>
                            <option value="yes" @if ($pwbreq == 'yes') selected @endif>Yes</option>
                            <option value="no"  @if ($pwbreq == 'no') selected @endif>No</option>
                        </select>
                    </div>
                </div>
                  
               
                <div class="form-group col-12 col-md-6 d-none" id="crcrate">
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text">CRC Rate</span>
                      </div>
                      <select class="form-control " id="crc" name="crc">
                          <option selected disabled>Do you want to take crc rate(one time charge)?</option>
                          <option value="yes" @if ($crcreq == 'yes') selected @endif>Yes</option>
                          <option value="no" @if ($crcreq == 'no') selected @endif>No</option>
                      </select>
                  </div>
              </div>--}}

                <div class="form-group col-12">
                    <div class="row">
                        <div class="form-check">
                            <input id="checkbox2" type="checkbox" name="pwb"
                                {{ ($pwbreq == 'yes' ? ' checked' : '') }}>
                            <label for="checkbox2">Include pwb</label>
                        </div>
                        <div class="form-check d-none" id="crcrate">
                            <input id="checkbox3" type="checkbox" name="crc"
                                {{ ($crcreq == 'yes' ? ' checked' : '') }}>
                            <label for="checkbox3">Include Crc Rate</label>
                        </div>
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
            <div class="mx-auto text-center">

                <label class=" mb-2">Selected Company:
                    {{ $company->name ? $company->name : 'N/A' }}</label>
                <br>
                <label class=" mb-2">Selected Product:
                    {{ $product ? $product->name : 'N/A' }}</label>

            </div>

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
                    <th>Table Rate</th>
                    <td class="name">
                        {{ $rate->rate }}
                    </td>
                    </tr>
                    <tr>
                        @if($company->id == 4)
                    <tr>
                        <th>loading charge on mop</th>
                        <td class="name">
                            {{ $rate->rate * $charge }}
                        </td>
                    </tr>
                    @endif
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
                            @if($company->id == 4)

                                @if(isset($charge))
                                    {{ $rate->rate *$charge - $discount->discount_value }}
                                @elseif(isset($discount->discount_value))
                                    {{ $rate->rate - $discount->discount_value }}
                                @else
                                    {{ $rate->rate-2 }}
                                @endif
                            @elseif($company->id == 7)
                                {{ $rate->rate - $discount->discount_value }}
                            @endif
                        </td>
                    </tr>

                    <tr class="gradeX">
                        <th>Premium Amount before pwb</th>
                        <td class="name">
                            @if($company->id == 4)
                                @if(isset($charge))
                                    {{ ($rate->rate * $charge - $discount->discount_value)/1000*$sum_assured }}
                                @elseif(isset($discount->discount_value))
                                    {{ ($rate->rate - $discount->discount_value)/1000*$sum_assured }}
                                @else
                                    <b> {{ ($rate->rate-2)/1000*$sum_assured }} </b>
                                @endif
                            @elseif($company->id == 7)
                                {{ ($rate->rate - $discount->discount_value)/1000*$sum_assured }}
                            @endif
                        </td>
                    </tr>
                    @if($company->id == 7)
                        <tr>
                            <th>Discount on MOP</th>
                            <td class="name">

                                {{ (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge }}


                            </td>
                        </tr>
                        <tr>
                            <th>Discounted Premium</th>
                            <td class="name">

                                {{ (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge }}


                            </td>
                        </tr>
                    @endif
                    @if($pwbreq == 'yes')
                        <tr class="gradeX">
                            <th>Pwb Rate</th>
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
                                @if($company->id == 4)
                                    @if(isset($charge))
                                        {{ $pwbrate/100 * ($rate->rate * $charge - $discount->discount_value)/1000*$sum_assured }}
                                    @elseif(isset($discount->discount_value))
                                        {{ ($pwbrate/100) * (($rate->rate - $discount->discount_value)/1000*$sum_assured) }}
                                    @else
                                        <b> {{ ($pwbrate/100) * (($rate->rate-2)/1000*$sum_assured) }}
                                        </b>
                                    @endif
                                @elseif($company->id == 7)
                                    {{ $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured }}
                                @endif

                            </td>
                        </tr>


                        <tr class="gradeX">

                            <th>Total Premium after adding PWB</th>
                            <td class="name">
                                @if($company->id == 4)
                                    @if(isset($charge))
                                        {{ ($pwbrate/100 * ($rate->rate * $charge - $discount->discount_value)/1000*$sum_assured) + (($rate->rate * $charge - $discount->discount_value)/1000*$sum_assured) }}
                                    @elseif(isset($discount->discount_value))
                                        {{ ($pwbrate/100) * (($rate->rate - $discount->discount_value)/1000*$sum_assured) + (($rate->rate - $discount->discount_value)/1000*$sum_assured) }}
                                    @else
                                        <b> {{ ($pwbrate/100) * (($rate->rate-2)/1000*$sum_assured) + (($rate->rate - 2)/1000*$sum_assured) }}
                                        </b>
                                    @endif

                                @elseif($company->id == 7)
                                    {{ (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured) }}
                                @endif
                            </td>
                        </tr>
                    @endif

                    <blade
                        if|(%24company-%3Eid%20%3D%3D%207%20%26%26%20%24crcreq%20%3D%3D%20%26%2339%3Byes%26%2339%3B%20)%0D>
                        <tr>
                            <th>Crc Rate</th>
                            <td class="name">

                                {{ $crcrate }}


                            </td>
                        </tr>
                        <tr>
                            <th>Crc Amount(one time premium)</th>
                            <td class="name">

                                {{ $crcrate/1000 * $sum_assured }}


                            </td>
                        </tr>
                        <tr>
                            <th>Final Premium</th>
                            <td class="name">

                                {{ $crcrate/1000 * $sum_assured + (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Annual Premium</th>
                            <td class="name">

                                {{ $crcrate/1000 * $sum_assured + (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured) }}
                            </td>
                        </tr>
                        @if($loading_charge == 'half_yearly')
                            <tr>
                                <th>For half year</th>
                                <td class="name">

                                    {{ ($crcrate/1000 * $sum_assured + (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured)) /2 }}
                                </td>
                            </tr>
                            <tr>
                                <th>One time Premium is paid once so it is calculated in first Premium so H/Y=</th>
                                <td class="name">

                                    {{ ($crcrate/1000 * $sum_assured) + ($crcrate/1000 * $sum_assured + (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured)) /2 }}
                                </td>
                            </tr>
                        @elseif($loading_charge == 'quarterly')
                            <tr>
                                <th>For Quarterly</th>
                                <td class="name">

                                    {{ ($crcrate/1000 * $sum_assured + (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured)) /4 }}
                                </td>
                            </tr>
                            <tr>
                                <th>One time Premium is paid once so it is calculated in first Premium so quarterly=
                                </th>
                                <td class="name">

                                    {{ (($crcrate/1000 * $sum_assured) + ($crcrate/1000 * $sum_assured + (($rate->rate - $discount->discount_value)/1000*$sum_assured) - (($rate->rate - $discount->discount_value)/1000*$sum_assured) * $charge +( $pwbrate/100 * ($rate->rate - $discount->discount_value)/1000*$sum_assured)) /4) }}
                                </td>
                            </tr>
                        @endif
                    @endif

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
                                {{ ($bonus->term_rate) * $sum_assured *$term }}
                            @else
                                <b> {{ 0.008 * $sum_assured * $term }} </b>
                            @endif
                        </td>
                    </tr>
                    <tr class="gradeX">
                        <th>Total payment at the end of Insured Period</th>
                        <td class="name">
                            @if(isset($bonus->term_rate))
                                {{ (($bonus->term_rate) * $sum_assured *$term) + $sum_assured }}
                            @else
                                <b> {{ (0.008 * $sum_assured * 10) + $sum_assured }}</b>
                            @endif
                        </td>
                    </tr>
                </thead>

            </table>

        </div>
        <!-- /.box-body -->

        <!-- /.box -->

    </div>
</div>
</div>


@endsection
