@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Permission Roles</p>
@endsection
@section('dynamicdata')
    <section class="content-header">
        <h1>
            Permission_roles
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Permission_roles</a></li>

        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('admin.privilege.permission_roles.create') }}" class="btn bg-green waves-effect"
                           title="create">Create</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="permission_role-datatable" class="table table-striped table-bordered">
                            <thead>
                            <th>SN</th>
                            <th>Permission_id</th>
                            <th>Role_id</th>
                            <th>Action</th>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script language="javascript" type="text/javascript">
        var dataTable;
        var site_url = window.location.href;
        $(function () {
            dataTable = $('#permission_role-datatable').DataTable({
                dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-8 text-right'p>>",
                serverSide: true,
                processing: true,
                'ajax': {
                    url: "{{ route('permission_roles.getdatajson') }}",
                    type: 'get',
                    data: {'_token': '{{ csrf_token() }}'}
                },
                columns: [
                    {
                        data: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }, name: "sn", searchable: false
                    },
                    {data: "permission_id", name: "permission_id"},
                    {data: "role_id", name: "role_id"},

                    {
                        data: function (data, b, c, table) {
                            var buttons = '';

                            buttons += "<a class='btn bg-red waves-effect' href='" + site_url + "/edit/" + data.id + "' type='button' >Edit</a>&nbsp";

                            buttons += "<a href='" + site_url + "/delete/" + data.id + "' class='btn bg-red waves-effect' >Delete</a>";

                            return buttons;
                        }, name: 'action', searchable: false
                    },
                ]
            });
        });


    </script>
@endsection
