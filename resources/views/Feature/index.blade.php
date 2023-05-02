@extends('layouts.backend.containerlist')

 @section('footer_js')
<script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
@endsection
@section('title')
<p class="h4 align-center mb-0">Features</p>
@endsection

@section('dynamicdata')

<div class="box">
    <div class="box-header with-border c-btn-right d-flex-row ">
        <div class="justify-content-end list-group list-group-horizontal ">
            <a href="{{route('admin.feature.create')}}">
                <button class="btn btn-primary c-primary-btn add-modal shadow-none mx-2" data-toggle="modal" data-target="#addNewUserModal">
                    {{-- <img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> --}}
                    &nbsp; Add New &nbsp;Feature
                </button></a>
            <a href="{{route('admin.feature.product')}}" class="btn btn-primary">Feature Products</a>
        </div>
    </div>
<div class="box-body">
  <div class="dataTables_wrapper dt-bootstrap4">
    <!-- <div class="box-header">
        <h3 class="box-title">ROLES</h3>
        <ul class="header-dropdown m-r--5 pull-right">
          <li class="dropdown" style="list-style : none;">
               <a href="{{ route('admin.privilege.role.create') }}"><button type="button" class="btn btn-primary waves-effect">ADD NEW <b>+</b></button></a>
            </li>
        </ul>
      </div>

    </.box-header -->

    <div class="box-body">

        @include('layouts.backend.alert')
      <table id="example1" class="table table-bordered table-hover role-table">
        <thead>
          <tr>
            <th>SN</th>
            <th>Feature Name:</th>
            <th>Code:</th>

            <th width="220px">Actions</th>
          </tr>
        </thead>
        <tbody id="tablebody">

          @foreach($feature as $index=>$pro)
          <tr class="gradeX" id="row_{{ $pro->id }}">
            <td class="index">
              {{ ++$index }}
            </td>
            <td class="name">
              {{ $pro->name }}
            </td>
            <td class="name">
                {{ $pro->code }}
              </td>

            <td class="justify-content-center">
                <a href="featureEdit/{{$pro->id}}" id="{{ $pro->id }}"
                title="Edit "><button class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></button></a>&nbsp;
                <a href='featureList/{{  $pro->id }}' class="delete-discount" onclick="return confirm('Are you sure you want to Delete?');">
                <button
                type="button" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->

    <!-- /.box -->
    @endsection
  </div>
</div>
</div>
@section('footer_js')
<script type="text/javascript">
  $(document).ready(function() {
        var oTable = $('.role-table').dataTable();

        $('#tablebody').on('click', '.delete-discount', function(e){
        e.preventDefault();
        $object = $(this);
        var id = $object.attr('id');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function() {
            $.ajax({
                type: "DELETE",
                url: "{{ url('discountList') }}"+"/"id,
                dataType: 'json',
                success: function(response){
                    var nRow = $($object).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                    swal('success', response.message, 'success').catch(swal.noop);
                },
                error: function(e){
                    swal('Oops...', 'Something went wrong!', 'error').catch(swal.noop);
                }
            });
        }).catch(swal.noop);
        });
    });
</script>
@endsection
