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
    <h3 class="box-title">Payment Money Back Schedule</h3>
  </div>
  <div class="box-body">
    @include('layouts.backend.alert')

    {{-- <form class="form-inline" action="\paybackSchedule" method="post">
        @csrf --}}
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-md-8 col-lg-6">
                {{-- <label class="sr-only" for="inlineFormInputGroupUsername2">For 10 Years Term</label> --}}
                <a href="paybackSchedule/tenyears"><button type="submit" class="btn btn-primary btn-lg btn-block">10 Years</button></a>
            </div>
            <div class="col-sm-4 col-md-8 col-lg-6">
                {{-- <label class="sr-only" for="inlineFormInputGroupUsername2">For 15 Years Term</label> --}}
                <a href="paybackSchedule/15years"><button type="submit" href="/fifteenyears" class="btn btn-primary btn-lg btn-block">15 Years</button></a>
            </div>
        </div>
        </div>
      {{-- </form> --}}
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<!-- /.col (right) -->
</div>
<!-- /.row -->
@stop
