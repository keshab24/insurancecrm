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

@endsection @section('dynamicdata')

<!-- iCheck -->
<div class="box box-success">
  <div class="box-header">
    <h3 class="box-title">CRC rate of child</h3>
  </div>
  <div class="box-body">
    @include('layouts.backend.alert')

    <form class="form-inline" action="{{ route('crcrate.store') }}" method="post">
        @csrf
            <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
            <div class="input-group mb-2 mr-sm-2">

              <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Age.." name="age_id">
            </div>

        <label class="sr-only" for="inlineFormInputName2">One Time Charge</label>
        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="one time charge.." name="one_time_charge">

        <select class="form-control input-medium search-select"
                            onchange="findProduct()" id="company" name="company_id" required>
                        <option selected disabled>Select the Company</option>
                        @foreach ($companies as $company)
                            <option data-products="{{$company->child_products()}}"
                                    value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>

                    <select class="form-control input-medium search-select" id="products" name="product_id" required>
                      <option selected disabled>Select the Product</option>
                  </select>

        <button type="submit" class="btn btn-primary ml-2 mt-2 mb-2">Submit</button>
      </form>
<!-- /.box-body -->
</div>
<div class="box-header">
        <h3 class="box-title">Previous Crc Rates of Child Endowment</h3>
      </div>
<table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Age</th>
            <th>One time charge</th>

            <th>Company name</th>
            <th>Product name</th>
            <th>Actions</th>
        </tr>
         </thead>
         <tbody>
            @foreach($crcrates as $crcrate)
           <tr>
             <td>{{$crcrate->age ? $crcrate->age->age : 'N/A'}}</td>
             <td>{{$crcrate->one_time_charge}}</td>

             <td> @isset($crcrate->company){{ $crcrate->company->name}} @endisset</td>
             <td> @isset($crcrate->product){{ $crcrate->product->name}} @endisset</td>
             <td class="justify-content-center">

                <a href="{{ route('crcrate.edit',$crcrate->id) }}" id="{{ $crcrate->id }}"
                      title="Edit "><button class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></button></a>&nbsp;
                      <a href="{{route('crcrate.delete',$crcrate->id)}}" class="delete-crc" onclick="return confirm('Are you sure you want to Delete?');">
                      <button
                      type="button" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></a>
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
