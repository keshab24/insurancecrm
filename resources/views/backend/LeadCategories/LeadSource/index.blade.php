@extends('layouts.backend.containerlist')
@section('title')
<p class="h4 align-center mb-0">Lead Sources</p>
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


      
  
            {{-- <div class="box-header with-border">
              <a href="javascript:;" class="add-modal"><button class="btn btn-primary">Add New LeadSource &nbsp;<i class="fa fa-plus"></i></button></a>
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body">
              @include('layouts.backend.alert')
              <table id="example1" class="table table-bordered table-striped role-table leadsource-table">
                <thead>
                <tr>
                  <th>SN</th>
                  <th>Lead Source Name</th>
                  <th class="dt-center" >Status</th>
                  <th class="dt-center">Actions</th>
                </tr>
                </thead>
                <tbody id="tablebody">
                @foreach($leadsources as $leadsource)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $leadsource->name }}</td>
                  <td class="dt-center">
                    @if($leadsource->is_active == 1)
                      <small class="label bg-green  leads-status-btn leads-status-btn-active">Active</small>
                    @else
                      <small class="label bg-red  leads-status-btn leads-status-btn-inactive">Inactive</small>
                    @endif
                  </td>
                  <td class="justify-content-center c-action-btn">
                    <a href="javscript:;" title="Edit leadsource" class="edit-modal"><button class="btn btn-primary btn-flat" data-name="{{$leadsource->name}}" data-is_active="{{$leadsource->is_active}}" data-leadsourceid="{{$leadsource->id}}" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></button></a>&nbsp;

                    <a href="javascript:;" title="Delete leadsource" class="delete-leadsource" id="{{ $leadsource->id }}"><button class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

<!-- Modal form to add a leadsource -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h4 class="modal-title">Add Lead Source</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.leadcategories.leadsource.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label" for="name">Lead Source Name:<span style="color: red;"> *</span></label>
                            <div class="">
                                <input type="text" class="form-control" name="name" autofocus>
                            </div>
                        </div>
                 
                        <div class="form-group">
                            <label class="control-label" for="content">Status:</label>
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

    <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <h4 class="modal-title">Edit Lead Source</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.leadcategories.leadsource.update','lead') }}">
                               
                                {{csrf_field()}}
                                {{method_field('patch')}}
                                <input type="hidden" name="leadsource_id" id="leadsource_id" value="">
			
                            <div class="form-group">
                                <label class="control-label" for="name">Lead Source Name:<span style="color: red;"> *</span></label>
                                <div class="">
                                    <input type="text" class="form-control" id="name" name="name" value="" autofocus>
                                </div>
                            </div>
                     
                            <div class="form-group">
                                <label class="control-label" for="content">Status:</label>
                                <div class="">
                                    <select name="is_active" class="form-control" id="is_active">
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
        var name = button.data('name') 
        var is_active = button.data('is_active') 
      var leadsource_id = button.data('leadsourceid') 
      var modal = $(this)
      modal.find('.modal-body #name').val(name);
      modal.find('.modal-body #is_active').val(is_active);
      modal.find('.modal-body #leadsource_id').val(leadsource_id);        
      });
    });
</script>


  

<script type="text/javascript">
    $(document).ready(function() {
        var oTable = $('.leadsource-table').dataTable();

        $('#tablebody').on('click', '.delete-leadsource', function(e){
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
                    url: "{{ url('/admin/leadcategories/leadsource/') }}"+"/"+id,
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
