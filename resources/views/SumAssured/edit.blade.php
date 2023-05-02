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
    <script>
        $(document).ready(function () {
            $('.search-select').select2();
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

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Edit Discount on Sum Assured</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')

            <form action="/discountEdit/{{$discount['id']}}" method="post">
                @csrf

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Company Name: {{ $discount->company->name }}</label>
                        <input type="hidden" name="company_id" value="{{$discount->company_id}}">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Products: {{ $discount->product->name }}</label>
                        <input type="hidden" name="product_id" value="{{$discount->product_id}}">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="first_amount">Starting Amount</label>
                        <input
                            class="form-control"
                            id="first_amount"
                            name="first_amount"
                            size="16"
                            type="text"
                            placeholder="Starting Amount"
                            value="{{ $discount->first_amount }}"
                        />
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="second_amount">Ending Amount</label>
                        <input
                            class="form-control"
                            id="second_amount"
                            name="second_amount"
                            size="16"
                            type="text"
                            placeholder="Ending Amount"
                            value="{{ $discount->second_amount }}"
                        />
                        <small class="text-muted">
                            In the case of above, please tick the checkbox and leave the ending
                            amount empty
                        </small>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="discount_value">Discount Rate</label>
                        <input
                            type="number"
                            step="any"
                            min="0.0"
                            id="discount_value"
                            name="discount_value"
                            class="form-control"
                            placeholder="Discount Rate"
                            value="{{ $discount->discount_value }}"
                        >
                    </div>

                    <div class="form-group form-check col-12 col-md-6">
                        <input
                            class=""
                            id="above_case"
                            name="above_case"
                            size="16"
                            type="checkbox"
                            value="1"
                            @if($discount->second_amount == 2147483647) checked @endif
                        />
                        <label for="above_case">In case of above. Eg: 100000 or above</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Submit<i class="fa fa-check ml-3"></i>
                </button>
            </form>
        </div>

    </div>
@stop
