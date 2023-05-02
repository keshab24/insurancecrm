@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Permissions</p>
@endsection

@section('dynamicdata')

    <div class="box">

        <div class="box-body">
            <div class="dataTables_wrapper dt-bootstrap4">
                <div class="box-header">
                    <h3 class="box-title">Permission</h3>
                    <ul class="header-dropdown m-r--5 pull-right">
                        <li class="dropdown" style="list-style : none;">
                            <a href="{{ route('admin.privilege.permission.create') }}"><button type="button" class="btn btn-primary waves-effect">ADD NEW <b>+</b></button></a>
                            <a href="{{ route('admin.privilege.permission_roles.create')}}" class="btn btn-primary waves-effectwaves-effect" title="Assign Permission">Assign Permission <b>+</b></a>
                        </li>
                    </ul>
                </div>

            </.box-header>
            <div class="box-body">

                @include('layouts.backend.alert')

                <table id="example1" class="table table-bordered table-hover permission-table">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Permission Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th class="dt-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">

                    @foreach($permissions as $index=>$permission)
                        <tr class="gradeX" id="row_{{ $permission->id }}">
                            <td class="index">
                                {{ ++$index }}
                            </td>
                            <td class="display_name">
                                {{ $permission->name }}
                            </td>
                            <td class="name">
                                {{ $permission->display_name }}
                            </td>
                            <td class="name">
                                {{ $permission->description }}
                            </td>
                            <td class="justify-content-center">

                                <a href="{{ route('admin.privilege.permission.edit', $permission->id) }}" id="{{ $permission->id }}"
                                   title="Edit Permission"><button class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></button></a>&nbsp;

                                <a href="javascript:;" title="Delete permission" class="delete-permission" id="{{ $permission->id }}"><button
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
            var oTable = $('.permission-table').dataTable();

            $('#tablebody').on('click', '.delete-permission', function(e){
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
                        url: "{{ url('/admin/privilege/permission') }}"+"/"+id,
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
