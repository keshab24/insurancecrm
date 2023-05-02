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
    <h3 class="box-title">Edit Product</h3>
  </div>
  <div class="box-body">
    @include('layouts.backend.alert')

    <form action="/featureEdit/{{$product['id']}}" method="post">
      {!! csrf_field() !!}

      <div class="form-group">
        <p class="card-inside-title">Product Name:</p>
        <div class="form-line">
          <input class="form-control form-control-inline input-medium" name="product_name" size="16" type="text"
          value="{{$product['name']}}" />
        </div>
      </div>
  
      <div class="form-group">
          <p class="card-inside-title">Code:</p>
          <div class="form-line">
            <input class="form-control form-control-inline input-medium" name="code" size="16" type="text"
              placeholder="Product Name" value="{{$product['code']}}" />
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
