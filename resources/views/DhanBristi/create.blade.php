@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Dhan Bristi Money Back Calculator</p>
@endsection
@section('footer_js')


    <script type="text/javascript">

        $('#contactForm').on('submit', function (event) {
            event.preventDefault();

            let age = $('#age').val();
            let term = $('#term').val();
            let sum_assured = $('#sum_assured').val();
            // let subject = $('#subject').val();
            //let message = $('#message').val();


            $.ajax({
                url: "/dhanBristi",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    age: age,
                    term: term,
                    sum_assured: sum_assured,
                    //  subject:subject,
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

@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Dhan Bristi Money Back Calculation</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')
            {{-- {{route('admin.moneyBack.store')}} --}}
            <form class="form-inline" action="/dhanBristi" method="POST">
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
                        @foreach ($companies as $company)

                            <option data-products="{{$company->products}}" value="{{ $company->id }}">
                                {{ $company->name }}
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
                    <input type="number" class="form-control" id="age" placeholder="age in year" name="age"
                           value="{{ $_GET['age']??'' }}">
                </div>

                {{--                <label class="sr-only" for="inlineFormInputName2">Term</label>--}}
                {{--                <div class="input-group mb-2 mr-sm-2">--}}
                {{--                    <div class="input-group-prepend">--}}
                {{--                        <div class="input-group-text">Term</div>--}}
                {{--                    </div>--}}
                {{--                    <input type="number" class="form-control" id="term" placeholder="terms in year" name="term"--}}
                {{--                           value="{{ $_GET['term']??'' }}">--}}
                {{--                </div>--}}

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
                        <div class="input-group-text">Sum Assured</div>
                    </div>
                    <input type="number" class="form-control" id="sum_assured" placeholder="Sum assure"
                           name="sum_assured" value="{{ $_GET['sum_assured']??'' }}">
                </div>

                <label class="sr-only" for="inlineFormInputName2">Loading Charge</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">MoP Charge</div>
                    </div>
                    <select class="form-control form-control-inline input-medium" name="loading_charge_id">
                        <option value="yearly">Yearly</option>
                        <option value="half_yearly">Half Yearly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary mb-2 submit">Submit</button>
            </form>

            <!-- /.box-body -->
        </div>


        <!-- /.box -->
    </div>

    <!-- /.col (right) -->
    </div>
    <!-- /.row -->
@stop
