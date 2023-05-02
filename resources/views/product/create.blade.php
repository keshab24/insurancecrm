@extends('layouts.backend.containerform')

@section('footer_js')

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
@endsection @section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Add Product</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')

            <form action="/productCreate" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <p class="card-inside-title">Product Name:</p>
                    <div class="form-line">
                        <input class="form-control form-control-inline input-medium" name="name" size="16" type="text"
                               placeholder="Product Name"/>
                    </div>
                </div>

                <div class="form-group">
                    <p class="card-inside-title">Code:</p>
                    <div class="form-line">
                        <input class="form-control form-control-inline input-medium" name="code" size="16" type="text"
                               placeholder="Product Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Minimum Sum:</p>
                    <div class="form-line">
                        <input
                            class="form-control form-control-inline input-medium"
                            name="min_sum"
                            type="number"
                            placeholder="Minimum Sum"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Maximum Sum:</p>
                    <div class="form-line">
                        <input
                            class="form-control form-control-inline input-medium"
                            name="max_sum"
                            type="number"
                            placeholder="Maximum Sum"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Minimum Maturity Age:</p>
                    <div class="form-line">
                        <input
                            class="form-control form-control-inline input-medium"
                            name="min_maturity_age"
                            type="number"
                            placeholder="Minimum Maturity Age"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Maximum Maturity Age:</p>
                    <div class="form-line">
                        <input
                            class="form-control form-control-inline input-medium"
                            name="max_maturity_age"
                            type="number"
                            placeholder="Maximum Maturity Age"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Product Type:</p>
                    <div class="form-line">
                        <select name="type" id="" class="form-control">
                            <option value="life">Life</option>
                            <option value="non-life">Non-Life</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Product Status:</p>
                    <div class="form-line">
                        <select name="is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Product Has Loading Charge on Features:</p>
                    <div class="form-line">
                        <select name="has_loading_charge_on_features" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Premium Rate Divider:</p>
                    <div class="form-line">
                        <input
                            class="form-control form-control-inline input-medium"
                            name="premium_rate_divider"
                            type="number"
                            value="1000"
                            placeholder="Premium Rate Divider"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Product Category:</p>
                    <div class="form-line">
                        <select name="category" id="" class="form-control">
                            <option value="endowment">Endowment</option>
                            <option value="pension">Pension</option>
                            <option value="money-back">Money Back</option>
                            <option value="whole-life">Whole Life</option>
                            <option value="term">Term</option>
                            <option value="retirement-pension">Retirement-Pension</option>
                            <option value="education">Education</option>
                            <option value="children">Children</option>
                            <option value="couple">Couple</option>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <p class="card-inside-title">Company:</p>
                    <div class="form-line">
                        <select class="form-control form-control-inline input-medium" name="company_id">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="box-footer">

                    <button type="submit" class="btn btn-info waves-effect">
          <span>Submit
            <i class="fa fa-check"></i>
          </span>
                    </button>
                </div>

        </div>
    </div>
    <!-- #END# Basic Table -->
    </form>

    <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </div>
    <!-- /.col (right) -->
    </div>
    <!-- /.row -->
@stop
