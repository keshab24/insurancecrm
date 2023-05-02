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
        <h3 class="box-title">Edit Company</h3>
    </div>
    <div class="box-body">

        <form action="{{ route('companies.update',$company->id) }}" method="POST">
            {{ method_field('PATCH')}}
            {!! csrf_field() !!}
            @include('layouts.backend.alert')

            <div class="form-group">
                <p class="card-inside-title">Insurance Company Name *</p>
                <div class="form-line">
                    <input class="form-control form-control-inline input-medium" name="name" size="16" type="text"
                        id="name" value="{!! $company->name !!}" placeholder="Enter company Name" />
                </div>
            </div>
            <div class="form-group ">
                <p class="card-inside-title">Code*</p>
                <div class="form-line">
                    <input class="form-control form-control-inline input-medium" name="code" size="16" type="text"
                        id="code" value="{!! $company->code !!}" placeholder="Enter company code" />
                </div>
            </div>

            <div class="form-group ">
                <p class="card-inside-title">Priority*</p>
                <div class="form-line">
                    <input class="form-control form-control-inline input-medium" name="priority" size="16" type="number"
                        id="priority" value="{!! $company->priority !!}" placeholder="Enter company code" />
                </div>
            </div>

            <div class="form-line">
                <label for="exampleFormControlSelect1">Insurance Company Type *</label>
                <select class="form-control" id="type" name="type">
                    <option selected disabled>Select</option>
                    <option @if ($company->type == 'Life') selected @endif>Life</option>
                    <option @if ($company->type == 'NonLife') selected @endif>NonLife</option>
                </select>
            </div>
            <div class="form-group">
                <p class="card-inside-title">Company Status:</p>
                <div class="form-line">
                    <select name="is_active" class="form-control">
                        <option value="1" @if($company->is_active == 1) selected @endif>Active</option>
                        <option value="0" @if($company->is_active == 0) selected @endif>Inactive</option>
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
