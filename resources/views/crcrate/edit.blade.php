@extends('layouts.backend.containerform')

@section('footer_js')

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
        <h3 class="box-title">CRC rate of child :{{$company->name}}</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')

        <form class="form-inline" action="{{ route('crcrate.update',$crcrate->id) }}" method="post">
            @csrf
            {{ method_field('PUT') }}
            <input type="hidden" name="_method" value="PUT">
            <label class="sr-only" for="inlineFormInputGroupUsername2">Age</label>
            <div class="input-group mb-2 mr-sm-2">

                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Age.."
                    name="age_id" value="{{$crcrate->age->age}}">
            </div>

            <label class="sr-only" for="inlineFormInputName2">One Time Charge</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2"
                placeholder="one time charge.." name="one_time_charge" value="{{ $crcrate->one_time_charge}}">

            <select class="form-control input-medium search-select" onchange="findProduct()" id="company"
                name="company_id" required>
                <option selected disabled>Select the Company</option>
                @foreach ($companies as $company1)
                <option data-products="{{$company->child_products()}}" value="{{ $company1->id }}" @if ($company1->id ==
                    $company->id) selected @endif>{{ $company1->name }}</option>
                @endforeach
            </select>

            <select class="form-control form-control-inline input-medium search-select" id="products" name="product_id"
                required>
                @foreach ($company->child_products() as $prd)
                <option @if($prd->id == $product->id) selected @endif value="{{ $prd->id }}">{{ $prd->name }}</option>
                @endforeach


            </select>

            <button type="submit" class="btn btn-primary ml-2 mt-2 mb-2">Update</button>
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

                <td>{{$crcrate->age->age}}</td>
                <td>{{$crcrate->one_time_charge}}</td>

                <td> @isset($crcrate->company){{ $crcrate->company->name}} @endisset</td>
                <td> @isset($crcrate->product){{ $crcrate->product->name}} @endisset</td>
                <td class="justify-content-center">
                    {{-- <a class="edit-role" href="{{ route('admin.privilege.role.edit', $role->id) }}"
                    id="{{ $role->id }}"
                    title="Edit Role">
                    &nbsp;<i class="fa fa-pencil"></i>
                    </a>&nbsp; --}}

                    <a href="{{ route('crcrate.edit',['crcrate'=> $crcrate->id]) }}" id="{{ $crcrate->id }}"
                        title="Edit "><button class="btn btn-primary btn-flat"><i
                                class="fa fa-edit"></i></button></a>&nbsp;
                    <a href='{{route('crcrate.destroy', ['crcrate' => $crcrate->id])}}' class="delete-crc"
                        onclick="return confirm('Are you sure you want to Delete?');">
                        <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></a>

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
