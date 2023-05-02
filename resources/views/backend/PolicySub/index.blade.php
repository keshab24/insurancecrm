@extends('layouts.backend.containerlist')
@section('title')
<p class="h4 align-center mb-0">Policy Sub-Categories</p>
@endsection
@section('dynamicdata')
<div class="box">
    {{-- <div class="box-header with-border d-flex ">
        <a href="javascript:;" class="add-modal align-self-center justify-content-center justify-content-end">
            <button class="btn btn-primary shadow-none ">Add New Policy Sub Category &nbsp;<i class="fa fa-plus-circle"></i></button>
        </a>
    </div> --}}

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
        <table id="example1" class="table table-bordered table-striped role-table policysub-table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Policy Category Name</th>
                    <th>Policy Sub Category Name</th>
                    <th class="dt-center">Status</th>
                    <th class="dt-center">Actions</th>
                </tr>
            </thead>
            <tbody id="tablebody">
                @foreach($datas as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->policy_cat_id }}</td>
                    <td>{{ $data->subcat_name }}</td>
                    <td class="dt-center">
                        @if($data->is_active == 1)
                        <small
                            class="label bg-green leads-status-btn leads-status-btn-active">Active</small>
                        @else
                        <small
                            class="label bg-red leads-status-btn leads-status-btn-inactive">Inactive</small>
                        @endif
                    </td>
                    <td class="justify-content-center">
                        <a href="javascript:;" title="Edit Policy Sub Category" class="edit-modal"><button
                                class="btn btn-primary btn-flat" data-policy_cat_id="{{$data->policy_cat_id}}"
                                data-is_active="{{$data->is_active}}" data-subcat_name="{{$data->subcat_name}}"
                                data-sub_id="{{$data->id}}" data-toggle="modal" data-target="#editModal"><i
                                    class="fa fa-edit"></i></button></a>&nbsp;
                        <a href="javascript:;" title="Delete policysub" class="delete-policysub"
                            id="{{ $data->id }}"><button class="btn btn-danger btn-flat"><i
                                    class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Policy Category Name</th>
                    <th>Policy Sub Category Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </tfoot> --}}
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<!-- Modal form to add a policysub -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex">
                <h4 class="modal-title">Add Policy Sub Category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST"
                    action="{{ route('admin.policycategories.sub.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label" for="policy_cat_id">Policy Category</label>
                        <div class="">
                            <select class="form-control" name="policy_cat_id">
                                <option value="0" disabled selected>Select Policy Category</option>
                                @foreach($policy_categories as $policy_categorie)
                                <option value="{{ $policy_categorie->id }}">{{ $policy_categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="subcat_name">Policy Sub Category:<span style="color: red;">
                                *</span></label>
                        <div class="">
                            <input type="text" class="form-control" name="subcat_name" id="subcat_name" autofocus>
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
                <h4 class="modal-title">Edit Policy Sub Category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST"
                    action="{{ route('admin.policycategories.sub.update','sub') }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH')}}

                    <input type="hidden" name="sub_id" id="sub_id" value="">
                    <div class="form-group">
                        <label class="control-label" for="policy_cat_id">Policy Category</label>
                        <div class="">
                            <select class="form-control" name="policy_cat_id" id="policy_cat_id">
                                <option value="0" disabled selected>Select Policy Category</option>
                                @foreach($policy_categories as $policy_categorie)
                                <option value="{{ $policy_categorie->id }}">{{ $policy_categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="subcat_name">Policy Sub Category:<span style="color: red;">
                                *</span></label>
                        <div class="">
                            <input type="text" class="form-control" name="subcat_name" id="subcat_name" autofocus>
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
        var subcat_name = button.data('subcat_name') 
        var sub_id = button.data('sub_id')
        var is_active = button.data('is_active') 
      var policy_cat_id = button.data('policy_cat_id') 
      var modal = $(this)
      modal.find('.modal-body #subcat_name').val(subcat_name);
      modal.find('.modal-body #sub_id').val(sub_id);
      modal.find('.modal-body #is_active').val(is_active);
      modal.find('.modal-body #policy_cat_id').val(policy_cat_id);        
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var oTable = $('.policysub-table').dataTable();

        $('#tablebody').on('click', '.delete-policysub', function(e){
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
                    url: "{{ url('/admin/policycategories/sub/') }}"+"/"+id,
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