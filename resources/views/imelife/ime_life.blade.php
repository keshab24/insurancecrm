@extends('layouts.backend.containerform')

@section('title')
<p class="h4 align-center mb-0">IME LIfe Insurance</p>
@endsection
@section('dynamicdata')
<div class="card m-3 Card--custom__header">
    <h5 class="card-header">Insurance Policy</h5>
    <div class="card m-3 Card--custom__header">
        <h5 class="card-header">Enter Personal Detail</h5>

        <div class="card-body">

        <form class="form-inline" action="{{route('admin.ime.life.insurance.one')}}" method="post">
           @csrf
                <div class="form-group col-12">
                    <div class="row justify-content-center">
                        <div class="full-name">
                            <label for="Full name" class="pl-5 pb-0 pr-5"><b>Full Name </b><span
                                    style="color:red">*</span></label>
                        </div>
                        <input type="text" class="form-control mb-5 mr-sm-3" id="inlineFormInputName2"
                            placeholder="Enter first name" name="fname" value="{{old('fname')}}">

                        <input type="text" class="form-control mb-5 mr-sm-3" id="inlineFormInputName2"
                            placeholder="Enter middle name">

                        <input type="text" class="form-control mb-5 mr-sm-3" id="inlineFormInputName2"
                            placeholder="Enter last name">
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="row  justify-content-center">
                        <div class="full-name">
                            <label for="Full name" class="pl-5 pb-0 pr-5"><b>Gender </b><span
                                    style="color:red">*</span></label>
                        </div>
                        <select name="gender" id="gen" class="form-control mb-5 mr-sm-3 ml-3" id="inlineFormInputName3">
                            <option value="male">male</option>
                            <option value="female">female</option>
                            <option value="other">other</option>
                        </select>

                        <div class="full-name">
                            <label for="Full name" class="pl-5 pb-0 pr-3"><b>Mobile </b><span
                                    style="color:red">*</span></label>
                        </div>
                        <input type="text" class="form-control mb-3 mr-sm-" id="inlineFormInputName3"
                            placeholder="Enter Mobile number">
                    </div>
                </div>
                <div class="form-group col-12">
                    <div class="row  justify-content-center">
                        <div class="mobile">
                            <label for="dob" class="pl-5 pb-0 pr-5"><b>DOB </b><span style="color:red">*</span></label>
                        </div>
                        <select name="bs" id="gen" class="form-control mb-5 mr-sm-3 ml-3" id="inlineFormInputName4">
                            <option value="bs">BS</option>
                            <option value="ad">AD</option>

                        </select>


                        <input type="date" class="form-control mb-3 mr-sm-3" id="inlineFormInputName4"
                            placeholder="Enter Mobile number">

                    </div>
                </div>

                <button type="reset" class="btn btn-md ml-5 btn-danger mb-2 submit">Clear All</button>

                <button type="submit" class="btn btn-md ml-2 btn-dark mb-2 submit">Proceed</button>


            </form>
        </div>
    </div>
</div>

{{--
<script type="text/javascript">
    $('#contactForm').on('submit', function (event) {
        event.preventDefault();

        let age = $('#age').val();
        let term = $('#term').val();
        let sum_assured = $('#sum_assured').val();
        // let subject = $('#subject').val();
        //let message = $('#message').val();



        $.ajax({
            url: "/premium/",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
age: age,
term: term,
sum_assured: sum_assured,
// subject:subject,
//message:message,
},
success: function (response) {
swal('success', response.message, 'success');
$('#tablebody').find('.index').text(
response.age);

},
});
});

</script>

<script>
    $(document).ready(function () {
        $('.search-select').select2();
        $("#age").prop('min', 10);
        $("#age").prop('max', 60);
        $("#term").prop('min', 5);
        $("#term").prop('max', 52);
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
            console.log(data[i]);
            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>'
        }
        // console.log(html);
        $('#products').html(html);

    }

</script>


<script type="text/javascript">
    $(document).ready(function () {

        $(document).ready(function () {
            $('#roleAddForm').formValidation({
                framework: 'bootstrap',
                excluded: ':disabled',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    role: {
                        // validators: {
                        //   notEmpty: {
                        //     message: 'Role Name field is required.'
                        //   }
                        // }
                    }
                },
            });
        });

        $('.check-module').on('change', function (e) {
            if ($(this).is(':checked')) {
                $(this).closest('tr').find('.check').prop('checked', true);
            } else {
                $(this).closest('tr').find('.check').prop('checked', false);
            }
        });
        $(".submit").click(function () {

            $('.table').removeClass('d-none');
        });

        $('.check').on('change', function (e) {
            var checked = $(this).closest('table').parent().parent().find('.check:checked').length;
            var total = $(this).closest('table').parent().parent().find('.check').length;

            if (checked == 0) {
                $(this).closest('table').parent().parent().find('.check-module').prop('checked', false);
            } else {
                $(this).closest('table').parent().parent().find('.check-module').prop('checked', true);
            }
        });

    });

</script>
@endsection
@section('dynamicdata')

<!-- iCheck -->
<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Premium Calculation</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')

        <form class="form" action="{{ route('premium.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label class="">Company Name</label>
                    <select class="form-control form-control input-medium search-select" onchange="findProduct()"
                        id="company" name="company_id" required>
                        <option selected disabled>Select the Company</option>
                        @foreach($companies as $company)
                            <option data-products="{{ $company->rate_products() }}" value="{{ $company->id }}">
                                {{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label class="">Products</label>
                        <select class="form-control form-control input-medium search-select" id="products"
                            name="product_id" required>
                            <option selected disabled>Select the Product</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Age</div>
                        </div>
                        <input type="number" class="form-control" id="age" placeholder="age in year" name="age"
                            value="{{ old('age') }}">
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="sr-only" for="inlineFormInputName2">Terms</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Terms</div>
                        </div>
                        <input type="number" class="form-control" id="term" placeholder="terms in year" name="term"
                            value="{{ old('term') }}">
                    </div>
                </div>

                <div class="form-group col-12 col-md-6">
                    <label class="sr-only" for="inlineFormInputName2">Sum Assured</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Sum</div>
                        </div>
                        <input type="number" class="form-control" id="sum_assured" placeholder="Sum assure"
                            name="sum_assured" value="{{ old('sum_assured') }}">
                    </div>
                </div>

                <div class="form-group col-12 col-md-6">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Loading Charge</div>
                        </div>
                        <select name="loading_charge" id="laoding" class="form-control">
                            <option selected>yearly</option>
                            <option>half_yearly</option>
                            <option>quarterly</option>
                            <option>monthly</option>
                        </select>
                    </div>
                </div>
                {{--
            <div class="form-group col-12 col-md-6">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">Adb</span>
                  </div>
                  <select class="form-control " id="adb" name="adb" >
                      <option selected disabled>Do you want to take accidental benefits?</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                  </select>
              </div>
          </div>

          <div class="form-group col-12 col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Term rider</span>
                </div>
                <select class="form-control " id="termrider" name="termrider">
                    <option selected disabled>Do you want to take term rider?</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
--}}{{--

                <button type="submit" class="btn btn-primary mb-2 mr-sm-2 submit align-center">Calculate</button>
        </form>
    </div>

    <label class="sr-only" for="inlineFormInputName2">Premium Calculated</label>
    <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
            <div class="input-group-text">Premium Calculated</div>
        </div>

    </div>

    <!-- /.box-body -->
</div>


<!-- /.box -->
--}}
                <!-- /.row -->
                @stop
