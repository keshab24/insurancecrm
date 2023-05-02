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
        $(document).ready(function () {
            $('.search-select').select2();
            loadProd();
        });

        function loadProd() {
            $('.comp_prod').empty();
            $(".prod-selected option:selected").each(function () {
                var thisOptionValue = $(this).val();
                var thisOptionText = $(this).text();
                $('.comp_prod').append($('<option>', {
                    text: thisOptionText,
                    value: thisOptionValue,
                }));
                // console.log(thisOptionValue);
                // console.log(thisOptionText);
            });
        };
    </script>
@endsection @section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Add Feature Product</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')

            <form action="/featureproEdit/{{$feature['id']}}" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <p class="card-inside-title">Feature Name:</p>
                    <div class="form-line">
                        <select class="form-control form-control-inline input-medium search-select" name="feature_id">

                            <option value="{{ $feature->id }}">{{ $feature->name }}</option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <p class="card-inside-title">Product Name:</p>
                    @php
                        $arr = $feature->products->pluck('product_id')->toArray();
                    @endphp
                    <div class="form-line">
                        <select class="form-control form-control-inline input-medium search-select prod-selected"
                                onchange="loadProd()" name="product_id[]" multiple="multiple">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @if (in_array($product->id, $arr))selected
                                        @endif >{{$product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <p class="card-inside-title">Compulsory Products:</p>
                    <div class="form-line">
                        <select class="form-control form-control-inline input-medium search-select comp_prod"
                                name="compulsary_product[]" multiple="multiple">
                        </select>
                    </div>
                </div>


                <div class="box-footer">

                    <button type="submit" class="btn btn-info waves-effect">
                        <span>Update
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
