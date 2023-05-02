@extends('layouts.backend.containerform')

@section('title')
<p class="h4 align-center mb-0">Premium Calculation</p>
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
            url: "/premium/child",
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
        <h3 class="box-title">Child Endowment Plan(Jeevan Vidya)</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')

        <form class="form" action="{{ route('premium.child.jeevan.vidya') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label class="">Company Name</label>
                    <select class="form-control form-control input-medium search-select" onchange="findProduct()"
                        id="company" name="company_id" required>
                        <option selected disabled>Select the Company</option>
                        @foreach($companies as $company)
                            <option data-products="{{ $company->education_products() }}" value="{{ $company->id }}">
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
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Proposer age</div>
                        </div>
                        <input type="number" class="form-control" id="propage" placeholder="age in year"
                            name="proposer_age" value="{{ old('proposer_age') }}">
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Child Age</div>
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

                <button type="submit" class="btn btn-primary mb-2 mr-sm-2 submit align-center">Calculate</button>
        </form>

        <label class="sr-only" for="inlineFormInputName2">Premium Calculated</label>
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Premium Calculated</div>
            </div>

        </div>


        <table id="tablebody" class="table table-bordered table-hover role-table d-none">
            <thead>
                <tr class="gradeX">
                    <th>Age</th>
                    <td class="index">
                        @if(isset($age))
                            {{ $age }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Term</th>
                    <td class="name">
                        @if(isset($term))
                            {{ $term }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Sum Assured</th>
                    <td class="name">
                        @if(isset($sum_assured))
                            {{ $sum_assured }}
                        @endif
                    </td>
                </tr>
                <th>Rate</th>
                <td class="name">

                </td>
                </tr>
                <tr>
                    <th>Discount on Sa</th>
                    <td class="name">

                    </td>
                </tr>
                <tr>
                    <th>New Rate</th>
                    <td class="name">

                    </td>
                </tr>
                <tr>
                    <th>loading charge on mop</th>
                    <td class="name">
                        Nill
                    </td>
                </tr>
                <tr class="gradeX">
                    <th>Premium Amount</th>
                    <td class="name">

                    </td>
                </tr>

                <tr class="gradeX">
                    <th colspan="2">Bonus Calculation</th>
                </tr>
                <tr class="gradeX">
                    <th>Bonus Rate</th>
                    <td class="name">

                    </td>
                </tr>
                <tr class="gradeX">
                    <th>Bonus Per Year</th>
                    <td class="name">
                        per year
                    </td>
                </tr>
                <tr class="gradeX">
                    <th>Bonus at the end of the year</th>
                    <td class="name">
                        per year
                    </td>
                </tr>
                <tr class="gradeX">
                    <th>Total payment at the end of Insured Period</th>
                    <td class="name">
                        per year
                    </td>
                </tr>
            </thead>

        </table>
        <!-- /.box-body -->
    </div>


    <!-- /.box -->
</div>

<!-- /.col (right) -->
</div>
<!-- /.row -->
@stop
