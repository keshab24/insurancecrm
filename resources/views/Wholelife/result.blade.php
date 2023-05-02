@extends('layouts.backend.containerform')


 @section('footer_js')
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

<script>

  $(document).ready(function () {
      $('.search-select').select2();
      $("#age").prop('min',16);
          $("#age").prop('max',65);
          $("#term").prop('min',5);
          $("#term").prop('max',25);
          $("#sum_assured").prop('min',100000);
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
@section('title')
<p class="h4 align-center mb-0">Whole Life Calculation</p>
@endsection

@section('dynamicdata')

<div class="box">

<div class="box-body">
        @include('layouts.backend.alert')

        <form class="form" action="{{ route('admin.wholelife.store') }}" method="post">
            @csrf
          
              <div class="form-row">
                <div class="form-group col-12 col-md-6">
                            <label class="">Company Name</label>
                            <select class="form-control form-control input-medium search-select"
                                    onchange="findProduct()" id="company" name="company_id" required>
                                <option selected disabled>Select the Company</option>
                                @foreach ($companies as $company1)
                              <option data-products="{{$company1->whole_life_products()}}"
                                      value="{{ $company1->id }}" @if ($company->id == $company1->id) selected @endif>{{ $company1->name }}</option>
                          @endforeach
                            </select>
                   </div>
                   <div class="form-group col-12 col-md-6">
                        <div class="form-group">
                            <label class="">Products</label>
                            <select class="form-control form-control input-medium search-select" id="products" name="product_id" required>
                              @foreach ($company->whole_life_products() as $prd)
                              <option @if($prd->id == $product->id) selected @endif value="{{ $prd->id }}">{{ $prd->name }}</option>
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
                    <input type="number" class="form-control" id="age" placeholder="age in year" name="age"  value="{{$age}}">
                    </div>
                        </div>
                    <div class="form-group col-12 col-md-6">
                <label class="sr-only" for="inlineFormInputName2">Terms</label>
                <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Terms</div>
                        </div>
                        <input type="number" class="form-control" id="term" placeholder="terms in year" name="term" value="{{$term}}">
                      </div>
                    </div>
        
                    <div class="form-group col-12 col-md-6">
                      <label class="sr-only" for="inlineFormInputName2">Sum Assured</label>
                      <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Sum</div>
                              </div>
                              <input type="number" class="form-control" id="sum_assured" placeholder="Sum assure" name="sum_assured"  value="{{$sum_assured}}">
                            </div>
                    </div>
        
                    <div class="form-group col-12 col-md-6">
                            <div class="input-group mb-2 mr-sm-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Loading Charge</div>
                              </div>
                              <select name="loading_charge"  id="laoding" class="form-control">
                                <option selected @if ($loading_charge == 'yearly') selected @endif>yearly</option>
                                  <option @if ($loading_charge == 'half_yearly') selected @endif>half_yearly</option>
                                  <option @if ($loading_charge == 'quarterly') selected @endif>quarterly</option>
                                  <option @if ($loading_charge == 'monthly') selected @endif>monthly</option>
                              </select>
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

      @if($tableRate->rate)

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
                        {{$tableRate->rate }}
                    </td>
                  </tr>
                  
                  @if($company->id == 4)               
                  <tr>
                    <th>loading charge on mop</th>
                    <td class="name">
                       {{$tableRate->rate * $charge}}
                      </td>
              </tr>
              @endif
                 <tr>
                      <th>Discount on Sa</th>
                      <td class="name">
                       @if(isset($discountonSA))
                        {{ $discountonSA }} @else
                        2
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>New Rate</th>
                    <td class="name">
                        @if(isset($discountonSA))
                        {{$newRate}} @else
                        {{$tableRate->rate -2}}
                        @endif
                       
                    </td>
                </tr>
               
@if($company->id == 4)
                <tr>
                    <th>Premium Amount (before ADB and Term Rider)</th>
                    <td class="name">
                        {{ $premiumAmount}}
                    </td>
                </tr>
                @endif
                @if($company->id == 7)
                <tr>
                  <th>Premium Amount before discount</th>
                  <td class="name">
                      @if(isset($discountonSA))
                      {{ $premiumAmount}} @else
                      {{($tableRate->rate - 2)/1000 *$sum_assured }}@endif
                      
                  </td>
              </tr>

              <tr>
                <th>Discount on MOP</th>
                <td class="name">

                    @if(isset($discountonSA))
                    {{ $discountonmop}} @else
                    {{($tableRate->rate - 2)/1000 *$sum_assured *$charge }}@endif
                   
                </td>
            </tr>
            <tr>
              <th>Actual Premium Amount after discount</th>
              <td class="name">
                  @if(isset($discountonSA))
                  {{ $premiumAmount - $discountonmop}} @else
                  {{($tableRate->rate - 2)/1000 *$sum_assured - (($tableRate->rate - 2)/1000 *$sum_assured *$charge) }}@endif

                 
              </td>
          </tr>
          <tr>
            <th>ADB Rate</th>
            <td class="name">
                {{ $aDB}}
            </td>
        </tr>
        <tr>
          <th>PTD/PWB Rate</th>
          <td class="name">
              {{ $termRiderTR}}
          </td>
      </tr>
      <tr>
        <th>ADB/PTD/PWB amount</th>
        <td class="name">
            {{ $adptb}}
        </td>
    </tr>
    <tr>
      <th>    Premium after discount adding ADB/PTD/PWB
      </th>
      <td class="name">
          @if(isset($discountonSA))
          {{ $premiumAmount - $discountonmop + $adptb}} @else
          {{($tableRate->rate - 2)/1000 *$sum_assured - (($tableRate->rate - 2)/1000 *$sum_assured *$charge) + $adptb }}@endif

         
      </td>
  </tr>
      @endif

      @if($company->id == 4)
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
                @endif

                   
                              <tr class="gradeX text-center">
                                  <th colspan="2"><h6>Bonus Calculation</h6></th>
                            </tr>
                            <tr class="gradeX">
                                <th>Bonus Rate</th>
                                <td class="name">
                                   
                                    {{ $bonusrate }}
                                   
                                  </td>

                          </tr>
                          <tr class="gradeX">
                              <th>Bonus Per Year</th>
                              <td class="name">
                                {{ $bonusrate * $sum_assured }}
                                </td>
                        </tr>
                        <tr class="gradeX">
                            <th>Bonus at the end of the year</th>
                            <td class="name">
                                {{ $bonusrate * $sum_assured * $term }}
                              </td>
                      </tr>
                      <tr class="gradeX">
                          <th>Total payment at the end of Insured Period</th>
                          <td class="name">
                             {{ ($bonusrate * $sum_assured * $term) + $sum_assured }}
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
