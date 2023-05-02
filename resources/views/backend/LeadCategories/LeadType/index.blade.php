@extends('layouts.backend.containerlist')
@section('title')
<p class="h4 align-center mb-0">Lead Types</p>
@endsection
@section('dynamicdata')
<div class="box">
    <div class="box-header with-border c-btn-right d-flex-row ">
        <div class="justify-content-end list-group list-group-horizontal ">
            <button class="btn btn-primary c-primary-btn add-modal shadow-none mx-2" data-toggle="modal" data-target="#addNewUserModal">
                {{-- <img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> --}}
                 &nbsp; Add New &nbsp;
            </button>
        </div>
    </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('layouts.backend.alert')
              <table id="example1" class="table table-bordered table-striped role-table leadtype-table">
                <thead>
                <tr>
                  <th>SN</th>
                  <th>Lead Type</th>
                  <th class="dt-center">Status</th>
                  <th class="dt-center" >Actions</th>
                </tr>
                </thead>
                <tbody id="tablebody">
                @foreach($leadtypes as $leadtype)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $leadtype->type }}</td>
                  <td class="dt-center">
                    @if($leadtype->is_active == 1)
                      <small class="label bg-green leads-status-btn leads-status-btn-active">Active</small>
                    @else
                      <small class="label bg-red leads-status-btn leads-status-btn-inactive">Inactive</small>
                    @endif
                  </td>
                  <td class="justify-content-center">
                    <a href="javascript:;" title="Edit leadtype" class="edit-modal"><button class="btn btn-primary btn-flat" data-type="{{$leadtype->type}}" data-is_active="{{$leadtype->is_active}}" data-leadtypeid="{{$leadtype->id}}" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></button></a>&nbsp;
                    <a href="javascript:;" title="Delete leadtype" class="delete-leadtype" id="{{ $leadtype->id }}"><button class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

<!-- Modal form to add a leadtype -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h4 class="modal-title">Add Lead Type</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.leadcategories.leadtypes.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label " for="type">Lead Type:<span style="color: red;"> *</span></label>
                            <div class="">
                                <input type="text" class="form-control" name="type" autofocus>
                            </div>
                        </div>
                 
                        <div class="form-group">
                            <label class="control-label " for="content">Status:</label>
                            <div class="">
                                <select name="is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer pt-2 pb-0 px-0">
                            <button type="button" class="btn btn-light shadow-none border-2 bg-transparent" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> Close
                            </button>
                            <button type="submit" class="btn btn-primary add shadow-sm px-4 border-2 m-0">
                                <span id="" class='glyphicon'></span> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a leadtype -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h4 class="modal-title">Edit Lead Type</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.leadcategories.leadtypes.update','type') }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}

                        <input type="hidden" name="leadtype_id" id="leadtype_id" value="">
                        <div class="form-group">
                            <label class="control-label " for="type">Lead Type:<span style="color: red;"> *</span></label>
                            <div class="">
                                <input type="text" class="form-control" name="type" id="type" autofocus>
                            </div>
                        </div>
                 
                        <div class="form-group">
                            <label class="control-label " for="content">Status:</label>
                            <div class="">
                                <select name="is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer pt-2 pb-0 px-0">
                            <button type="button" class="btn btn-light shadow-none border-2 bg-transparent"
                                data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> Close
                            </button>
                            <button type="submit" class="btn btn-success add shadow-sm px-4 border-2 m-0">
                                <span id="" class='glyphicon'></span> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.add-modal', function() {
            $('#addModal').modal('show');
        });
        
       

        $('#editModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
        var type = button.data('type') 
        var is_active = button.data('is_active') 
      var leadtype_id = button.data('leadtypeid') 
      var modal = $(this)
      modal.find('.modal-body #type').val(type);
      modal.find('.modal-body #is_active').val(is_active);
      modal.find('.modal-body #leadtype_id').val(leadtype_id);        
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var oTable = $('.leadtype-table').dataTable();

        $('#tablebody').on('click', '.delete-leadtype', function(e){
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
                    url: "{{ url('/admin/leadcategories/leadtypes/') }}"+"/"+id,
                    dataType: 'json',
                    success: function(response){
                        var nRow = $($object).parents('tr')[0];
                        oTable.fnDeleteRow(nRow);
                        swal('success', response.message, 'success');
                    },
                    error: function(e){
                        swal('Oops...', 'Something went wrong!', 'error');
                    }
                });
            });
        });
    });
</script>
@endsection
