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
        <h3 class="box-title">Mode of Payment</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')

        <form class="form-inline"
            action="{{ route('loadingcharges.update', $loadingcharge->id) }}" method="post">
            @csrf
            {{ method_field('PUT') }}
            <input type="hidden" name="_method" value="PUT">
            <label class="sr-only" for="inlineFormInputGroupUsername2">Yearly</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">premium rate *</div>
                </div>
                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Yearly"
                    name="yearly" value="{{ $loadingcharge->yearly }}">
            </div>

            <label class="sr-only" for="inlineFormInputName2">Half-Yearly</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Half-Yearly"
                name="half_yearly" value="{{ $loadingcharge->half_yearly }}">



            <label class="sr-only" for="inlineFormInputName2">Quartery</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Quarterly"
                name="quarterly" value="{{ $loadingcharge->quarterly }}">

            <label class="sr-only" for="inlineFormInputName2">Monthly</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Monthly"
                name="monthly" value="{{ $loadingcharge->monthly }}">


            <select class="form-control input-medium search-select" onchange="findProduct()" id="company"
                name="company_id" required>
                <option selected disabled>Select the Company</option>
                @foreach($companies as $company1)
                    <option data-products="{{ $company1->products }}" value="{{ $company1->id }}" @if ($company1->id
                        ==
                        $company->id) selected @endif>{{ $company1->name }}</option>
                @endforeach
            </select>

            <select class="form-control input-medium search-select" id="products" name="product_id" required>
                @foreach($company->products as $prd)
                    <option @if($prd->id == $product->id) selected @endif value="{{ $prd->id }}">{{ $prd->name }}
                    </option>
                @endforeach

            </select>

            <button type="submit" class="btn btn-primary ml-2 mt-2 mb-2">Update</button>
        </form>
        <!-- /.box-body -->
    </div>
    <div class="box-header">
        <h3 class="box-title">Previous Loading Charges On Mode of Payment</h3>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Yearly</th>
                <th>Half-Yearly</th>
                <th>Quarterly</th>
                <th>Monthly</th>
                <th>Company name</th>
                <th>Product name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loadingcharges as $loadingcharge)
                <tr>

                    <td>{{ $loadingcharge->yearly }}</td>
                    <td>{{ $loadingcharge->half_yearly }}</td>
                    <td>{{ $loadingcharge->quarterly }}</td>
                    <td>{{ $loadingcharge->monthly }}</td>
                    <td> @isset($loadingcharge->company){{ $loadingcharge->company->name }} @endisset</td>
                    <td>@isset($loadingcharge->product){{ $loadingcharge->product->name }} @endisset</td>
                    <td class="justify-content-center">

                        <a href="{{ route('loadingcharges.edit', $loadingcharge->id) }}"
                            id="{{ $loadingcharge->id }}" title="Edit "><button class="btn btn-primary btn-flat"><i
                                    class="fa fa-edit"></i></button></a>&nbsp;
                        <a href="{{ route('loadingcharge.delete', $loadingcharge->id) }}"
                            class="delete-crc" onclick="return confirm('Are you sure you want to Delete?');">
                            <button type="button" class="btn btn-danger btn-flat"><i
                                    class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- /.box -->
</div>

<!-- /.col (right) -->
</div>
<!-- /.row -->
@stop
